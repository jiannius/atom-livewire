<?php

namespace Jiannius\Atom\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jiannius\Atom\Traits\Models\HasFilters;
use Jiannius\Atom\Traits\Models\HasShareable;
use Jiannius\Atom\Traits\Models\HasTrace;

class Document extends Model
{
    use HasFactory;
    use HasFilters;
    use HasShareable;
    use HasTrace;

    protected $guarded = [];

    protected $casts = [
        'subtotal' => 'float',
        'discount_total' => 'float',
        'tax_total' => 'float',
        'paid_total' => 'float',
        'grand_total' => 'float',
        'splitted_total' => 'float',
        'data' => 'object',
        'contact_id' => 'integer',
        'revision_for_id' => 'integer',
        'converted_from_id' => 'integer',
        'splitted_from_id' => 'integer',
        'issued_at' => 'date',
        'due_at' => 'date',
        'last_sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The "booted" method for model
     */
    protected static function booted()
    {
        static::saving(function($document) {
            $document->number = $document->prefix.$document->postfix.($document->rev ? '.'.$document->rev : '');
            $document->issued_at = $document->issued_at ?? now();
        });
    }

    /**
     * Get contact for document
     */
    public function contact()
    {
        return $this->belongsTo(get_class(model('contact')));
    }

    /**
     * Get revision for document
     */
    public function revisionFor()
    {
        return $this->belongsTo(get_class(model('document')), 'revison_for_id');
    }

    /**
     * Get converted from for document
     */
    public function convertedFrom()
    {
        return $this->belongsTo(get_class(model('document')), 'converted_from_id');
    }

    /**
     * Get splitted from for document
     */
    public function splittedFrom()
    {
        return $this->belongsTo(get_class(model('document')), 'splitted_from_id');
    }

    /**
     * Get items for document
     */
    public function items()
    {
        return $this->hasMany(get_class(model('document_item')));
    }

    /**
     * Get files for document
     */
    public function files()
    {
        return $this->belongsToMany(get_class(model('file')), 'document_files');
    }

    /**
     * Get emails for document
     */
    public function emails()
    {
        return $this->hasMany(get_class(model('document_email')));
    }

    /**
     * Get payments for document
     */
    public function payments()
    {
        return $this->hasMany(get_class(model('document_payment')));
    }

    /**
     * Get splits for document
     */
    public function splits()
    {
        return $this->hasMany(get_class(model('document')), 'splitted_from_id');
    }

    /**
     * Scope for search
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(fn($q) => $q
            ->where('documents.number', $search)
            ->orWhere('documents.name', 'like', "%$search%")
        );
    }

    /**
     * Get status attribute
     */
    public function getStatusAttribute()
    {
        if ($this->delivered_at) return 'delivered';
        if ($this->due_at && ($this->due_at->isPast() || $this->due_at->isToday())) return 'due';
        if ($this->issued_at && $this->issued_at->isFuture() && $this->type === 'invoice') return 'pending';

        if ($validfor = data_get($this->data, 'valid_for')) {
            if ($this->issued_at->addDays($validfor)->isPast()) return 'expired';
        }

        if ($this->last_sent_at) return 'sent';

        if ($this->paid_total > 0 && $this->paid_total >= $this->splitted_total) return 'paid';
        elseif ($this->paid_total > 0 && $this->paid_total >= $this->grand_total) return 'paid';
        elseif ($this->paid_total > 0) return 'partial';

        return [
            'invoice' => 'unpaid',
            'bill' => 'unpaid',
            'delivery-order' => 'pending',
        ][$this->type] ?? 'draft';
    }

    /**
     * Get taxes
     */
    public function getTaxes()
    {
        $items = $this->splittedFrom
            ? $this->splittedFrom->items
            : $this->items;

        $taxes = $items->map(fn($item) => $item->taxes)->collapse()->map(fn($tax) => [
            'id' => $tax->id, 
            'amount' => $tax->pivot->amount, 
            'label' => $tax->label,
        ]);

        return $taxes->unique('id')->map(fn($tax) => array_merge($tax, [
            'amount' => $taxes->where('id', data_get($tax, 'id'))->sum('amount')
        ]));
    }

    /**
     * Get converted total
     */
    public function getConvertedTotal($key = null)
    {
        if (!auth()->user()) return;

        $totals = collect($this->only([
            'subtotal', 
            'discount_total', 
            'tax_total', 
            'paid_total', 
            'grand_total',
            'splitted_total',
        ]))->map(fn($n) => $n * ($this->currency_rate ?? 1));

        return $key ? $totals->get($key) : $totals;
    }

    /**
     * Get columns
     */
    public function getColumns()
    {
        $cols = array_merge(
            [
                'item_name',
                'item_description',
                'item_category',
                'qty',
            ],
            $this->type === 'delivery-order'
                ? []
                : [
                    'price',
                    'total',
                    'tax',
                ]
        );

        return collect($cols)->mapWithKeys(fn($value) => [
            $value => str($value)->headline()->toString(),
        ])->filter();
    }

    /**
     * Set summary
     */
    public function setSummary()
    {
        $this->fill([
            'summary' => str()->limit($this->items->pluck('name')->join(', '), 200)
        ])->saveQuietly();
    }

    /**
     * Set prefix and postfix
     */
    public function setPrefixAndPostfix()
    {
        $prefix = str(account_settings($this->type.'.prefix'))
            ->replace('%y', date('y'))
            ->replace('%m', date('m'))
            ->replace('%d', date('d'))
            ->toString();

        $query = model('document')
            ->when(
                model('document')->enabledBelongsToAccountTrait,
                fn($q) => $q->where('account_id', $this->account_id),
            )
            ->where('type', $this->type)
            ->whereNull('rev');

        $dup = true;
        $postfix = null;
        $latest = (clone $query)->latest('id')->first();

        while ($dup) {
            if ($latest) {
                if (is_numeric($latest->postfix)) $postfix = $latest->postfix + 1;
                else $postfix = str()->random(6);
            }
            else $postfix = 1;

            $postfix = str()->padLeft($postfix, 6, '0');
            $dup = (clone $query)->where('prefix', $prefix)->where('postfix', $postfix)->count() > 0;
        }

        $this->fill(compact('prefix', 'postfix'));
    }

    /**
     * Sum total
     */
    public function sumTotal()
    {
        $subtotal = $this->items()->sum('subtotal');
        $taxTotal = $this->getTaxes()->sum('amount');
        $paidTotal = $this->payments()->sum('amount');

        $this->fill([
            'subtotal' => $subtotal,
            'tax_total' => $taxTotal,
            'paid_total' => $paidTotal,
            'grand_total' => $subtotal + $taxTotal,
        ])->saveQuietly();
    }

    /**
     * Sync splits
     */
    public function syncSplits()
    {
        if (!$this->splits->count()) return;

        foreach ($this->splits as $split) {
            $split->fill([
                'prefix' => $this->prefix,
                'postfix' => $this->postfix,
                'name' => $this->name,
                'address' => $this->address,
                'person' => $this->person,
                'reference' => $this->reference,
                'description' => $this->description,
                'summary' => $this->summary,
                'currency' => $this->currency,
                'currency_rate' => $this->currency_rate,
                'subtotal' => $this->subtotal,
                'discount_total' => $this->discount_total,
                'tax_total' => $this->tax_total,
                'grand_total' => $this->grand_total,
                'splitted_total' => $this->grand_total * (($split->data->percentage ?? 0)/100),
                'footer' => $this->footer,
                'note' => $this->note,
                'project_id' => $this->project_id,
                'contact_id' => $this->contact_id,
                'shareable_id' => $this->shareable_id,
                'revision_for_id' => $this->revision_for_id,
                'converted_from_id' => $this->converted_from_id,
            ])->saveQuietly();

            $this->fill([
                'splitted_total' => $this->grand_total * (($this->data->percentage ?? 0)/100),
            ])->saveQuietly();
        }
    }

    /**
     * Pdf
     */
    public function pdf()
    {
        $filename = $this->type.'-'.$this->number.'.pdf';
        $path = storage_path($filename);

        pdf('atom::pdf.document', [
            'document' => $this,
            'filename' => $filename,
        ])->save($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}

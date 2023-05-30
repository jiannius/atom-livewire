<?php

namespace Jiannius\Atom\Http\Livewire\App\Plan\Payment;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Jiannius\Atom\Traits\Livewire\WithTable;
use Livewire\Component;

class Listing extends Component
{
    use WithTable;

    public $sort;
    public $fullpage;
    public $filters = ['search' => null];

    /**
     * Mount
     */
    public function mount(): void
    {
        if ($this->fullpage = current_route('app.plan.payment.listing')) {
            breadcrumbs()->home($this->title);
        }
    }

    /**
     * Get title propert
     */
    public function getTitleProperty(): string
    {
        return $this->fullpage ? 'Plan Payments' : 'Payment History';
    }

    /**
     * Get query property
     */
    public function getQueryProperty(): Builder
    {
        return model('plan_payment')
            ->readable()
            ->filter($this->filters)
            ->when(!$this->sort, fn($q) => $q->latest());
    }

    /**
     * Get table columns
     */
    public function getTableColumns($query): array
    {
        return [
            [
                'name' => 'Date',
                'sort' => 'created_at',
                'datetime' => $query->created_at,
            ],
            
            [
                'name' => 'Receipt',
                'sort' => 'number',
                'label' => $query->number,
                'href' => route('app.plan.payment.update', [$query->id]),
            ],
            
            [
                'name' => 'Amount',
                'sort' => 'amount',
                'amount' => $query->amount,
                'currency' => $query->currency,
            ],

            [
                'name' => 'Status',
                'status' => array_filter([
                    $query->status,
                    $query->is_auto_billing ? 'auto' : null,
                ]),
            ],

            [
                'name' => 'User',
                'label' => optional($query->user)->name,
            ],
        ];
    }

    /**
     * Render
     */
    public function render(): mixed
    {
        return atom_view('app.plan.payment.listing');
    }
}
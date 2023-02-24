<?php

namespace Jiannius\Atom\Models;

use Jiannius\Atom\Traits\Models\HasFilters;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFilters;
    
    protected $guarded = [];

    protected $casts = [
        'price' => 'float',
        'stock' => 'integer',
        'seq' => 'integer',
        'is_default' => 'boolean',
        'is_active' => 'boolean',
        'image_id' => 'integer',
        'product_id' => 'integer',
    ];
    
    /**
     * Get product for product variant
     */
    public function product()
    {
        return $this->belongsTo(model('product'));
    }

    /**
     * Get image for product variant
     */
    public function image()
    {
        return $this->belongsTo(model('file'), 'image_id');
    }

    /**
     * Generate code
     */
    public function generateCode()
    {
        $code = null;
        $dup = true;

        while ($dup) {
            $code = str()->upper(str()->random(6));
            $dup = model('product')->readable()->where('code', $code)->count() > 0
                || model('product_variant')
                    ->whereHas('product', fn($q) => $q->readable())
                    ->where('code', $code)->count() > 0;
        }

        return $code;
    }
}

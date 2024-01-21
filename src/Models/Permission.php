<?php

namespace Jiannius\Atom\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permission extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    // booted
    protected static function booted() : void
    {
        static::saved(function($permission) {
            $permission->user->cache(false);
        });
    }

    // get user for permission
    public function user(): BelongsTo
    {
        return $this->belongsTo(model('user'));
    }
    
    // get permissions
    public function permissions() : array
    {
        return [
            //
        ];
    }
}

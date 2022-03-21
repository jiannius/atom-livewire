<?php

namespace Jiannius\Atom\Models;

use App\Models\User;
use Jiannius\Atom\Traits\HasTrace;
use Jiannius\Atom\Traits\HasFilters;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasTrace;
    use HasFilters;
    use SoftDeletes;
    
    protected $guarded = [];

    protected $casts = [
        'data' => 'object',
        'agree_tnc' => 'boolean',
        'agree_marketing' => 'boolean',
        'onboarded_at' => 'datetime',
    ];

    /**
     * Get users for account
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get setting for account
     */
    public function setting()
    {
        return $this->hasOne(AccountSetting::class);
    }

    /**
     * Get orders for account
     */
    public function orders()
    {
        return $this->hasMany(AccountOrder::class);
    }

    /**
     * Get subscriptions for account
     */
    public function subscriptions()
    {
        return $this->hasMany(AccountSubscription::class);
    }

    /**
     * Scope for fussy search
     * 
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(fn($q) => $q
            ->where('name', 'like', "%$search%")
            ->where('email', 'like', "%$search%")
        );
    }

    /**
     * Get status attribute
     * 
     * @return string
     */
    public function getStatusAttribute()
    {
        if ($this->trashed()) return 'trashed';
        if ($this->blocked()) return 'blocked';

        if ($this->type === 'signup') {
            if ($this->onboarded_at) return 'onboarded';
            else return 'new';
        }

        return 'active';
    }

    /**
     * Onboard account
     * 
     * @return void
     */
    public function onboard()
    {
        $this->onboarded_at = now();
        $this->saveQuietly();
    }
}

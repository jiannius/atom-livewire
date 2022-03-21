<?php

namespace Jiannius\Atom\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Jiannius\Atom\Traits\HasTrace;
use Jiannius\Atom\Traits\HasFilters;
use Jiannius\Atom\Notifications\ActivateAccountNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;
    use HasFactory;
    use HasApiTokens;
    use HasTrace;
    use HasFilters;

    protected $guarded = ['password'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'account_id' => 'integer',
        'activated_at' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

    const ROOT_EMAIL = 'root@jiannius.com';

    /**
     * Get account for user
     */
    public function account()
    {
        return $this->belongsTo(get_class(model('account')));
    }

    /**
     * Get role for user
     */
    public function role()
    {
        if (!enabled_module('roles')) return;

        return $this->belongsTo(get_class(model('role')));
    }

    /**
     * Get permissions for user
     */
    public function permissions()
    {
        if (!enabled_module('permissions')) return;

        return $this->hasMany(get_class(model('user_permission')));
    }
    
    /**
     * Get teams for user
     */
    public function teams()
    {
        if (!enabled_module('teams')) return;

        return $this->belongsToMany(get_class(model('team')), 'teams_users');
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
            ->orWhere('email', 'like', "%$search%")
            ->orWhereHas('account', fn($q) => $q->search($search))
        );
    }

    /**
     * Scope for is role
     * 
     * @param Builder $query
     * @param string $name
     * @return Builder
     */
    public function scopeWhereIsRole($query, $name)
    {
        if (!enabled_module('roles')) abort_module('roles');

        return $query->whereHas('role', fn($q) => $q->where('slug', $name));
    }

    /**
     * Scope for team id
     * 
     * @param Builder $query
     * @param integer $id
     * @return Builder
     */
    public function scopeTeamId($query, $id)
    {
        if (!enabled_module('teams')) abort_module('teams');

        return $query->whereHas('teams', fn($q) => $q->whereIn('teams.id', (array)$id));
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
        
        if ($this->activated_at) return 'active';
        else return 'inactive';
    }

    /**
     * Check user is root
     * 
     * @return boolean
     */
    public function isRoot()
    {
        return $this->account->type === 'root';
    }

    /**
     * Check user is role
     * 
     * @param mixed $names
     * @return boolean
     */
    public function isRole($names)
    {
        if (!enabled_module('roles')) abort_module('roles');
        if (!$this->role) return false;

        return collect((array)$names)->filter(function($name) {
            $substr = str()->slug(str_replace('*', '', $name));

            if (str()->startsWith($name, '*')) return str()->endsWith($this->role->slug, $substr);
            else if (str()->endsWith($name, '*')) return str()->startsWith($this->role->slug, $substr);
            else return $this->role->slug === $name;
        })->count() > 0;
    }

    /**
     * Invite user to activate account
     * 
     * @return void
     */
    public function sendAccountActivation()
    {
        if ($this->status === 'inactive') {
            $this->notify(new ActivateAccountNotification());
        }
    }

    /**
     * Send password reset link
     * 
     * @return void
     */
    public function sendPasswordResetLink()
    {
        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) return $status;
        else return false;
    }

    /**
     * Check user can access app portal
     * 
     * @return boolean
     */
    public function canAccessAppPortal()
    {
        return Route::has('app.home') && in_array($this->account->type, [
            'root',
            'system',
        ]);
    }

    /**
     * Check user can access billing portal
     * 
     * @return boolean
     */
    public function canAccessBillingPortal()
    {
        return Route::has('billing') 
            && model('plan')->whereIsActive(true)->count() > 0
            && in_array($this->account->type, [
                'root',
                'signup',
            ]);
    }

    /**
     * Check user can access ticketing portal
     * 
     * @return boolean
     */
    public function canAccessTicketingPortal()
    {
        return Route::has('ticketing.listing') && in_array($this->account->type, [
            'root',
            'signup',
            'system',
        ]);
    }

    /**
     * Check user can access onboarding portal
     * 
     * @return boolean
     */
    public function canAccessOnboardingPortal()
    {
        return Route::has('onboarding') && in_array($this->account->type, [
            'root',
            'signup',
        ]);
    }
}

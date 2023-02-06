<?php

namespace Jiannius\Atom\Traits\Models;

use Illuminate\Support\Facades\Schema;

trait HasTrace
{
    public $enabledHasTraceTrait = true;

    /**
     * Model boot method
     * 
     * @return void
     */
    protected static function bootHasTrace()
    {
        static::creating(function ($model) {
            $table = $model->getTable();

            if ($id = auth()->user()->id ?? null) {
                if (Schema::hasColumn($table, 'owned_by')) $model->owned_by = $id;
                if (Schema::hasColumn($table, 'created_by')) $model->created_by = $id;
                if (Schema::hasColumn($table, 'updated_by')) $model->updated_by = $id;
            }
        });

        static::updating(function ($model) {
            $table = $model->getTable();

            if ($id = auth()->user()->id ?? null) {
                if (Schema::hasColumn($table, 'updated_by')) $model->updated_by = $id;
                if (Schema::hasColumn($table, 'owned_by') && !$model->owned_by) {
                    $model->owned_by = $model->created_by;
                }
            }
        });

        static::deleted(function ($model) {
            $table = $model->getTable();

            if (Schema::hasColumn($table, 'deleted_by') && $model->exists) {
                if ($id = auth()->user()->id ?? null) {
                    $model->deleted_by = $id;
                    $model->save();
                }
            }
        });
    }

    /**
     * Initialize the trait
     * 
     * @return void
     */
    protected function initializeHasTrace()
    {
        $this->casts['owned_by'] = 'integer';
        $this->casts['created_by'] = 'integer';
        $this->casts['updated_by'] = 'integer';
        $this->casts['deleted_by'] = 'integer';
        $this->casts['blocked_by'] = 'integer';
        $this->casts['blocked_at'] = 'datetime';
    }

    /**
     * Get owned by user for model
     */
    public function ownedBy()
    {
        return $this->belongsTo(model('user'), 'owned_by');
    }

    /**
     * Get created_by_user for model
     */
    public function createdBy()
    {
        return $this->belongsTo(model('user'), 'created_by');
    }

    /**
     * Get updated_by_user for model
     */
    public function updatedBy()
    {
        return $this->belongsTo(model('user'), 'updated_by');
    }

    /**
     * Get deleted_by_user for model
     */
    public function deletedBy()
    {
        return $this->belongsTo(model('user'), 'deleted_by');
    }

    /**
     * Get blocked_by_user for model
     */
    public function blockedBy()
    {
        return $this->belongsTo(model('user'), 'blocked_by');
    }

    /**
     * Check model is blocked
     */
    public function blocked()
    {
        return $this->blocked_at && $this->blocked_at->lessThan(now());
    }

    /**
     * Block the model
     */
    public function block()
    {
        $this->fill([
            'blocked_at' => now(),
            'blocked_by' => user('id'),
        ])->save();
    }

    /**
     * Unblock the model
     */
    public function unblock()
    {
        $this->fill([
            'blocked_at' => null,
            'blocked_by' => null,
        ])->save();
    }
}
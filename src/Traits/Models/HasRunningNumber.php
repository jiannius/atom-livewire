<?php

namespace Jiannius\Atom\Traits\Models;

use Illuminate\Support\Facades\DB;

trait HasRunningNumber
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function bootHasRunningNumber()
    {
        // listen to creating event
        static::saving(function ($model) {
            if ($model->number === 'temp') {
                $model->number = collect(['TEMP', str()->random(), time()])->join('-');
            }
            else if (!$model->number) {
                $duplicated = true;
                $table = $model->getTable();
                $prefix = $model->getPrefix();

                $last = optional(
                    DB::table($table)
                        ->when($model->usesHasTenant && tenant(), fn($q) => $q->where('tenant_id', tenant('id')))
                        ->where('number', 'not like', "TEMP-%")
                        ->latest()
                        ->first()
                )->number;

                $n = $last
                    ? (integer) str($last)->replaceFirst($prefix.'-', '')->toString()
                    : 0;

                while ($duplicated) {
                    $n = $n + 1;
                    $postfix = str()->padLeft($n, 6, '0');
                    $number = collect([$prefix, $postfix])->filter()->join('-');
                    $duplicated = DB::table($table)
                        ->when($model->usesHasTenant && tenant(), fn($q) => $q->where('tenant_id', tenant('id')))
                        ->where('number', $number)
                        ->count() > 0;
                }

                $model->number = $number;
            }
        });
    }

    /**
     * Get prefix
     */
    protected function getPrefix()
    {
        return $this->prefix ?? null;
    }
}
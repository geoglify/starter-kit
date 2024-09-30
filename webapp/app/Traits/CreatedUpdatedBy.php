<?php

namespace App\Traits;

trait CreatedUpdatedBy
{
    public static function bootCreatedUpdatedBy()
    {
        // updating created_by and updated_by when model is created
        static::creating(function ($model) {
            $user_id = auth()->user() ? auth()->user()->id : null;
            if (!$model->isDirty('created_by')) {
                $model->created_by = $user_id;
            }
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = $user_id;
            }
        });

        // updating updated_by when model is updated
        static::updating(function ($model) {
            $user_id = auth()->user() ? auth()->user()->id : null;
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = $user_id;
            }
        });
    }
}

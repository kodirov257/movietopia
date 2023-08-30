<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BaseModel extends Model
{
    public static function boot()
    {
        parent::boot();

        if ($user = Auth::user()) {
            static::creating(function ($model) use ($user) {
                $model->created_by = $user->id;
                $model->updated_by = $user->id;
            });

            static::updating(function ($model) use ($user) {
                $model->updated_by = $user->id;
                $model->updated_at = Carbon::now();
            });

            static::saving(function ($model) use ($user) {
                $model->updated_by = $user->id;
                $model->updated_at = Carbon::now();
            });
        }
    }
}

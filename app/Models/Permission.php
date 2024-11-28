<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $guarded = [];

    public function levels()
    {
        return $this->belongsToMany(Level::class, 'level_permissions')->withPivot('status');
    }
}

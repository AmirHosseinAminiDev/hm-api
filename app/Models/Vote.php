<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Vote extends Model
{
    protected $table = 'votes';

    protected $guarded = [];

    public function voteable(): MorphTo
    {
        return $this->morphTo();
    }
}

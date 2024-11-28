<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $table = 'statistics';

    protected $guarded = [];

    public function getValueByKey($key)
    {
        return $this->where('key', $key)->first()->value;
    }
}

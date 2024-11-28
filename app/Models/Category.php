<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    protected $table = 'categories';

    protected $guarded = [];

    /**
     * @return HasMany
     */
    public function question(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * @return HasOne
     */
    public function activity(): HasOne
    {
        return $this->hasOne(CategoryActivity::class);
    }
}

<?php

namespace App\Models;

use Baum\Node;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Node
{
    protected $table = 'categories';

    /**
     * @return HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

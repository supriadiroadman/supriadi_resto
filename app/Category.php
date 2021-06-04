<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'user_id'
    ];

    public $timestamps = false;

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'term_id');
    }
}

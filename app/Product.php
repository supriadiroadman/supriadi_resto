<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title', 'slug', 'lang', 'auth_id', 'status', 'type', 'count'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product', 'term_id', 'category_id');
    }

    public function price()
    {
        return $this->hasOne(Price::class, 'term_id');
    }

    public function preview()
    {
        return $this->hasOne(Preview::class, 'term_id');
    }

    public function stock()
    {
        return $this->hasOne(Stock::class, 'term_id');
    }
}

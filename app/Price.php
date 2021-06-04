<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = [
        'term_id', 'price',
    ];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class, 'term_id');
    }
}

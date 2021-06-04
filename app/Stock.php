<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'term_id', 'stock',
    ];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class, 'term_id');
    }
}

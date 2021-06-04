<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preview extends Model
{
    protected $fillable = [
        'term_id', 'type', 'content'
    ];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class, 'term_id');
    }
}

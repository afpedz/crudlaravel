<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use SoftDeletes;
    protected $fillable = ['product_code', 
    'description', 
    'category_id', 
    'unit_id', 
    'price'
];

    // A product belongs to a category
    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    // A product belongs to a unit
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}

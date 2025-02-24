<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 
    'parent_id'
    ];

    // A category can have many products
    public function products()
    {
        return $this->hasMany(Products::class);
    }

    // A category can have many child categories
    public function children()
    {
        return $this->hasMany(Categories::class, 'parent_id');
    }

    // A category belongs to a parent category
    public function parent()
    {
        return $this->belongsTo(Categories::class, 'parent_id');
    }
}

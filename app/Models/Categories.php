<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
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

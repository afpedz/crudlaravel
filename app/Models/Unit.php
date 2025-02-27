<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    // use SoftDeletes;
    protected $fillable = [
        'name'
    ];

    // A unit can have many products
    public function products()
    {
        return $this->hasMany(Products::class);
    }
}
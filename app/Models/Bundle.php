<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bundle extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

//    public function products()
//    {
//        return $this->hasMany(Product::class);
//    }

    public function bundleProducts()
    {
        return $this->hasMany(BundleProduct::class);
    }
}

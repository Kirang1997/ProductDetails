<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = 'product';
    protected $fillable = ['Name', 'Price'];

    public function images()
    {
        return $this->hasMany(ProductImages::class);
    }
}

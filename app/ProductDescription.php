<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDescription extends Model
{
    use HasFactory;
    protected $guarded = [];
        public $timestamps = false;
        public $incrementing = false;
    public function product()
    {
        return $this->belongsTo(
            Product::class,
            'product_id',
            'id',
        )->withDefault();
    }
}

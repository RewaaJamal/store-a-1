<?php

namespace App\Models;

use App\Product;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderProduct extends Pivot
{
    use HasFactory;
    protected $table = 'order_products';
    protected $fillable = [
        'order_id' ,'product_id','price' ,'quantity'
    ];

    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

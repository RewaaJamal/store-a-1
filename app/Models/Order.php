<?php

namespace App\Models;

use App\Product;
use App\Models\User;
use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable= [
          'user_id',  'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class,'order_products')
            ->using(OrderProduct::class)
            ->withPivot(['quantity','price']);
    }
}

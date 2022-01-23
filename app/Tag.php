<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    /*protected $fillable = [
       'name',
    ];*/
    public $timestamps = false;

    public function products(){
        return $this->belongsToMany(
            Product::class,//related model
            'product_tags',//pivot table
            'tag_id', //Related key in the  pivot table
            'product_id', //Foreign key in the  pivot table
            'id', // Primary key
            'id'  //Related Primary key
        );
    }
}

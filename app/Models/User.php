<?php

namespace App\Models;

use App\Product;
use App\Models\Cart;
use App\Models\Order;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function hasPermission($permission)
    {
        return (bool) DB::table('users_roles')
        ->join('roles_permissions','users_roles.role_id', '=' ,'roles_permissions.role_id')
        ->where([
            'users_roles.user_id'=> $this->id,
            'roles_permissions.permission'=>$permission

        ])->count();
    }
    public function cartProducts()
    {
        return $this->belongsToMany(Product::class, 'carts')
        ->using(Cart::class)
        ->withPivot(['quantity']);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);

    }
    public function routeNotificationForNexmo()
    {
        return $this->mobile;

    }
    /*public function routeNotificationForMail()
    {
        return $this->email;

    }
    public function routeNotificationForBroadcast()
    {
        return 'App.Models.User'. $this->id;

    }*/

}
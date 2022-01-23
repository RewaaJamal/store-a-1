<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserType;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\CategoreController;
use App\Http\Controllers\Admin\ProductsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ HomeController::class , 'index']);

Route::prefix('/admin')
     ->as('admin.')
     ->middleware(['auth','user.type:admin,super-admin'])
     ->as('admin.')
     ->group(function(){

        Route::resource('/roles', RolesController::class);

        Route::prefix('/categories')
             ->as('categories.') 
             ->namespace('Admin')
             ->group(function(){
             Route::get('/',[CategoreController::class, 'index'])->name('index');
             Route::get('/create',[CategoreController::class, 'create'])->name('create');
             Route::post('/',[CategoreController::class, 'store'])->name('store');
             Route::get('/{id}',[CategoreController::class, 'edit'])->name('edit');
             Route::put('/{id}',[CategoreController::class, 'update'])->name('update');
             Route::delete('/{id}',[CategoreController::class, 'delete'])->name('delete');
             });
});

Route::get('/admin/products/trash',[ProductsController::class, 'trash'])->middleware(['auth','user.type:admin,super-admin'])->name('admin.products.trash');
Route::get('/admin/products/{id}/restore',[ProductsController::class, 'restore'])->middleware(['auth','user.type:admin,super-admin'])->name('admin.products.restore');
Route::resource('/admin/products', ProductsController::class)->middleware(['auth','user.type:admin,super-admin'])->names([
    'index'=>'admin.products.index',
    'edit'=>'admin.products.edit',
    'create'=>'admin.products.create',
    'update'=>'admin.products.update',
    'show'=>'admin.products.show',
    'destroy'=>'admin.products.destroy',
    'store'=>'admin.products.store',
]);

Route::get('/home',[HomeController::class , 'home'])->name('home');
Route::middleware('auth')->group(function(){
    Route::get('cart' ,  [CartController::class ,'index'])->name('cart.index');
    Route::post('cart' ,  [CartController::class ,'store'])->name('cart.store');
    Route::delete('cart/{$product_id}' ,  [CartController::class ,'destroy'])->name('cart.destroy');
    Route::get('orders' ,  [OrdersController::class ,'index'])->name('orders');
    Route::get('checkout' ,  [OrdersController::class ,'checkout'])->name('checkout');

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


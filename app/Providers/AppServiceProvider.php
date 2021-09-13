<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('header',function($view){
            $loai_sp = ProductType::all();
             
            $view->with('loai_sp',$loai_sp);
        });

        view()->composer('header',function($view){
            if(Session('cart')){
                $oldCart = session()->get('cart');
                $cart = new Cart($oldCart);
                $view->with(['cart'=>session()->get('cart'),
                'product_cart'=>$cart->items,
                'totalPrice'=>$cart->totalPrice,
                'totalQty'=>$cart->totalQty]);
            }  
           
        });
    }
}

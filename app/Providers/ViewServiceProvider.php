<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
// use App\Models\Category; // This line should be removed or commented out
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    protected $cartService;

    public function __construct($app)
    {
        parent::__construct($app);
        $this->cartService = app(CartService::class);
    }

    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer('*', function ($view) {
            // $view->with('categories', Category::where('is_active', true)->get()); // This line should be removed or commented out

            // Get cart count
            $cartCount = 0;
            if (Auth::check()) {
                $cart = $this->cartService->getCart(Auth::id());
                $cartCount = $cart->item_count;
            }
            $view->with('cartCount', $cartCount);
        });
    }
}
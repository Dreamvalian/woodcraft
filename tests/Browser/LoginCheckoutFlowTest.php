<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginCheckoutFlowTest extends DuskTestCase
{
    public function test_login_browse_cart_checkout_flow(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create([
                'password' => bcrypt('password'),
            ]);

            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/')
                ->visit('/shops')
                ->assertSee('WoodCraft')
                ->clickLink('View Details')
                ->press('Add to Cart')
                ->visit('/cart')
                ->assertSee('Cart')
                ->press('Proceed to Checkout')
                ->visit('/checkout')
                ->assertSee('Checkout');
        });
    }
}


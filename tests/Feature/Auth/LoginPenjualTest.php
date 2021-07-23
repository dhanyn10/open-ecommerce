<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Session;

use PenjualSeeder;

class LoginPenjualTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginPenjual()
    {
        Session::start();
        $this->seed(PenjualSeeder::class);
        $response = $this->call('POST', '/masuk', [
            'email' => 'penjual@open_ecommerce',
            'sandi' => 'penjual',
            '_token' => csrf_token()
        ]);
        $response->assertRedirect(route('penjual-tambah'));
    }
}

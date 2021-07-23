<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Session;

use PembeliSeeder;

class LoginPembeliTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginPembeli()
    {
        Session::start();
        $this->seed(PembeliSeeder::class);
        $response = $this->call('POST', '/masuk', [
            'email' => 'pembeli@open_ecommerce',
            'sandi' => 'pembeli',
            '_token' => csrf_token()
        ]);
        $response->assertRedirect('/');
    }
}

<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Session;
use AdminSeeder;

class LoginAdminTest extends TestCase
{
    use RefreshDatabase;
    
    public function testExample()
    {
 
        Session::start();
        $this->seed(AdminSeeder::class);
        $response = $this->call('POST', '/masuk', [
            'email' => 'admin@open_ecommerce',
            'sandi' => 'admin',
            '_token' => csrf_token()
        ]);
        $response->assertRedirect('/admin/dasbor');
    }
}

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
    
    private function loginAdmin()
    {
        Session::start();
        $this->seed(AdminSeeder::class);
        $response = $this->call('POST', '/masuk', [
            'email' => 'admin@open_ecommerce',
            'sandi' => 'admin',
            '_token' => csrf_token()
        ]);
        $response->assertRedirect(route('admin-dasbor'));
        $response->assertSeeText('dasbor');
    }
    public function testLoginAdmin()
    {
        $this->loginAdmin();
    }
    public function testProfil()
    {
        $this->loginAdmin();
        $response = $this->get('/admin/profil');
        $response->assertStatus(200);
        $response->assertSeeText('profil');
    }
}

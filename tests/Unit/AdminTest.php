<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

use AdminSeeder;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginAdmin()
    {
        Session::start();
        $this->seed(AdminSeeder::class);
        $response = $this->call('POST', '/masuk', [
            'email' => 'admin@open_ecommerce',
            'sandi' => 'admin',
            '_token' => csrf_token()
        ]);
        $response->assertRedirect(route('admin-dasbor'));
        $response = $this->get('/admin/dasbor');
        $response->assertStatus(200);
        $response->assertSeeText('Profil');
    }
    
    public function testVisitAkun()
    {
        $this->testLoginAdmin();
        $response = $this->get('/admin/profil');
        $response->assertStatus(200);
        //content
        $response->assertSeeText('profil');
    }
}

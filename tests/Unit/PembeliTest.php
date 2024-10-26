<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

use PembeliSeeder;

class PembeliTest extends TestCase
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
        $response->assertRedirect(route('beranda'));
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText('Troli');
    }
    
    public function testVisitAkun()
    {
        $this->testLoginPembeli();
        $response = $this->get('/pembeli/profil');
        $response->assertStatus(200);
        //sidebar
        $response->assertSeeText('Profil');
        //content
        $response->assertSeeText('email');
    }
}

<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

use PenjualSeeder;

class PenjualTest extends TestCase
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
        $response->assertRedirect(route('penjual-lihat'));
        $response = $this->get('/penjual/lihat');
        $response->assertStatus(200);
        $response->assertSeeText('Lihat Barang');
    }

    public function testVisitAkun()
    {
        $this->testLoginPenjual();
        $response = $this->get('/penjual/profil');
        $response->assertStatus(200);
        //sidebar
        $response->assertSeeText('Akun');
        //content
        $response->assertSeeText('email');
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

use PenjualSeeder;

class visitAkunPenjual extends TestCase
{

    use RefreshDatabase;

    private function loginPenjual()
    {
        Session::start();
        $this->seed(PenjualSeeder::class);
        $response = $this->call('POST', '/masuk', [
            'email' => 'penjual@open_ecommerce',
            'sandi' => 'penjual',
            '_token' => csrf_token()
        ]);
        $response->assertRedirect(route('penjual-lihat'));
    }

    public function testVisitAkun()
    {
        $this->loginPenjual();
        $response = $this->get('/penjual/profil');
        $response->assertStatus(200);
        //sidebar
        $response->assertSeeText('Akun');
        //content
        $response->assertSeeText('email');
        $response->assertSeeText('nama');
    }
}

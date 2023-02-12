<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Session;

use App\Models\Pengguna;

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
        $response->assertRedirect(route('penjual-lihat'));
    }

    public function testVisitProfil()
    {
        
        Session::start();
        $this->seed(PenjualSeeder::class);
        
        $getUser = Pengguna::where('peran', 2)->inRandomOrder()->get();
        $nama   = $getUser->pluck('nama')->first();
        $email  = $getUser->pluck('email')->first();
        
        session([
            'nama'      => $nama,
            'email'     => $email,
            'peran'     => 2
        ]);
        $response = $this->get('/penjual/profil');
        $response->assertSeeText('nama');
        $response->assertSeeText('Jawa Timur');
        $response->assertSeeText('Balikpapan');
    }
}

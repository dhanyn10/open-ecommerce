<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Session;
use AdminSeeder;

use App\Models\Pengguna;

class LoginAdminTest extends TestCase
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
        $response->assertSeeText('dasbor');
    }

    public function testProfil()
    {
        Session::start();
        $this->seed(AdminSeeder::class);

        $getUser = Pengguna::where('peran', 1)->inRandomOrder()->get();
        $nama   = $getUser->pluck('nama')->first();
        $email  = $getUser->pluck('email')->first();
        
        session([
            'nama'      => $nama,
            'email'     => $email,
            'peran'     => 1
        ]);
        
        $response = $this->get('/admin/profil');
        $response->assertStatus(200);
        $response->assertSeeText('profil');
    }
}

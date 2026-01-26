<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\AdminSeeder;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(AdminSeeder::class);
    }

    public function testLoginAdmin()
    {
        $user = User::where('email', 'admin@open_ecommerce')->first();
        $response = $this->actingAs($user)->get(route('admin-dasbor'));
        $response->assertStatus(200);
        $response->assertSeeText('Profil');
    }
    
    public function testVisitAkun()
    {
        $user = User::where('email', 'admin@open_ecommerce')->first();
        $response = $this->actingAs($user)->get(route('admin-profil'));
        $response->assertStatus(200);
        $response->assertSeeText('profil');
    }
}

<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use BarangSeeder;

class PagesTest extends TestCase
{
    use RefreshDatabase;

    public function testHome()
    {
        $this->seed(BarangSeeder::class);
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText('404');
    }
    
    public function testMasuk()
    {
        $response = $this->get('/masuk');
        $response->assertStatus(200);
        $response->assertSeeText('Masuk');
    }

    public function testDaftar()
    {
        $response = $this->get('/daftar');
        $response->assertStatus(200);
        $response->assertSeeText('Daftar');
    }

    public function testResetSandi()
    {
        $response = $this->get('/reset_sandi');
        $response->assertStatus(200);
        $response->assertSeeText('Reset sandi kamu');
    }
}

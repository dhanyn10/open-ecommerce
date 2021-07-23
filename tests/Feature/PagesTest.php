<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PagesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testBeranda()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
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

<?php

namespace Tests\Unit;

use Tests\TestCase;

class AdminTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testLoginAdmin()
    {
        $response = $this->call('POST', '/masuk', [
            'email' => 'admin@open_ecommerce',
            'sandi' => 'admin',
            '_token' => csrf_token()
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }
}

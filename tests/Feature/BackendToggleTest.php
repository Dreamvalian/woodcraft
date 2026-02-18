<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class BackendToggleTest extends TestCase
{
    public function test_api_requests_are_blocked_when_backend_disabled()
    {
        Config::set('app.backend_disabled', true);

        $response = $this->getJson('/api/v1/search?q=test');

        $response->assertStatus(503);
    }

    public function test_web_requests_are_blocked_when_backend_disabled()
    {
        Config::set('app.backend_disabled', true);

        $response = $this->get('/shops');

        $response->assertStatus(503);
    }

    public function test_requests_succeed_when_backend_enabled()
    {
        Config::set('app.backend_disabled', false);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}


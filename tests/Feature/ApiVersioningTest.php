<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiVersioningTest extends TestCase
{
    public function test_v1_search_endpoint_responds_successfully_for_short_query()
    {
        $response = $this->getJson('/api/v1/search?q=wo');

        $response->assertStatus(200);
    }

    public function test_legacy_search_endpoint_still_responds()
    {
        $response = $this->getJson('/api/search?q=wo');

        $response->assertStatus(200);
    }
}


<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Benchmark;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TranslationPerformanceTest extends TestCase
{
    use RefreshDatabase;
    private function authenticate() {
        $user = User::factory()->create();
        // Sanctum::actingAs($user, ['*']); // ['*'] gives access to all abilities return $user;
        return [
            'Authorization' => 'Bearer ' . $user->createToken('api-token')->plainTextToken,
        ];
    }

    public function test_translation_export_json_is_fast_enough() {
        $headers = $this->authenticate();
        $time = Benchmark::measure(function () use($headers) {
            $this->getJson('/api/v1/translation/export?locale=en', $headers);
        });
        // Assert the API responds in less than 500ms
        $this->assertLessThan(500, $time, "Translation export took too long: {$time}ms");
    }
}

<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Translation;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TranslationApiTest extends TestCase
{
    use RefreshDatabase;

    private function authenticate() {
        $user = User::factory()->create();
        // Sanctum::actingAs($user, ['*']); // ['*'] gives access to all abilities return $user;
        return [
            'Authorization' => 'Bearer ' . $user->createToken('api-token')->plainTextToken,
        ];
    }

    public function test_can_create_translation()
    {
        $headers = $this->authenticate();
        $data = [
            'key' => 'greeting',
            'content' => 'Hello',
            'locale' => 'en',
            'tags' => ['web']
        ];

        $response = $this->postJson('/api/v1/translation', $data, $headers);

        $response->assertStatus(201)
                 ->assertJsonFragment(['key' => 'greeting']);
    }

    public function test_can_search_by_tag()
    {
        $headers = $this->authenticate();
        Translation::factory()->create([
            'key' => 'test',
            'content' => 'Test value',
            'locale' => 'en',
            'tags' => ['mobile']
        ]);

        $response = $this->getJson('/api/v1/translation/search?key=test', $headers);
        $response->assertStatus(200)->assertJsonCount(1, 'data');
    }

    public function test_can_export_json_translations()
    {
        $headers = $this->authenticate();
        Translation::factory()->create([
            'key' => 'welcome',
            'content' => 'Welcome',
            'locale' => 'en'
        ]);

        $response = $this->getJson('/api/v1/translation/export?locale=en', $headers);
        $response->assertStatus(200)
                 ->assertJsonFragment(['welcome' => 'Welcome']);
    }
}

<?php

namespace Tests\Feature\Auth;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegistrationTest extends TestCase
{
    use DatabaseMigrations;

    public function test_a_guest_can_register(): void
    {
        $response = $this->json('POST', route('register'), [
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertCreated();
        $response->assertJsonStructure(['data' => [
            'name', 'email',
        ], 'token']);
    }

    public function test_import_users_from_json_file()
    {
        $jsonUrl = 'https://example.com/users.json';
        $jsonResponse = json_encode([
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
            ],
            [
                'name' => 'Jane Doe',
                'email' => 'jane@example.com',
            ],
        ]);

        Http::fake([
            $jsonUrl => Http::response($jsonResponse, 200),
        ]);

        $this->artisan('users:import', [
            'url' => $jsonUrl,
            'limit' => 2,
        ])->assertExitCode(0);

        $this->assertDatabaseCount('users', 2);
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
        $this->assertDatabaseHas('users', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);
    }
}

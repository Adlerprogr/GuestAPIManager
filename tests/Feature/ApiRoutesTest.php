<?php

namespace Tests\Feature;

use App\Models\Guest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiRoutesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест на проверку маршрута для создания гостя
     */
    public function testStoreGuestRoute()
    {
        $response = $this->json('POST', '/api/guests', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '+12345678901',
            'email' => 'john.doe@example.com',
            'country' => 'USA',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'first_name',
                    'last_name',
                    'phone',
                    'email',
                    'country',
                ]
            ]);
    }

    /**
     * Тест на проверку маршрута для получения гостя по ID
     */
    public function testShowGuestRoute()
    {
        $guest = Guest::factory()->create();

        $response = $this->json('GET', "/api/guests/{$guest->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $guest->id,
                    'first_name' => $guest->first_name,
                    'last_name' => $guest->last_name,
                    'phone' => $guest->phone,
                    'email' => $guest->email,
                    'country' => $guest->country,
                ]
            ]);
    }

    /**
     * Тест на проверку маршрута для обновления гостя по ID
     */
    public function testUpdateGuestRoute()
    {
        $guest = Guest::factory()->create();

        $response = $this->json('PUT', "/api/guests/{$guest->id}", [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'phone' => '+12345678902',
            'email' => 'jane.doe@example.com',
            'country' => 'USA',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'first_name' => 'Jane',
                    'last_name' => 'Doe',
                    'phone' => '+12345678902',
                    'email' => 'jane.doe@example.com',
                    'country' => 'USA',
                ]
            ]);
    }

    /**
     * Тест на проверку маршрута для удаления гостя по ID
     */
    public function testDestroyGuestRoute()
    {
        $guest = Guest::factory()->create();

        $response = $this->json('DELETE', "/api/guests/{$guest->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('guests', ['id' => $guest->id]);
    }

    /**
     * Тест на проверку маршрута с неверным ID для получения гостя
     */
    public function testShowGuestNotFoundRoute()
    {
        $response = $this->json('GET', '/api/guests/9999');

        $response->assertStatus(404);
    }

    /**
     * Тест на проверку маршрута с неверным ID для обновления гостя
     */
    public function testUpdateGuestNotFoundRoute()
    {
        $response = $this->json('PUT', '/api/guests/9999', [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'phone' => '+12345678902',
            'email' => 'jane.doe@example.com',
            'country' => 'USA',
        ]);

        $response->assertStatus(404);
    }

    /**
     * Тест на проверку маршрута с неверным ID для удаления гостя
     */
    public function testDestroyGuestNotFoundRoute()
    {
        $response = $this->json('DELETE', '/api/guests/9999');

        $response->assertStatus(404);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testUserIndex()
    {
        $response = $this->getJson('/api/V1/users');

        $response->assertStatus(200);
    }

    public function testShowUser()
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/V1/users/{$user->id}");

        $user->delete();

        $response->assertStatus(200);
    }

    public function testDestroyUser()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/V1/users/{$user->id}");

        $response->assertStatus(204);

        // Проверим, что пользователь действительно удален из базы данных
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function testUserIndexWithFilter()
    {
        // Создайте пользователя, который соответствует вашему фильтру
        $user = User::factory()->create(['name' => 'John Doe']);

        $response = $this->getJson('/api/V1/users?name[tq]=John%20Doe');

        $user->delete();

        $response->assertStatus(200);
    }

    public function testUserStoreSuccess()
    {
        $faker = \Faker\Factory::create();

        $user = [
            'name' => 'Test user',
            'email' => $faker->unique()->safeEmail()
        ];

        $response = $this->postJson('/api/V1/users', $user);

        $response->assertStatus(201);
    }

    public function testUserStoreFail()
    {
        $user = [
            'name' => 'Test user',
        ];

        $response = $this->postJson('/api/V1/users', $user);

        $response->assertStatus(422);
    }

    public function testLinkCarToUser()
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        $response = $this->postJson("/api/V1/users/{$user->id}/link/{$car->id}");

        $car->delete();
        $user->delete();

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CarControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCarIndex()
    {
        $response = $this->getJson('/api/V1/cars');

        $response->assertStatus(200);
    }

    public function testShowCar()
    {
        $car = Car::factory()->create();

        $response = $this->getJson("/api/V1/cars/{$car->id}");

        $car->delete();

        $response->assertStatus(200);
    }

    public function testDestroyCar()
    {
        $car = Car::factory()->create();

        $response = $this->deleteJson("/api/V1/cars/{$car->id}");

        $response->assertStatus(204);

        // Проверим, что пользователь действительно удален из базы данных
        $this->assertDatabaseMissing('cars', ['id' => $car->id]);
    }

    public function testCarIndexWithFilter()
    {
        // Создайте пользователя, который соответствует вашему фильтру
        $car = Car::factory()->create(['model' => 'Super New Model']);

        $response = $this->getJson('/api/V1/cars?model[eq]=Super%20New%20Model');

        $car->delete();

        $response->assertStatus(200);
    }

    public function testCarStoreSuccess()
    {
        $car = [
            'model' => 'Test car',
            'year' => '2024'
        ];

        $response = $this->postJson('/api/V1/cars', $car);

        $response->assertStatus(201);
    }

    public function testCarStoreFail()
    {
        $car = [
            'model' => 'Test car',
        ];

        $response = $this->postJson('/api/V1/cars', $car);

        $response->assertStatus(422);
    }
}

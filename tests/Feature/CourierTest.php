<?php

namespace Tests\Feature;

use App\Models\Courier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourierTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_paginate_couriers()
    {
        Courier::factory()->count(20)->create();
        $response = $this->getJson('/api/couriers?per_page=10');
        $response->assertStatus(200)
            ->assertJsonCount(10, 'data')
            ->assertJsonPath('current_page', 1)
            ->assertJsonPath('last_page', 2);
    }

    public function test_couriers_ordered_by_name_by_default()
    {
        Courier::factory()->create(['name' => 'Zebra']);
        Courier::factory()->create(['name' => 'Apple']);
        $response = $this->getJson('/api/couriers');
        $response->assertStatus(200)
            ->assertJsonPath('data.0.name', 'Apple')
            ->assertJsonPath('data.1.name', 'Zebra');
    }

    public function test_can_sort_couriers_by_created_at()
    {
        $c1 = Courier::factory()->create(['name' => 'A', 'created_at' => now()->subDay()]);
        $c2 = Courier::factory()->create(['name' => 'B', 'created_at' => now()]);
        $response = $this->getJson('/api/couriers?sort_by=created_at&order=asc');
        $response->assertStatus(200)
            ->assertJsonPath('data.0.name', 'A')
            ->assertJsonPath('data.1.name', 'B');
    }

    public function test_can_search_courier_by_words()
    {
        Courier::factory()->create(['name' => 'Budiono Hadi Agung']);
        Courier::factory()->create(['name' => 'John Doe']);
        $response = $this->getJson('/api/couriers?search=budi%20agung');
        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Budiono Hadi Agung');
    }

    public function test_can_filter_couriers_by_level()
    {
        Courier::factory()->create(['name' => 'L1', 'level' => 1]);
        Courier::factory()->create(['name' => 'L2', 'level' => 2]);
        Courier::factory()->create(['name' => 'L3', 'level' => 3]);
        $response = $this->getJson('/api/couriers?level=2,3');
        $response->assertStatus(200)
            ->assertJsonCount(2, 'data');
    }

    public function test_can_show_courier_detail()
    {
        $courier = Courier::factory()->create();
        $response = $this->getJson("/api/couriers/{$courier->id}");
        $response->assertStatus(200)
            ->assertJsonPath('id', $courier->id);
    }

    public function test_can_create_courier_with_validation()
    {
        $data = Courier::factory()->make()->toArray();
        $response = $this->postJson('/api/couriers', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('couriers', ['phone' => $data['phone']]);
    }

    public function test_validation_errors_when_creating_courier()
    {
        $response = $this->postJson('/api/couriers', []);
        $response->assertStatus(422);
    }

    public function test_can_update_courier()
    {
        $courier = Courier::factory()->create();
        $response = $this->putJson("/api/couriers/{$courier->id}", ['name' => 'New Name'] + $courier->toArray());
        $response->assertStatus(200);
        $this->assertDatabaseHas('couriers', ['id' => $courier->id, 'name' => 'New Name']);
    }

    public function test_can_delete_courier()
    {
        $courier = Courier::factory()->create();
        $response = $this->deleteJson("/api/couriers/{$courier->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('couriers', ['id' => $courier->id]);
    }
}

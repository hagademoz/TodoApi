<?php

namespace Tests\Feature;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TodoApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_todo()
    {
        $response = $this->postJson('/api/todos', [
            'title' => 'Test Todo',
            'description' => 'Test description',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'title' => 'Test Todo',
                'description' => 'Test description',
            ]);

        $this->assertDatabaseHas('todos', [
            'title' => 'Test Todo',
            'description' => 'Test description',
        ]);
    }

    /** @test */
    public function it_can_update_a_todo()
    {
        $todo = Todo::factory()->create();

        $response = $this->putJson("/api/todos/{$todo->id}", [
            'title' => 'Updated Todo',
            'description' => 'Updated description',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'title' => 'Updated Todo',
                'description' => 'Updated description',
            ]);

        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'title' => 'Updated Todo',
            'description' => 'Updated description',
        ]);
    }

    /** @test */
    public function it_can_delete_a_todo()
    {
        $todo = Todo::factory()->create();

        $response = $this->deleteJson("/api/todos/{$todo->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('todos', [
            'id' => $todo->id,
        ]);
    }

    /** @test */
    public function it_can_retrieve_all_todos()
    {
        $todos = Todo::factory()->count(5)->create();

        $response = $this->getJson('/api/todos');

        $response->assertStatus(200)
            ->assertJson($todos->toArray());
    }
}

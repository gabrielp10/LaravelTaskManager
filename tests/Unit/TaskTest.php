<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_task()
    {
        $data = [
            'title' => 'New task',
            'description' => 'This is a new task',
            'status' => 'To-do',
        ];

        $response = $this->post(route('task.store'), $data);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('tasks', $data);
    }

    /** @test */
    public function it_can_update_a_task()
    {
        $task = Task::factory()->create();

        $data = [
            'title' => 'Updated task',
            'description' => 'This is an updated task',
            'status' => 'Done',
        ];

        $response = $this->put(route('task.update', $task), $data);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('tasks', $data);
    }

    /** @test */
    public function it_can_delete_a_task()
    {
        $task = Task::factory()->create();
    
        $response = $this->delete(route('task.destroy', $task));
    
        $response->assertSessionHasNoErrors();
    
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }
}

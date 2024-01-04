<?php

namespace Tests\Feature\Livewire;

use App\Livewire\TodoRow;
use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TodoRowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        Livewire::test(TodoRow::class, ['todo' => Todo::factory()->make()])
            ->assertStatus(200);
    }

    /** @test */
    public function doesnt_dispatch_todo_updating_event_when_content_is_same_as_initial_value()
    {
        $todo = Todo::factory()->create();

        Livewire::test(TodoRow::class, compact('todo'))
            ->call('update')
            ->assertNotDispatched('todo-updating');

        Livewire::test(TodoRow::class, compact('todo'))
            ->set('content', $todo->content)
            ->call('update')
            ->assertNotDispatched('todo-updating');
    }

    /** @test */
    public function dispatches_todo_updating_event_when_content_is_changed()
    {
        $todo = Todo::create(['content' => 'foo']);
        $newContent = 'bar';

        Livewire::test(TodoRow::class, compact('todo'))
            ->set('content', $newContent)
            ->call('update')
            ->assertDispatched(
                'todo-updating',
                function ($eventName, $params) use ($todo, $newContent) {
                    return $params['todo']['id'] === $todo->id
                        && $params['content'] === $newContent;
                }
            );
    }

    /** @test */
    public function dispatches_todo_deleting_event()
    {
        $todo = Todo::factory()->create();

        Livewire::test(TodoRow::class, compact('todo'))
            ->call('delete')
            ->assertDispatched(
                'todo-deleting',
                fn ($eventName, $params) => $params['todo']['id'] === $todo->id
            );
    }
}

<?php

namespace Tests\Feature\Livewire;

use App\Livewire\CreateTodo;
use Livewire\Livewire;
use Tests\TestCase;

class CreateTodoTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(CreateTodo::class)
            ->assertStatus(200);
    }

    /** @test */
    public function content_is_empty_by_default()
    {
        Livewire::test(CreateTodo::class)
            ->assertSet('content', '');
    }

    /** @test */
    public function dispatches_todo_creating_event_when_calling_create_action()
    {
        Livewire::test(CreateTodo::class)
            ->set('content', 'test')
            ->call('create')
            ->assertDispatched('todo-creating', content: 'test');
    }

    /** @test */
    public function resets_content_property_when_dispatching_todo_created_event()
    {
        Livewire::test(CreateTodo::class)
            ->set('content', 'test')
            ->dispatch('todo-created')
            ->assertSet('content', '');
    }
}

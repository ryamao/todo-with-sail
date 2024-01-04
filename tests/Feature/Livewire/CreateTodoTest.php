<?php

namespace Tests\Feature\Livewire;

use App\Livewire\CreateTodo;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CreateTodoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $categories = Category::factory(3)->create();

        Livewire::test(CreateTodo::class, compact('categories'))
            ->assertStatus(200);
    }

    /** @test */
    public function content_is_empty_by_default()
    {
        $categories = Category::factory(3)->create();

        Livewire::test(CreateTodo::class, compact('categories'))
            ->assertSet('content', '');
    }

    /** @test */
    public function dispatches_todo_creating_event_when_calling_create_action()
    {
        $categories = Category::factory(3)->create();

        Livewire::test(CreateTodo::class, compact('categories'))
            ->set('content', 'test')
            ->set('categoryId', $categories[0]->id)
            ->call('create')
            ->assertDispatched('todo-creating', content: 'test', categoryId: $categories[0]->id);
    }

    /** @test */
    public function resets_content_property_when_dispatching_todo_created_event()
    {
        $categories = Category::factory(3)->create();

        Livewire::test(CreateTodo::class, compact('categories'))
            ->set('content', 'test')
            ->set('categoryId', $categories[0]->id)
            ->dispatch('todo-created')
            ->assertSet('content', '');
    }
}

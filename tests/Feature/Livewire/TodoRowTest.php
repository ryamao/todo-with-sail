<?php

namespace Tests\Feature\Livewire;

use App\Livewire\TodoRow;
use App\Models\Category;
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
        $categories = Category::factory(3)->create();
        $todo = Todo::factory()->recycle($categories)->create();
        Livewire::test(TodoRow::class, compact('todo', 'categories'))
            ->assertStatus(200);
    }

    /** @test */
    public function content_and_category_properties_are_same_as_todo_parameter_by_default()
    {
        $categories = Category::factory(3)->create();
        $todo = Todo::factory()->recycle($categories)->create();

        Livewire::test(TodoRow::class, compact('todo', 'categories'))
            ->assertSet('content', $todo->content)
            ->assertSet('category_id', $todo->category_id);
    }

    /** @test */
    public function doesnt_dispatch_todo_updating_event_when_content_is_same_as_initial_value()
    {
        $categories = Category::factory(3)->create();
        $todo = Todo::factory()->recycle($categories)->create();

        Livewire::test(TodoRow::class, compact('todo', 'categories'))
            ->call('update')
            ->assertNotDispatched('todo-updating');
    }

    /** @test */
    public function dispatches_todo_updating_event_when_content_is_changed()
    {
        $categories = Category::factory(2)->create();
        $todo = Todo::factory()
            ->recycle($categories[0])
            ->create(['content' => 'foo']);
        $newContent = 'bar';

        Livewire::test(TodoRow::class, compact('todo', 'categories'))
            ->set('content', $newContent)
            ->call('update')
            ->assertDispatched(
                'todo-updating',
                function ($eventName, $params) use ($todo, $categories, $newContent) {
                    return $params['todo']['id'] === $todo->id
                        && $params['content'] === $newContent
                        && $params['category_id'] === $categories[0]->id;
                }
            );
    }

    /** @test */
    public function dispatches_todo_updating_event_when_category_is_changed()
    {
        $categories = Category::factory(2)->make();
        $todo = Todo::factory()
            ->recycle($categories[0])
            ->create();

        Livewire::test(TodoRow::class, compact('todo', 'categories'))
            ->set('category_id', $categories[1]->id)
            ->call('update')
            ->assertDispatched(
                'todo-updating',
                function ($eventName, $params) use ($todo, $categories) {
                    return $params['todo']['id'] === $todo->id
                        && $params['content'] === $todo->content
                        && $params['category_id'] === $categories[1]->id;
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

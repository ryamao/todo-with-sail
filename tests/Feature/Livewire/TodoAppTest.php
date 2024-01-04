<?php

namespace Tests\Feature\Livewire;

use App\Livewire\CreateTodo;
use App\Livewire\TodoApp;
use App\Livewire\TodoRow;
use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TodoAppTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        Livewire::test(TodoApp::class)
            ->assertStatus(200);
    }

    /** @test */
    public function has_no_errors_by_default()
    {
        Livewire::test(TodoApp::class)
            ->assertHasNoErrors();
    }

    /** @test */
    public function can_see_create_post_component()
    {
        Livewire::test(TodoApp::class)
            ->assertSeeLivewire(CreateTodo::class);
    }

    /** @test */
    public function cannot_see_todo_row_component_when_todo_doesnt_exist()
    {
        $this->assertDatabaseEmpty('todos');
        Livewire::test(TodoApp::class)
            ->assertDontSeeLivewire(TodoRow::class);
    }

    /** @test */
    public function can_see_todo_row_component_when_todo_exists()
    {
        Todo::factory()->create();
        Livewire::test(TodoApp::class)
            ->assertSeeLivewire(TodoRow::class);
    }
    /** @test */
    public function can_create_todo_with_content_of_length_1()
    {
        $this->assertCanCreateTodo('A');
    }

    /** @test */
    public function can_create_todo_with_content_of_length_20()
    {
        $this->assertCanCreateTodo(str_repeat('A', 20));
    }

    /** @test */
    public function cannot_create_todo_with_content_of_length_0()
    {
        $this->assertCannotCreateTodo('');
    }

    /** @test */
    public function cannot_create_todo_with_content_of_length_21()
    {
        $this->assertCannotCreateTodo(str_repeat('A', 21));
    }

    /** @test */
    public function can_update_todo_with_content_of_length_1()
    {
        $this->assertCanUpdateTodo('A');
    }

    /** @test */
    public function can_update_todo_with_content_of_length_20()
    {
        $this->assertCanUpdateTodo(str_repeat('A', 20));
    }

    /** @test */
    public function cannot_update_todo_with_content_of_length_0()
    {
        $this->assertCannotUpdateTodo('');
    }

    /** @test */
    public function cannot_update_todo_with_content_of_length_21()
    {
        $this->assertCannotUpdateTodo(str_repeat('A', 21));
    }

    private function assertCanCreateTodo(string $content)
    {
        $this->assertDatabaseEmpty('todos');

        Livewire::test(TodoApp::class)
            ->dispatch('todo-creating', content: $content)
            ->assertDispatched('todo-created')
            ->assertHasNoErrors()
            ->assertSeeText('Todoを作成しました')
            ->assertSeeLivewire(TodoRow::class);

        $this->assertDatabaseCount('todos', 1);
        $todo = Todo::first();
        $this->assertSame($content, $todo->content);
    }

    private function assertCannotCreateTodo(string $content)
    {
        $this->assertDatabaseEmpty('todos');

        Livewire::test(TodoApp::class)
            ->dispatch('todo-creating', content: $content)
            ->assertNotDispatched('todo-created')
            ->assertHasErrors()
            ->assertDontSeeLivewire(TodoRow::class);

        $this->assertDatabaseEmpty('todos');
    }

    private function assertCanUpdateTodo(string $content)
    {
        $this->assertDatabaseEmpty('todos');
        $todo = Todo::create(['content' => 'test']);

        Livewire::test(TodoApp::class)
            ->dispatch('todo-updating', todo: $todo, content: $content)
            ->assertDispatched('todo-updated')
            ->assertHasNoErrors()
            ->assertSeeText('Todoを更新しました');

        $this->assertDatabaseCount('todos', 1);
        $todo = Todo::first();
        $this->assertSame($content, $todo->content);
    }

    private function assertCannotUpdateTodo(string $content)
    {
        $this->assertDatabaseEmpty('todos');
        $oldContent = 'test';
        $todo = Todo::create(['content' => $oldContent]);

        Livewire::test(TodoApp::class)
            ->dispatch('todo-creating', content: $content)
            ->assertNotDispatched('todo-created')
            ->assertHasErrors()
            ->assertDontSeeLivewire(TodoRow::class);

        $this->assertDatabaseCount('todos', 1);
        $todo = Todo::first();
        $this->assertSame($oldContent, $todo->content);
    }
}

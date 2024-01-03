<?php

namespace Tests\Feature\Livewire;

use App\Livewire\CreateTodo;
use App\Livewire\ShowTodos;
use App\Livewire\TodoApp;
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
    public function has_no_errors()
    {
        Livewire::test(TodoApp::class)
            ->assertHasNoErrors();
    }

    /** @test */
    public function todos_property_is_empty_when_todos_table_is_empty()
    {
        $this->assertDatabaseEmpty('todos');

        $me = Livewire::test(TodoApp::class);
        $this->assertEmpty($me->viewData('todos'));
    }

    /** @test */
    public function todos_are_same_as_todo_all()
    {
        $this->assertDatabaseEmpty('todos');
        $dbTodos = Todo::factory(5)->create();

        $me = Livewire::test(TodoApp::class);
        $viewTodos = $me->viewData('todos');
        $this->assertCount($dbTodos->count(), $viewTodos);
        foreach ($dbTodos->zip($viewTodos) as [$e, $a]) {
            $this->assertSame($e->content, $a->content);
        }
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
    public function fails_validation_with_content_of_length_0()
    {
        $this->assertFailsValidation('', 'required');
    }

    /** @test */
    public function fails_validation_with_content_of_length_21()
    {
        $this->assertFailsValidation(str_repeat('A', 21), 'max');
    }

    private function assertCanCreateTodo(string $content)
    {
        $this->assertDatabaseEmpty('todos');

        $me = Livewire::test(TodoApp::class);
        $me->set('content', $content);
        $me->call('create');
        $me->assertHasNoErrors();
        $me->assertSet('content', '');

        $dbTodos = Todo::all();
        $this->assertCount(1, $dbTodos);
        $this->assertSame($content, $dbTodos[0]->content);

        $viewTodos = $me->viewData('todos');
        $this->assertCount(1, $viewTodos);
        $this->assertSame($content, $viewTodos[0]->content);
    }

    private function assertFailsValidation(string $content, string $rule)
    {
        $this->assertDatabaseEmpty('todos');

        $me = Livewire::test(TodoApp::class);
        $me->set('content', $content);
        $me->call('create');
        $me->assertHasErrors(['content' => $rule]);
        $me->assertSet('content', $content);

        $this->assertDatabaseEmpty('todos');
        $this->assertEmpty($me->viewData('todos'));
    }
}

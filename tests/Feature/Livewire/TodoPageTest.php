<?php

namespace Tests\Feature\Livewire;

use App\Livewire\CreateTodo;
use App\Livewire\TodoPage;
use App\Livewire\TodoRow;
use App\Models\Category;
use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TodoPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        Livewire::test(TodoPage::class)
            ->assertStatus(200);
    }

    /** @test */
    public function has_no_errors_by_default()
    {
        Livewire::test(TodoPage::class)
            ->assertHasNoErrors();
    }

    /** @test */
    public function can_see_create_post_component()
    {
        Livewire::test(TodoPage::class)
            ->assertSeeLivewire(CreateTodo::class);
    }

    /** @test */
    public function cannot_see_todo_row_component_when_todo_doesnt_exist()
    {
        $this->assertDatabaseEmpty('todos');
        Livewire::test(TodoPage::class)
            ->assertDontSeeLivewire(TodoRow::class);
    }

    /** @test */
    public function can_see_todo_row_component_when_todo_exists()
    {
        Todo::factory()->create();
        Livewire::test(TodoPage::class)
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

    /** @test */
    public function can_delete_todo()
    {
        $category = Category::factory()->create();
        $todo = Todo::create(['content' => 'test', 'category_id' => $category->id]);
        $this->assertDatabaseCount('todos', 1);

        Livewire::test(TodoPage::class)
            ->dispatch('todo-deleting', todo: $todo)
            ->assertDispatched('todo-deleted')
            ->assertHasNoErrors()
            ->assertSeeText('Todoを削除しました')
            ->assertDontSeeLivewire(TodoRow::class);

        $this->assertDatabaseEmpty('todos');
    }

    private function assertCanCreateTodo(string $content)
    {
        $this->assertDatabaseEmpty('todos');
        $category = Category::factory()->create();

        Livewire::test(TodoPage::class)
            ->dispatch('todo-creating', content: $content, category_id: $category->id)
            ->assertDispatched('todo-created')
            ->assertHasNoErrors()
            ->assertSeeText('Todoを作成しました')
            ->assertSeeLivewire(TodoRow::class);

        $this->assertDatabaseCount('todos', 1);
        $todo = Todo::first();
        $this->assertSame($content, $todo->content);
        $this->assertSame($category->id, $todo->category_id);
    }

    private function assertCannotCreateTodo(string $content)
    {
        $this->assertDatabaseEmpty('todos');
        $category = Category::factory()->create();

        Livewire::test(TodoPage::class)
            ->dispatch('todo-creating', content: $content, category_id: $category->id)
            ->assertNotDispatched('todo-created')
            ->assertHasErrors()
            ->assertDontSeeLivewire(TodoRow::class);

        $this->assertDatabaseEmpty('todos');
    }

    private function assertCanUpdateTodo(string $content)
    {
        $this->assertDatabaseEmpty('todos');
        $category = Category::factory()->create();
        $todo = Todo::create(['content' => 'test', 'category_id' => $category->id]);

        Livewire::test(TodoPage::class)
            ->dispatch('todo-updating', todo: $todo, content: $content, category_id: $category->id)
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
        $category = Category::factory()->create();
        $oldContent = 'test';
        $todo = Todo::create(['content' => $oldContent, 'category_id' => $category->id]);

        Livewire::test(TodoPage::class)
            ->dispatch('todo-creating', content: $content, category_id: $category->id)
            ->assertNotDispatched('todo-created')
            ->assertHasErrors()
            ->assertDontSeeLivewire(TodoRow::class);

        $this->assertDatabaseCount('todos', 1);
        $todo = Todo::first();
        $this->assertSame($oldContent, $todo->content);
    }
}

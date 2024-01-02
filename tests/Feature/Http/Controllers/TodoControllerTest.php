<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoControllerTest extends TestCase
{
    use RefreshDatabase;

    private const string TODO_PAGE_ROUTE_NAME = 'todos.index';

    public function test_get_todo_page_returns_ok(): void
    {
        $response = $this->get(route(self::TODO_PAGE_ROUTE_NAME));

        $response->assertOk();
        $response->assertViewIs(route(self::TODO_PAGE_ROUTE_NAME));
        $response->assertValid();
    }

    public function test_todo_page_has_todo_contents_in_order(): void
    {
        Todo::factory(10)->create();

        $response = $this->get(route(self::TODO_PAGE_ROUTE_NAME));

        $contents = Todo::all()->map(fn ($todo) => $todo->content)->toArray();
        $response->assertSeeTextInOrder($contents);
    }

    public function test_post_todo_page_returns_method_not_allowed(): void
    {
        $response = $this->post(route(self::TODO_PAGE_ROUTE_NAME));

        $response->assertMethodNotAllowed();
    }
}

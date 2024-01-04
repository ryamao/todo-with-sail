<?php

namespace Tests\Feature\Livewire;

use App\Livewire\SearchTodo;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SearchTodoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $keyword = '';
        $categoryId = null;
        $categories = Category::factory(3)->create();

        Livewire::test(SearchTodo::class, compact('keyword', 'categoryId', 'categories'))
            ->assertStatus(200);
    }
}

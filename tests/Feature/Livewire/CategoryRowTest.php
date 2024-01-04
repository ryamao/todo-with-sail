<?php

namespace Tests\Feature\Livewire;

use App\Livewire\CategoryRow;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CategoryRowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $category = Category::factory()->create();

        Livewire::test(CategoryRow::class, compact('category'))
            ->assertStatus(200);
    }
}

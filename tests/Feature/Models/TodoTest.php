<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_creation_with_normal_data(): void
    {
        $category = Category::create(['name' => $this->faker()->text(10)]);

        $todo1 = Todo::create([
            'content' => 'A',
            'category_id' => $category->id,
        ]);
        $todo2 = Todo::create([
            'content' => $this->faker()->text(20),
            'category_id' => $category->id,
        ]);

        $this->assertModelExists($todo1);
        $this->assertModelExists($todo2);
    }

    public function test_creation_with_abnormal_data(): void
    {
        $category = Category::create(['name' => $this->faker()->text(10)]);

        $this->assertThrows(function () {
            Todo::create([]);
        });
        $this->assertThrows(function () {
            Todo::create(['content' => null]);
        });
        $this->assertThrows(function () {
            Todo::create(['content' => '']);
        });
        $this->assertThrows(function () {
            Todo::create(['content' => $this->faker()->text(21)]);
        });

        $this->assertThrows(function () use ($category) {
            Todo::create([
                'category_id' => $category->id,
            ]);
        });
        $this->assertThrows(function () use ($category) {
            Todo::create([
                'content' => null,
                'category_id' => $category->id,
            ]);
        });
        $this->assertThrows(function () use ($category) {
            Todo::create([
                'content' => '',
                'category_id' => $category->id,
            ]);
        });
        $this->assertThrows(function () use ($category) {
            Todo::create([
                'content' => $this->faker()->text(21),
                'category_id' => $category->id,
            ]);
        });
    }
}

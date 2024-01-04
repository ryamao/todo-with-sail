<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_create_with_normal_data(): void
    {
        $category1 = Category::create([
            'name' => 'A',
        ]);
        $category2 = Category::create([
            'name' => $this->faker()->text(10),
        ]);

        $this->assertModelExists($category1);
        $this->assertModelExists($category2);
    }

    public function test_cannot_create_with_abnormal_data(): void
    {
        $this->assertThrows(function () {
            Category::create([]);
        });
        $this->assertThrows(function () {
            Category::create(['name' => null]);
        });
        $this->assertThrows(function () {
            Category::create([
                'name' => '',
            ]);
        });
        $this->assertThrows(function () {
            Category::create([
                'name' => $this->faker()->text(11),
            ]);
        });
    }
}

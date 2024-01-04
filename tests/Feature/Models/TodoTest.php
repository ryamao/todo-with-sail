<?php

namespace Tests\Feature\Models;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_creation_with_normal_data(): void
    {
        $todo1 = Todo::create([
            'content' => 'A',
        ]);
        $todo2 = Todo::create([
            'content' => $this->faker()->text(20),
        ]);

        $this->assertModelExists($todo1);
        $this->assertModelExists($todo2);
    }

    public function test_creation_with_abnormal_data(): void
    {
        $this->assertThrows(function () {
            Todo::create([]);
        });
        $this->assertThrows(function () {
            Todo::create(['content' => null]);
        });
        $this->assertThrows(function () {
            Todo::create([
                'content' => '',
            ]);
        });
        $this->assertThrows(function () {
            Todo::create([
                'content' => $this->faker()->text(21),
            ]);
        });
    }
}

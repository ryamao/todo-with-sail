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
        Todo::create([
            'content' => 'A',
        ]);
        Todo::create([
            'content' => $this->faker()->text(20),
        ]);
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

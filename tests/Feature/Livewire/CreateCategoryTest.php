<?php

namespace Tests\Feature\Livewire;

use App\Livewire\CreateCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CreateCategoryTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(CreateCategory::class)
            ->assertStatus(200);
    }
}

<?php

namespace Tests\Feature\Livewire;

use App\Livewire\CategoryPage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CategoryPageTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(CategoryPage::class)
            ->assertStatus(200);
    }
}

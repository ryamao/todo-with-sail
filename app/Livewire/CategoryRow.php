<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Mail\Mailables\Content;
use Livewire\Component;

class CategoryRow extends Component
{
    public Category $category;

    public string $name;

    public function mount(Category $category): void
    {
        $this->name = $category->name;
    }

    public function render()
    {
        return view('livewire.category-row');
    }

    public function update(): void
    {
        $this->dispatch('category-updating', category: $this->category, name: $this->name);
    }

    public function delete(): void
    {
        $this->dispatch('category-deleting', category: $this->category);
    }
}

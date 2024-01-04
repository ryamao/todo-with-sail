<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class SearchTodo extends Component
{
    public Collection $categories;

    public string $keyword = '';
    public ?int $categoryId = null;

    public function render()
    {
        return view('livewire.search-todo');
    }

    public function search(): void
    {
        $this->dispatch('todo-searching', keyword: $this->keyword, categoryId: $this->categoryId);
    }
}

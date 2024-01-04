<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateTodo extends Component
{
    public Collection $categories;

    public string $content = '';
    public ?int $categoryId = null;

    public function render(): View
    {
        return view('livewire.create-todo');
    }

    public function create(): void
    {
        $this->dispatch('todo-creating', content: $this->content, categoryId: $this->categoryId);
    }

    #[On('todo-created')]
    public function onTodoCreated(): void
    {
        $this->reset('content');
    }
}

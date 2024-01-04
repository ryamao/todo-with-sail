<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateTodo extends Component
{
    public string $content = '';

    public function render(): View
    {
        return view('livewire.create-todo');
    }

    public function create(): void
    {
        $this->dispatch('todo-creating', content: $this->content);
    }

    #[On('todo-created')]
    public function onTodoCreated(): void
    {
        $this->reset('content');
    }
}

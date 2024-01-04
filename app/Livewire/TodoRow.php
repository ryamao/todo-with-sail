<?php

namespace App\Livewire;

use App\Models\Todo;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class TodoRow extends Component
{
    public Todo $todo;

    public string $content;

    public function mount(Todo $todo): void
    {
        $this->todo = $todo;
        $this->content = $todo->content;
    }

    public function render(): View
    {
        return view('livewire.todo-row');
    }

    public function update(): void
    {
        if ($this->content === $this->todo->content) return;
        $this->dispatch('todo-updating', todo: $this->todo, content: $this->content);
    }
}

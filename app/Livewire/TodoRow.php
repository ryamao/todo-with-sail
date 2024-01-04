<?php

namespace App\Livewire;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class TodoRow extends Component
{
    public Todo $todo;
    public Collection $categories;

    public ?string $content = null;
    public ?int $category_id = null;

    public function mount(Todo $todo, Collection $categories): void
    {
        $this->todo = $todo;
        $this->categories = $categories;
        $this->setFormValue($this->todo);
    }

    public function render(): View
    {
        return view('livewire.todo-row');
    }

    public function update(): void
    {
        if ($this->isNotFormChanged()) return;

        $this->dispatch(
            'todo-updating',
            todo: $this->todo,
            content: $this->content,
            category_id: $this->category_id,
        );
    }

    public function delete(): void
    {
        $this->dispatch('todo-deleting', todo: $this->todo);
    }

    private function setFormValue(Todo $todo): void
    {
        $this->content = $todo->content;
        $this->category_id = $todo->category_id;
    }

    private function isNotFormChanged(): bool
    {
        return $this->content === $this->todo->content
            && $this->category_id === $this->todo->category_id;
    }
}

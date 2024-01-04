<?php

namespace App\Livewire;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;

class TodoRow extends Component
{
    public Todo $todo;
    public Collection $categories;

    public ?string $content = null;
    public ?int $categoryId = null;

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
            categoryId: $this->categoryId,
        );
    }

    public function delete(): void
    {
        $this->dispatch('todo-deleting', todo: $this->todo);
    }

    private function setFormValue(Todo $todo): void
    {
        $this->content = $todo->content;
        $this->categoryId = $todo->category_id;
    }

    private function isNotFormChanged(): bool
    {
        return $this->content === $this->todo->content
            && $this->categoryId === $this->todo->category_id;
    }
}

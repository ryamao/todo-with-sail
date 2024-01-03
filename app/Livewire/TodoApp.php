<?php

namespace App\Livewire;

use App\Models\Todo;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Todo')]
class TodoApp extends Component
{
    #[Validate('required', message: 'Todoを入力してください')]
    #[Validate('max:20', message: 'Todoを20文字以下で入力してください')]
    public string $content = '';

    public bool $isTodoCreated = false;

    public function boot(): void
    {
        $this->reset('isTodoCreated');
    }

    public function create(): void
    {
        $validated = $this->validate();

        Todo::create($validated);

        $this->isTodoCreated = true;
        $this->reset('content');
    }

    public function render(): View
    {
        $todos = Todo::all();
        return view('livewire.todo-app', compact('todos'));
    }
}

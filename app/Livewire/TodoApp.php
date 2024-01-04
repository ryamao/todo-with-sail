<?php

namespace App\Livewire;

use App\Models\Todo;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Validation\Validator;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Todo')]
class TodoApp extends Component
{
    public array $infoMessages = [];

    public function render(): View
    {
        $todos = Todo::orderBy('id')->get();
        return view('livewire.todo-app', compact('todos'));
    }

    #[On('todo-creating')]
    public function onTodoCreating(string $content): void
    {
        $this->resetMessages();

        $validated = $this->makeTodoValidator($content)->validate();
        Todo::create($validated);

        $this->infoMessages[] = 'Todoを作成しました';
        $this->dispatch('todo-created');
    }

    #[On('todo-updating')]
    public function onTodoUpdating(Todo $todo, string $content): void
    {
        $this->resetMessages();

        $validated = $this->makeTodoValidator($content)->validate();
        $todo->update($validated);

        $this->infoMessages[] = 'Todoを更新しました';
        $this->dispatch('todo-updated');
    }

    private function resetMessages(): void
    {
        $this->reset('infoMessages');
        $this->resetValidation();
    }

    private function makeTodoValidator(string $content): Validator
    {
        $data = compact('content');
        $rules = ['content' => ['required', 'max:20']];
        $messages = [
            'content.required' => 'Todoを入力してください',
            'content.max' => 'Todoを20文字以下で入力してください',
        ];
        return FacadesValidator::make($data, $rules, $messages);
    }
}

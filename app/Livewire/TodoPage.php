<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Todo;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Todo')]
class TodoPage extends Component
{
    public array $infoMessages = [];

    public function render(): View
    {
        $todos = Todo::all();
        $categories = Category::all();
        return view('livewire.todo-page', compact('todos', 'categories'));
    }

    public function rules(): array
    {
        return [
            'content' => ['required', 'max:20'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'Todoを入力してください',
            'content.max' => 'Todoを20文字以下で入力してください',
            'category_id.required' => 'カテゴリを入力してください',
            'category_id.exists' => 'カテゴリを入力してください',
        ];
    }

    #[On('todo-creating')]
    public function onTodoCreating(string $content, ?int $category_id): void
    {
        $this->resetMessages();

        $validated = Validator::validate(compact('content', 'category_id'), $this->rules(), $this->messages());
        Todo::create($validated);

        $this->infoMessages[] = 'Todoを作成しました';
        $this->dispatch('todo-created');
    }

    #[On('todo-updating')]
    public function onTodoUpdating(Todo $todo, string $content, ?int $category_id): void
    {
        $this->resetMessages();

        $validated = Validator::validate(compact('content', 'category_id'), $this->rules(), $this->messages());
        $todo->update($validated);

        $this->infoMessages[] = 'Todoを更新しました';
        $this->dispatch('todo-updated');
    }

    #[On('todo-deleting')]
    public function onTodoDeleting(Todo $todo): void
    {
        $this->resetMessages();

        $todo->delete();

        $this->infoMessages[] = 'Todoを削除しました';
        $this->dispatch('todo-deleted');
    }

    private function resetMessages(): void
    {
        $this->reset('infoMessages');
        $this->resetValidation();
    }
}

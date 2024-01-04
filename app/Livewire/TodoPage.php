<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Todo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Todo')]
class TodoPage extends Component
{
    public string $searchKeyword = '';
    public ?int $searchCategoryId = null;

    public array $infoMessages = [];

    public function boot(): void
    {
        $this->reset('infoMessages');
        $this->resetValidation();
    }

    public function render(): View
    {
        $categories = Category::all();
        return view('livewire.todo-page', compact('categories'));
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

    #[Computed]
    public function todos(): Collection
    {
        return Todo::categorySearch($this->searchCategoryId)
            ->keywordSearch($this->searchKeyword)
            ->get();
    }

    #[On('todo-creating')]
    public function onTodoCreating(string $content, ?int $categoryId): void
    {
        $data = ['content' => $content, 'category_id' => $categoryId];
        $validated = Validator::validate($data, $this->rules(), $this->messages());
        Todo::create($validated);

        $this->infoMessages[] = 'Todoを作成しました';
        $this->dispatch('todo-created');
    }

    #[On('todo-updating')]
    public function onTodoUpdating(Todo $todo, string $content, ?int $categoryId): void
    {
        $data = ['content' => $content, 'category_id' => $categoryId];
        $validated = Validator::validate($data, $this->rules(), $this->messages());
        $todo->update($validated);

        $this->infoMessages[] = 'Todoを更新しました';
        $this->dispatch('todo-updated');
    }

    #[On('todo-deleting')]
    public function onTodoDeleting(Todo $todo): void
    {
        $todo->delete();

        $this->infoMessages[] = 'Todoを削除しました';
        $this->dispatch('todo-deleted');
    }

    #[On('todo-searching')]
    public function onTodoSearching(string $keyword, ?int $categoryId): void
    {
        $this->searchKeyword = $keyword;
        $this->searchCategoryId = $categoryId;
        $this->dispatch('todo-searched');
    }
}

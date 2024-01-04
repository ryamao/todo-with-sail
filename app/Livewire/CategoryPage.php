<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Todo - カテゴリ一覧')]
class CategoryPage extends Component
{
    public array $infoMessages = [];

    public function boot(): void
    {
        $this->reset('infoMessages');
        $this->resetValidation();
    }

    public function render(): View
    {
        $categories = Category::all();
        return view('livewire.category-page', compact('categories'));
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:10', 'unique:categories'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'カテゴリを入力してください',
            'name.max' => 'カテゴリを10文字以下で入力してください',
            'name.unique' => 'カテゴリが既に存在しています',
        ];
    }

    #[On('category-creating')]
    public function onCategoryCreated(string $name): void
    {
        $validated = Validator::validate(compact('name'), $this->rules(), $this->messages());
        Category::create($validated);

        $this->infoMessages[] = 'カテゴリを作成しました';
        $this->dispatch('category-created');
    }

    #[On('category-updating')]
    public function onCategoryUpdating(Category $category, string $name): void
    {
        $validated = Validator::validate(compact('name'), $this->rules(), $this->messages());
        $category->update($validated);

        $this->infoMessages[] = 'カテゴリを更新しました';
        $this->dispatch('category-updated');
    }

    #[On('category-deleting')]
    public function onCategoryDeleting(Category $category): void
    {
        $category->delete();

        $this->infoMessages[] = 'カテゴリを削除しました';
        $this->dispatch('category->deleted');
    }
}

<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class CreateCategory extends Component
{
    public string $name = '';

    public function render()
    {
        return view('livewire.create-category');
    }

    public function create(): void
    {
        $this->dispatch('category-creating', name: $this->name);
    }

    #[On('category-created')]
    public function onCategoryCreated(): void
    {
        $this->reset('name');
    }
}

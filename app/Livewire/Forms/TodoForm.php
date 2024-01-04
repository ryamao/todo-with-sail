<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class TodoForm extends Form
{
    #[Validate('required', message: 'Todoを入力してください')]
    #[Validate('max:20', message: 'Todoを20文字以下で入力してください')]
    public string $content;
}

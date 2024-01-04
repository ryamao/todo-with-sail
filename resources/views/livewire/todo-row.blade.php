<tr>
    <td class="w-full">
        <input type="text" form="update-form-{{ $todo->id }}" wire:model="content" class="w-5/6 p-4" />
    </td>
    <td class="h-full flex items-center *:mr-4">
        <form id="update-form-{{ $todo->id }}" wire:submit="update">
            <button type="submit" class="bg-indigo-600 text-white rounded px-4 py-1">
                更新
            </button>
        </form>
        <form wire:submit="delete">
            <button type="submit" class="bg-red-600 text-white rounded px-4 py-1">
                削除
            </button>
        </form>
    </td>
</tr>
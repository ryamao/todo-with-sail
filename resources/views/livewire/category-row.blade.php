<tr>
    <td>
        <input type="text" form="update-form-{{ $category->id }}" wire:model="name" class="w-5/6 p-3" />
    </td>

    <td class="w-0">
        <div class="flex mx-4 space-x-4">
            <form id="update-form-{{ $category->id }}" wire:submit="update">
                <button type="submit" class="bg-indigo-600 text-white rounded w-16 h-8">
                    更新
                </button>
            </form>
            <form wire:submit="delete">
                <button type="submit" class="bg-red-600 text-white rounded w-16 h-8">
                    削除
                </button>
            </form>
        </div>
    </td>
</tr>
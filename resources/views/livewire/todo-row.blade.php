<tr>
    <td class="w-2/5">
        <input type="text" form="update-form-{{ $todo->id }}" wire:model="content" class="w-full p-3" />
    </td>

    <td>
        <select wire:model="category_id" class="appearance-none p-3 w-4/5">
            <option disabled>カテゴリ</option>
            @foreach ($categories->sortBy('created_at') as $category)
            <option value="{{ $category->id }}" wire:key="$category->id">{{ $category->name }}</option>
            @endforeach
        </select>
    </td>

    <td class="w-0">
        <div class="flex mx-4 space-x-4">
            <form id="update-form-{{ $todo->id }}" wire:submit="update">
                <button type="submit" class="bg-indigo-600 text-white rounded w-16 h-8">
                    更新
                </button>
            </form>
            <form wire:submit="delete">
                <button type="submit" class="bg-red-600 text-white rounded w-16 h-8"">
                    削除
                </button>
            </form>
        </div>
    </td>
</tr>
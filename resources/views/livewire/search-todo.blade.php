<div>
    <form wire:submit="search">
        <div class="grid grid-cols-[minmax(0,3fr)_minmax(0,2fr)_auto] items-center">
            <input type="text" wire:model="keyword" class="border rounded w-full p-3" />

            <select wire:model="categoryId" class="appearance-none border rounded p-3 ml-4 w-3/5">
                <option value="">カテゴリ</option>
                @foreach ($categories->sortBy('created_at') as $category)
                <option value="{{ $category->id }}" wire:key="$category->id">{{ $category->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="bg-black text-white rounded w-44 h-12">
                検索
            </button>
        </div>
    </form>
</div>
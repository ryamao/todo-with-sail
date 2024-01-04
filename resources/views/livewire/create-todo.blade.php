<div>
    <form wire:submit="create">
        <div class="grid grid-cols-[minmax(0,1fr)_auto] items-center">
            <input type="text" wire:model="content" class="border rounded w-5/6 p-3" />
            <button type="submit" class="bg-black text-white rounded px-[4.5rem] py-3">
                作成
            </button>
        </div>
    </form>
</div>
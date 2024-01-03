<div>
    @if ($isTodoCreated)
    <div class="bg-teal-200 text-teal-800 border-b border-b-teal-100">
        <div class="max-w-screen-xl mx-auto pl-8 py-1">Todoを作成しました</div>
    </div>
    @endif

    @if ($errors->any())
    <div class="bg-rose-200 text-rose-800">
        <ul class="list-disc list-inside max-w-screen-xl mx-auto *:border-b *:border-b-rose-100">
            @foreach ($errors->all() as $message)
            <li class="pl-6 py-1">{{ $message }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="w-4/5 max-w-screen-lg mx-auto mt-16 space-y-12">
        <div>
            <form wire:submit="create">
                <div class="grid grid-cols-[minmax(0,1fr)_auto] items-center">
                    <input type="text" wire:model="content" class="border rounded w-5/6 p-3" />
                    <button type="submit" class="bg-black text-white rounded px-16 py-3">作成</button>
                </div>
            </form>
        </div>

        <table class="w-full">
            <thead class="border-b">
                <tr>
                    <th class="text-left text-2xl p-4">Todo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="*:border-b">
                @foreach ($todos as $todo)
                <tr class="grid grid-cols-[minmax(0,1fr)_auto]">
                    <td class="w-5/6 p-4">
                        {{ $todo->content }}
                    </td>
                    <td class="h-full flex items-center *:mr-4">
                        <button type="button" class="bg-indigo-600 text-white rounded px-4 py-1">更新</button>
                        <button type="button" class="bg-red-600 text-white rounded px-4 py-1">削除</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<tr>
    <td class="w-full">
        <input type="text" form="update-form-{{ $todo->id }}" wire:model="content" class="w-5/6 p-4" />
    </td>
    <td class="h-full flex items-center *:mr-4">
        <form id="update-form-{{ $todo->id }}" wire:submit="update">
            <button type="submit" class="bg-indigo-600 text-white rounded px-4 py-1">更新</button>
        </form>
        <button type="button" class="bg-red-600 text-white rounded px-4 py-1">削除</button>
    </td>

    {{-- @if($isTodoUpdated)
    @teleport('#updating-info')
    <div class="bg-teal-200 text-teal-800 border border-teal-100">
        <div class="max-w-screen-xl mx-auto pl-8 py-1">Todoを更新しました</div>
    </div>
    @endteleport
    @endif

    @if($errors->any())
    @teleport('#updating-error')
    <div class="bg-rose-200 text-rose-800 border border-rose-100">
        <ul class="list-disc list-inside max-w-screen-xl mx-auto pl-6 *:py-1">
            @foreach($errors->all() as $message)
            <li>{{ $message }}</li>
    @endforeach
    </ul>
    </div>
    @endteleport
    @endif --}}
</tr>
<div>
    @unless (empty($infoMessages))
    <div class="bg-teal-200 text-teal-800 border-b border-b-teal-100">
        <ul class="max-w-screen-xl mx-auto pl-8 *:py-1">
            @foreach ($infoMessages as $message)
            <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if ($errors->any())
    <div class="bg-rose-200 text-rose-800 border-b border-b-rose-100">
        <ul class="list-disc list-inside max-w-screen-xl mx-auto pl-6 *:py-1">
            @foreach ($errors->all() as $message)
            <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="w-4/5 max-w-screen-lg mx-auto mt-16 space-y-12">
        <livewire:create-todo />

        <table class="w-full">
            <thead class="border-b">
                <tr>
                    <th class="text-left text-2xl p-4">Todo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="*:grid *:grid-cols-[minmax(0,1fr)_auto] *:border-b">
                @foreach ($todos as $todo)
                <livewire:todo-row :$todo :key="$todo->id" />
                @endforeach
            </tbody>
        </table>
    </div>
</div>
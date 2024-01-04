<div>
    @unless (empty($infoMessages))
    <div class="bg-teal-200 text-teal-800 border-b border-b-teal-100">
        <ul class="max-w-screen-xl mx-auto pl-8 *:py-1.5">
            @foreach ($infoMessages as $message)
            <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if ($errors->any())
    <div class="bg-rose-200 text-rose-800 border-b border-b-rose-100">
        <ul class="list-disc list-inside max-w-screen-xl mx-auto pl-6 *:py-1.5">
            @foreach ($errors->all() as $message)
            <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="w-4/5 max-w-screen-lg mx-auto mt-16 space-y-12">
        <div class="space-y-4">
            <h2 class="text-2xl font-bold">新規作成</h2>
            <livewire:create-todo :$categories />
            <h2 class="text-2xl font-bold">Todo検索</h2>
            <livewire:search-todo :keyword="$searchKeyword" :categoryId="$searchCategoryId" :$categories />
        </div>

        <table class="w-full">
            <thead>
                <tr class="border-b">
                    <th class="text-left text-xl p-4">Todo</th>
                    <th class="text-left text-xl p-2">カテゴリ</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="*:border-b">
                @foreach ($this->todos->sortBy('created_at') as $todo)
                <livewire:todo-row :$todo :$categories :key="$todo->id" />
                @endforeach
            </tbody>
        </table>
    </div>
</div>
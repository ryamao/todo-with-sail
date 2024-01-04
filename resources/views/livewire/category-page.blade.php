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
        <livewire:create-category />

        <table class="w-full">
            <thead>
                <tr class="border-b">
                    <th class="text-left text-xl p-4">category</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="*:border-b">
                @foreach ($categories->sortBy('created_at') as $category)
                <livewire:category-row :$category :key="$category->id" />
                @endforeach
            </tbody>
        </table>
    </div>
</div>
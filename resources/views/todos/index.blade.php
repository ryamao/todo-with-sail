<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <header>
        <div class="bg-black text-white">
            <div class="max-w-screen-xl mx-auto pl-4 py-4">
                <h1 class="text-3xl font-bold"><a href="/">Todo</a></h1>
            </div>
        </div>
    </header>

    <div class="bg-teal-300 text-teal-800 border-teal-200 border-b">
        <div class="max-w-screen-xl mx-auto py-2 pl-10">
            <div class="text-lg">Todoを作成しました</div>
        </div>
    </div>

    <div class="bg-rose-200 text-rose-800 border-rose-100 border-b">
        <div class="max-w-screen-xl mx-auto py-2 pl-10">
            <div class="text-lg">
                <ul class="list-disc">
                    <li>Todoを入力してください</li>
                </ul>
            </div>
        </div>
    </div>

    <main>
        <div class="w-4/5 max-w-screen-lg mx-auto">
            <div class="grid grid-cols-[minmax(0,1fr)_auto]">
                <div class="grid grid-cols-subgrid col-span-2 items-baseline pt-16">
                    <div class="w-4/5">
                        <input class="w-full p-2 border border-neutral-300 rounded" form="todos-create-form" type="text" name="content" />
                    </div>
                    <div>
                        <form id="todos-create-form" action="" method="post">
                            @csrf
                            <button class="bg-black text-white rounded px-16 py-2">作成</button>
                        </form>
                    </div>
                </div>

                <div class="col-span-2 pt-12 pl-4">
                    <h2 class="text-2xl font-bold">Todo</h2>
                </div>

                <ul class="grid grid-cols-subgrid col-span-2 mt-4 border-t *:border-b">
                    @foreach ($todos as $todo)
                    <li class="grid grid-cols-subgrid col-span-2 items-baseline py-4">
                        <div class="pl-2">
                            <input class="w-full p-2" form="todos-update-form-{{ $todo->id }}" type="text" name="content" value="{{ $todo->content }}" />
                        </div>
                        <div class="flex justify-evenly">
                            <div>
                                <form id="todos-update-form-{{ $todo->id }}" action="" method="post">
                                    @csrf
                                    @method('patch')
                                    <input type="hidden" name="id" value="{{ $todo->id }}" />
                                    <button class="bg-indigo-600 text-white px-4 py-1.5 rounded">更新</button>
                                </form>
                            </div>
                            <div>
                                <form action="" method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="id" value="{{ $todo->id }}" />
                                    <button class="bg-red-600 text-white px-4 py-1.5 rounded">削除</button>
                                </form>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </main>
</body>

</html>
<x-app-layout>
    <div class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-8 px-8 py-4 bg-white shadow-md">

        <x-flash-message :message="session('notice')" />
        <x-validation-errors :errors="$errors" />

        <article class="mb-2">
            <h2 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-1 text-3xl md:text-4xl">
                {{ $rental->title }}</h2>
            <h3>{{ $rental->user->name }}</h3>
            <p class="text-sm mb-2 md:text-base font-normal text-gray-600">
                <span
                    class="text-red-400 font-bold">{{ date('Y-m-d H:i:s', strtotime('-1 day')) < $rental->created_at ? 'NEW' : '' }}</span>
                {{ $rental->created_at }}
            </p>
            <p>【価格】</p>
            <p class="text-gray-700 text-base">{!! nl2br(e($rental->price)) !!}</p>
            <p>【レンタル日数】</p>
            <p class="text-gray-700 text-base">{!! nl2br(e($rental->days)) !!}</p>
            <p>【ブランド】</p>
            <p class="text-gray-700 text-base">{!! nl2br(e($rental->brand)) !!}</p>
            <p>【カテゴリー】</p>
            <p class="text-gray-700 text-base">{!! nl2br(e($rental->category)) !!}</p>
            <p>【所在地】</p>
            <p class="text-gray-700 text-base">{!! nl2br(e($rental->area)) !!}</p>
            <p>【配送方法】</p>
            <p class="text-gray-700 text-base">{!! nl2br(e($rental->delivery)) !!}</p>
            <p>【詳細】</p>
            <p class="text-gray-700 text-base">{!! nl2br(e($rental->body)) !!}</p>
        </article>
        <div class="flex flex-row text-center my-4">
            @can('update', $rental)
                <a href="{{ route('rentals.edit', $rental) }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">編集</a>
            @endcan
            @can('delete', $rental)
                <form action="{{ route('rentals.destroy', $rental) }}" method="rental">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="削除" onclick="if(!confirm('削除しますか？')){return false};"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20">
                </form>
            @endcan
        </div>

        @auth
            <hr class="my-4">
            <div class="flex justify-end">
                <a href="{{ route('rentals.comments.create', $rental) }}"
                    class="bg-indigo-400 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline block">コメント登録</a>
            </div>
        @endauth

        <section class="font-sans break-normal text-gray-900 ">
            @foreach ($comments as $comment)
                <div class="my-2">
                    <span class="font-bold mr-3">{{ $comment->user->name }}</span>
                    <span class="text-sm">{{ $comment->created_at }}</span>
                    <p>{!! nl2br(e($comment->body)) !!}</p>

                    <div class="flex justify-end text-center my-4">
                        @can('update', $comment)
                            <a href="{{ route('rentals.comments.edit', [$rental,$comment]) }}"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">編集</a>
                        @endcan
                        @can('delete', $comment)
                            <form action="{{ route('rentals.comments.destroy', [$rental,$comment]) }}" method="rental">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="削除" onclick="if(!confirm('削除しますか？')){return false};"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20">
                            </form>
                        @endcan
                    </div>
                </div>
                <hr>
            @endforeach
        </section>

    </div>
</x-app-layout>

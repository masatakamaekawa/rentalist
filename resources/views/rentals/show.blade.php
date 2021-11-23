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
                <a href="{{ route('rentals.rentalcomments.create', $rental) }}"
                    class="bg-indigo-400 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline block mr-4">コメント</a>

                @if (Auth::check())
                    @if (empty($entry))
                        <form action="{{ route('rentals.entries.store', $rental) }}" method="post">
                            @csrf
                            <input type="submit" value="貸出希望" onclick="if(!confirm('貸出希望しますか？')){return false};"
                                class="bg-indigo-700 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline block">
                        </form>
                    @else
                        <form action="{{ route('rentals.entries.destroy', [$rental, $entry]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="貸出希望取消" onclick="if(!confirm('貸出希望を取り消しますか？')){return false};"
                                class="bg-indigo-700 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline block">
                        </form>
                    @endif
                @endif
            </div>
        @endauth

        @if (!empty($entries))
            <hr>
            <h2 class="flex justify-center font-bold text-lg my-4">貸出希望一覧</h2>
            <div class="">
                <form method="post">
                    @csrf
                    @method('PATCH')
                    <table class="min-w-full table-fixed text-center">
                        <thead>
                            <tr class="text-gray-700 ">
                                <th class="w-1/5 px-4 py-2">ニックネーム</th>
                                <th class="w-1/5 px-4 py-2">エントリー日</th>
                                <th class="w-1/5 px-4 py-2">ステータス</th>
                                <th class="w-2/5 px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entries as $e)
                                <tr>
                                    <td>{{ $e->user->name }}</td>
                                    <td>{{ $e->created_at->format('Y-m-d') }}</td>
                                    <td>{{ array_search($e->status, EntryConst::STATUS_LIST) }}</td>
                                    <td>
                                        <div class="flex flex-col sm:flex-row items-center sm:justify-end text-center">
                                            <input type="submit" value="承認"
                                                formaction="{{ route('rentals.entries.approval', [$rental, $e]) }}"
                                                onclick="if(!confirm('希望しますか？')){return false};"
                                                class="w-full sm:w-32 bg-gradient-to-r from-indigo-500 to-blue-600 hover:bg-gradient-to-l hover:from-blue-500 hover:to-indigo-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32">
                                            <input type="submit" value="却下"
                                                formaction="{{ route('rentals.entries.reject', [$rental, $e]) }}"
                                                onclick="if(!confirm('却下しますか？')){return false};"
                                                class="bg-gradient-to-r from-pink-500 to-purple-600 hover:bg-gradient-to-l hover:from-purple-500 hover:to-pink-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32 ml-2">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
        @endif

        <section class="font-sans break-normal text-gray-900 ">
            @foreach ($rentalcomments as $rentalcomment)
                <div class="my-2">
                    <span class="font-bold mr-3">{{ $rentalcomment->user->name }}</span>
                    <span class="text-sm">{{ $rentalcomment->created_at }}</span>
                    <p>{!! nl2br(e($rentalcomment->body)) !!}</p>

                    <div class="flex justify-end text-center my-4">
                        @can('update', $rentalcomment)
                            <a href="{{ route('rentals.rentalcomments.edit', [$rental, $rentalcomment]) }}"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">編集</a>
                        @endcan
                        @can('delete', $rentalcomment)
                            <form action="{{ route('rentals.rentalcomments.destroy', [$rental, $rentalcomment]) }}" method="rental">
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

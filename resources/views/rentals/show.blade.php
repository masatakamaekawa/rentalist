<x-app-layout>
    <div class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-8 px-8 py-4 bg-white shadow-md">
        <x-flash-message :message="session('notice')" />
        <x-validation-errors :errors="$errors" />

        {{-- @if ($rental->user_id == Auth::user()->id)
            <h2>自分の</h2>
        @else
            <h2>他人の</h2>
        @endif --}}

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
            <p>【レンタル希望日】</p>
            <p class="text-gray-700 text-base">{!! nl2br(e($rental->date)) !!}</p>
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
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline w-20 mr-2">編集</a>
            @endcan
            @can('delete', $rental)
                <form action="{{ route('rentals.destroy', $rental) }}" method="rental">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="削除" onclick="if(!confirm('削除しますか？')){return false};"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline w-20">
                </form>
            @endcan
        </div>

        @auth
            <hr class="my-4">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('rentals.rentalcomments.create', $rental) }}"
                    class="bg-indigo-400 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline mr-4">コメント</a>
            </div>
            <section class="font-sans break-normal text-gray-900 ">
                @foreach ($rentalcomments as $rentalcomment)
                    <div class="my-2">
                        <span class="font-bold mr-3">{{ $rentalcomment->user->name }}</span>
                        <span class="text-sm">{{ $rentalcomment->created_at }}</span>
                        <p>{!! nl2br(e($rentalcomment->body)) !!}</p>

                        <div class="flex justify-end text-center my-4">
                            @can('update', $rentalcomment)
                                <a href="{{ route('rentals.rentalcomments.edit', [$rental, $rentalcomment]) }}"
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline w-20 mr-2">編集</a>
                            @endcan
                            @can('delete', $rentalcomment)
                                <form action="{{ route('rentals.rentalcomments.destroy', [$rental, $rentalcomment]) }}"
                                    method="rental">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="削除" onclick="if(!confirm('削除しますか？')){return false};"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline w-20">
                                </form>
                            @endcan
                        </div>
                    </div>
                    <hr>
                @endforeach
            </section>

            @if ($rental->user_id == Auth::user()->id)
                <hr class="my-4">
                <h2 class="d-grid gap-2 d-md-flex justify-content-md-end">貸出申請一覧</h2>
                <div class="">
                    <form method="post">
                        @csrf
                        @method('PATCH')
                        <table class="min-w-full table-fixed text-center">
                            <thead>
                                <tr class="text-gray-700 ">
                                    <th class="w-1/5 px-4 py-2">名前</th>
                                    <th class="w-1/5 px-4 py-2">日付</th>
                                    <th class="w-1/5 px-4 py-2">状態</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entries as $e)
                                    <tr>
                                        <td>{{ $e->user->name }}</td>
                                        <td>{{ $e->created_at->format('Y-m-d') }}</td>
                                        <td>{{ array_search($e->status, EntryConst::STATUS_LIST) }}</td>
                                        <td>
                                            <div class="content">
                                                <div class="rounded-full">
                                                <style type="text/css">
                                                    
                                                    button.stripe-button-el,
                                                    button.stripe-button-el>span {
                                                        background-color: #c50067 !important;
                                                        background-image: none;
                                                    }
                                                
                                                </style>
                                                <hr class="my-4">
                                                <form action="{{ route('charge') }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <script src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-key="{{ env('STRIPE_KEY') }}"
                                                                                                        data-amount="3000" data-name="Stripe Demo" data-label="レンタルする"
                                                                                                        data-description="Online course about integrating Stripe"
                                                                                                        data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                                                                                        data-locale="auto" data-currency="JPY">
                                                    </script>
                                                </form>
                                            </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>

            @else
            <hr class="my-4">
                @if (empty($entry))
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <form action="{{ route('rentals.entries.store', $rental) }}" method="post">
                            @csrf
                            <input type="submit" value="貸出申請" onclick="if(!confirm('貸出申請しますか？')){return false};"
                                class="bg-indigo-700 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline block">
                        </form>
                @else
                        <form action="{{ route('rentals.entries.destroy', [$rental, $entry]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="貸出申請取消" onclick="if(!confirm('貸出申請を取り消しますか？')){return false};"
                                class="bg-indigo-700 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline block">
                        </form>
                    </div>
                @endif
            @endif
        </div>
    @endauth
    </div>
</x-app-layout>

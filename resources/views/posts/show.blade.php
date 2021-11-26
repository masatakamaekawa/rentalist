<x-app-layout>
    <div class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-8 px-8 py-4 bg-white shadow-md">

        <x-flash-message :message="session('notice')" />
        <x-validation-errors :errors="$errors" />

        <article class="mb-2">
            <h2 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-1 text-3xl md:text-4xl">
                {{ $post->title }}</h2>
            <h3>{{ $post->user->name }}</h3>
            <p class="text-sm mb-2 md:text-base font-normal text-gray-600">
                <span
                    class="text-red-400 font-bold">{{ date('Y-m-d H:i:s', strtotime('-1 day')) < $post->created_at ? 'NEW' : '' }}</span>
                {{ $post->created_at }}
            </p>
            <img src="{{ $post->image_url }}" alt="" class="mb-4">
            <p>【価格】</p>
            <p class="text-gray-700 text-base">{!! nl2br(e($post->price)) !!}</p>
            <p>【レンタル日数】</p>
            <p class="text-gray-700 text-base">{!! nl2br(e($post->days)) !!}</p>
            <p>【ブランド】</p>
            <p class="text-gray-700 text-base">{!! nl2br(e($post->brand)) !!}</p>
            <p>【カテゴリー】</p>
            <p class="text-gray-700 text-base">{!! nl2br(e($post->category)) !!}</p>
            <p>【所在地】</p>
            <p class="text-gray-700 text-base">{!! nl2br(e($post->area)) !!}</p>
            <p>【配送方法】</p>
            <p class="text-gray-700 text-base">{!! nl2br(e($post->delivery)) !!}</p>
            <p>【詳細】</p>
            <p class="text-gray-700 text-base">{!! nl2br(e($post->body)) !!}</p>
        </article>
        <div class="flex flex-row text-center my-4">
            @can('update', $post)
                <a href="{{ route('posts.edit', $post) }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">編集</a>
            @endcan
            @can('delete', $post)
                <form action="{{ route('posts.destroy', $post) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="削除" onclick="if(!confirm('削除しますか？')){return false};"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20">
                </form>
            @endcan
        </div>

        @auth
            <hr class="my-4">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('posts.comments.create', $post) }}"
                    class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-1 px-4 rounded focus:outline-none focus:shadow-outline mr-4">コメントする</a>

                <section class="font-sans break-normal text-gray-900 ">
                    @foreach ($comments as $comment)
                        <div class="my-2">
                            <span class="font-bold mr-3">{{ $comment->user->name }}</span>
                            <span class="text-sm">{{ $comment->created_at }}</span>
                            <p>{!! nl2br(e($comment->body)) !!}</p>

                            <div class="flex justify-end text-center my-4">
                                @can('update', $comment)
                                    <a href="{{ route('posts.comments.edit', [$post, $comment]) }}"
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">編集</a>
                                @endcan
                                @can('delete', $comment)
                                    <form action="{{ route('posts.comments.destroy', [$post, $comment]) }}" method="post">
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
                
                <div class="content">
                    <style type="text/css">
                        button.stripe-button-el,
                        button.stripe-button-el>span {
                            background-color: #c50067 !important;
                            background-image: none;
                        }
                    </style>
                    <form action="{{ route('charge') }}" method="POST">
                        {{ csrf_field() }}
                        <script src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-key="{{ env('STRIPE_KEY') }}"
                                                data-amount="1000" data-name="Stripe Demo" data-label="レンタルする"
                                                data-description="Online course about integrating Stripe"
                                                data-image="https://stripe.com/img/documentation/checkout/marketplace.png" data-locale="auto"
                                                data-currency="JPY">
                        </script>
                    </form>
                </div>
                
            @endauth
        </div>
</x-app-layout>

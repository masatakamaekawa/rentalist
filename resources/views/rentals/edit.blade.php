<x-app-layout>
    <div class="container lg:w-1/2 md:w-4/5 w-11/12 mx-auto mt-8 px-8 bg-white shadow-md">
        <h2 class="text-center text-lg font-bold pt-6 tracking-widest">レンタル商品編集</h2>

        <x-validation-errors :errors="$errors" />

        <form action="{{ route('rentals.update', $rental) }}" method="POST" enctype="multipart/form-data"
            class="rounded pt-3 pb-8 mb-4">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="title">
                    商品名
                </label>
                <input type="text" name="title" id="title"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3"
                    required placeholder="タイトル" value="{{ old('title', $rental->title) }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="price">
                    価格
                </label>
                <input type="text" name="price" id="price"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3"
                    required placeholder="タイトル" value="{{ old('price', $rental->price) }}">
            </div>
                <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="days">
                    レンタル日数
                </label>
                <input type="text" name="days" id="days"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3"
                    required placeholder="タイトル" value="{{ old('days', $rental->days) }}">
            </div>
                <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="brand">
                    ブランド
                </label>
                <input type="text" name="brand" id="brand"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3"
                    required placeholder="タイトル" value="{{ old('brand', $rental->brand) }}">
            </div>
                <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="category">
                    カテゴリー
                </label>
                <input type="text" name="category" id="category"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3"
                    required placeholder="タイトル" value="{{ old('category', $rental->category) }}">
            </div>
                <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="area">
                    エリア
                </label>
                <input type="text" name="area" id="area"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3"
                    required placeholder="タイトル" value="{{ old('area', $rental->area) }}">
            </div>
                <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="delivery">
                    配送方法
                </label>
                <input type="text" name="delivery" id="delivery"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3"
                    required placeholder="タイトル" value="{{ old('delivery', $rental->delivery) }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="body">
                    詳細
                </label>
                <textarea name="body" rows="10" id="body"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3"
                    required placeholder="本文">{{ old('body', $rental->body) }}</textarea>
            </div>
            <input type="submit" value="更新"
                class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        </form>
    </div>
</x-app-layout>
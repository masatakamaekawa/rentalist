<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                
            </div>
        </div>
    </div>
    <div class="container mx-auto w-3/5 my-8 px-4 py-4">
        <div class="flex justify-end items-center mb-3">
            <h4 class="text-gray-400 text-sm">公開状況</h4>
            <ul class="flex">
                @foreach (EntryConst::STATUS_LIST as $name => $value)
                    <li class="ml-4">
                        @if (strpos(url()->full(), 'status=' . $value) ||
                            (!strpos(url()->full(), 'status') && entryConst::STATUS_OPEN == $value))
                            <a href="?status={{ $value }}" 
                                class="hover:text-blue-500 text-green-500 font-bold">{{ $name }}</a>
                        @else
                            <a href="?status={{ $value }}"
                                class="hover:text-blue-500">{{ $name }}</a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
        <div>
            @foreach ($rentals as $j)
                <div class="bg-white w-full px-10 py-8 hover:shadow-2xl transition duration-500">
                    <div class="mt-4">
                        <div class="flex justify-between text-sm items-center mb-4">
                            <div class="border border-gray-900 px-2 h-7 leading-7 rounded-full">{{ $j->occupation->name }}</div>
                            <div class="text-gray-700 text-sm text-right">
                                <span>応募期限 :{{ $j->due_date }}</span>
                                <span class="inline-block mx-1">|</span>
                                <span>エントリー :{{ $j->Entries->count() }}</span>
                            </div>
                        </div>
                        <h2 class="text-lg text-gray-700 font-semibold">{{ $j->title }}
                        </h2>
                        <p class="mt-4 text-md text-gray-600">
                            {{ Str::limit($j->description, 50) }}
                        </p>
                        <div class="flex justify-end items-center">
                            <a href="{{ route('rentals.show', $j) }}" class="flex justify-center bg-gradient-to-r from-indigo-500 to-blue-600 hover:bg-gradient-to-l hover:from-blue-500 hover:to-indigo-600 text-gray-100 mt-4 px-5 py-3 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500">more</a>
                        </div>
                    </div>
                </div>
                <hr>
            @endforeach
            <dif class="block mt-3">
                {{ $rentals->links() }}
            </dif>
        </div>
    </div>
</x-app-layout>
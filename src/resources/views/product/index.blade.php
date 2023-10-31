<x-app-layout>
    <x-slot name="header">
        <x-message :message="session('message')" />
        <br>
        <form action="{{ route('product.index') }}" method="GET">
            @csrf
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
            <div class="relative">
                <input type="text" id="default-search" class="block p-4 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="アプリを検索" name="keyword">
                <button type="submit" class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2" value="検索">検索</button>
            </div>
        </form>
    </x-slot>

    <section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">
        <div class="flex flex-wrap -m-4">
            @foreach ($products as $product)
                <div class="p-4 w-full md:w-1/3">
                    <div class="h-full border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
                        <div class="image-container">
                            @if($product->image)
                                @if (App::environment('local'))
                                    <a href="{{ route('product.show', $product) }}">
                                        <img src="{{ asset('storage/images/' . $product->image) }}" alt="Description" class="product-image">
                                    </a>
                                @else
                                    <a href="{{ route('product.show', $product) }}">
                                        <img src="{{ $product->image }}" alt="Description" class="product-image">
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('product.show', $product) }}">
                                    <img src="https://dummyimage.com/720x400" alt="Description" class="product-image">
                                </a>
                            @endif
                        </div>
                    <div class="p-6">
                        <h2 class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1">{{ $product->created_at->format('Y-m-d') }}</h2>
                        <h1 class="title-font text-lg font-medium text-gray-900 mb-3">
                            <a href="{{ route('product.show', $product) }}">{{ $product->name }}</a>
                        </h1>
                        <p class="leading-relaxed mb-3">{{ $product->content }}</p>


                        <div class="p-2">
                            @foreach ($product->tags as $index => $tag)
                                <div class="relative inline-block py-2">
                                    <a href="{{ route('product.index', ['tag_id' => $tag->id]) }}" class="text-xs">{{ $tag->name }}</a>

                                    @if ($index < count($product->tags) - 1) {{-- 最後のタグの前まで '/' を表示 --}}
                                        <span class="mx-1 text-xs">/</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="flex items-center flex-wrap ">
                            <a class="text-indigo-500 inline-flex items-center md:mb-2 lg:mb-0" href="{{ $product->url }}" target="_blank">アプリを見にいく
                                <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="M12 5l7 7-7 7"></path>
                                </svg>
                            </a>
                            <span class="text-gray-400 mr-3 inline-flex items-center lg:ml-auto md:ml-0 ml-auto leading-none text-sm pr-3 py-1">by: {{ $product->user->name }}
                            </span>
                            <button class="toggle-stock mr-3 inline-flex items-center lg:ml-auto md:ml-0 ml-auto leading-none text-sm pr-3 py-1" data-id="{{ $product->id }}">
                                <i class="{{ $product->isStockedBy(Auth::user()) ? 'fa-solid' : 'fa-regular' }} fa-folder fa-lg"></i>
                            </button>
                        </div>
                    </div>
                    </div>
                </div>
            @endforeach
        </div>
        <br>
        {{ $products->links() }}
    </div>
    </section>
</x-app-layout>

<x-app-layout>
    <section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">
        <div class="flex flex-wrap -m-4">
            @foreach ($products as $product)
                <div class="p-4 md:w-1/3">
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
                                    <img src="https://dummyimage.com/720x400" alt="Description" class="product-image"
                                </a>
                            @endif
                        </div>
                    <div class="p-6">
                        <h2 class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1">{{ $product->created_at->format('Y-m-d') }}</h2>
                        <h1 class="title-font text-lg font-medium text-gray-900 mb-3">
                            <a href="{{ route('product.show', $product) }}">{{ $product->name }}</a>
                        </h1>
                        <p class="leading-relaxed mb-3">{{ $product->content }}</p>
                        <div class="flex items-center flex-wrap ">
                        <a class="text-indigo-500 inline-flex items-center md:mb-2 lg:mb-0" href="{{ $product->url }}">アプリを見にいく
                            <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"></path>
                            <path d="M12 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        <span class="text-gray-400 mr-3 inline-flex items-center lg:ml-auto md:ml-0 ml-auto leading-none text-sm pr-3 py-1">
                            <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                            </svg>{{ $product->user->name }}
                        </span>
                        </div>
                    </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </section>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            アプリ詳細画面
        </h2>
    </x-slot>

    <section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto flex flex-wrap">
        <div class="lg:w-1/2 w-full mb-10 lg:mb-0 rounded-lg overflow-hidden">
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
                        <img class="lg:h-48 md:h-36 w-full object-cover object-center" src="https://dummyimage.com/720x400" alt="blog">
                    </a>
                @endif
            </div>
        </div>
        <div class="flex flex-col flex-wrap lg:py-6 -mb-10 lg:w-1/2 lg:pl-12 lg:text-left text-center">
            <div class="flex flex-col mb-5 lg:items-start items-center">
                <div class="inline-flex bg-indigo-100 text-indigo-500 mb-3 py-1 px-3 rounded">
                    アプリ名
                </div>
                <div class="flex-grow">
                    <h2 class="text-gray-900 text-lg title-font font-medium mb-3">{{ $product->name }}</h2>
                    <p class="leading-relaxed text-base mb-3">{{ $product->content }}</p>
                    <h2 class="text-gray-900  title-font font-medium">by {{ $product->user->name }}</h2>
                </div>
            </div>
            <div class="flex flex-col mb-5 lg:items-start items-center">
                <div class="inline-flex bg-indigo-100 text-indigo-500 mb-3 py-1 px-3 rounded">
                    URL
                </div>
                <div class="flex-grow">
                    <a href="{{ $product->url }}" class="text-gray-900 text-lg title-font font-medium">{{ $product->url }}</a>
                </div>
            </div>
            <div class="flex flex-col mb-5 lg:items-start items-center">
                <div class="inline-flex bg-indigo-100 text-indigo-500 mb-3 py-1 px-3 rounded">
                    コードURL
                </div>
                <div class="flex-grow">
                    <a href="{{ $product->code_url }}" class="text-gray-900 text-lg title-font font-medium">{{ $product->code_url }}</a>
                </div>
            </div>
        </div>
    </div>
    </section>
</x-app-layout>

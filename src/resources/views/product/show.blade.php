<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            アプリ詳細画面
        </h2>
        <x-message :message="session('message')" />
    </x-slot>

    <section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto flex flex-wrap">
        <div class="lg:w-1/2 w-full mb-10 lg:mb-0 rounded-lg overflow-hidden">
            <div class="image-container">
                @if($product->image)
                    @if (App::environment('local'))
                        <img src="{{ asset('storage/images/' . $product->image) }}" alt="Description" class="product-image">
                    @else
                        <img src="{{ $product->image }}" alt="Description" class="product-image">
                    @endif
                @else
                    <img src="https://dummyimage.com/720x400" alt="Description" class="product-image">
                @endif
            </div>
            <br>
            <div class="p-2">
                <div class="inline-flex bg-indigo-100 text-indigo-500 mb-3 py-1 px-3 rounded">
                    使用技術
                </div>
                <br>
                @foreach ($product->tags as $index => $tag)
                    <div class="relative inline-block py-2">
                        <label for="checkbox{{ $tag->id }}" class="text-s">{{ $tag->name }}</label>

                        @if ($index < count($product->tags) - 1) {{-- 最後のタグの前まで '/' を表示 --}}
                            <span class="mx-1 text-s">/</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        <div class="flex flex-col flex-wrap lg:py-6 -mb-10 lg:w-1/2 lg:pl-12 lg:text-left items-start">
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
                    <a href="{{ $product->url }}" class="text-gray-900 text-lg title-font font-medium" target="_blank">{{ $product->url }}</a>
                </div>
            </div>
            <div class="flex flex-col mb-5 lg:items-start items-center">
                <div class="inline-flex bg-indigo-100 text-indigo-500 mb-3 py-1 px-3 rounded">
                    コードURL
                </div>
                <div class="flex-grow">
                    <a href="{{ $product->code_url }}" class="text-gray-900 text-lg title-font font-medium" target="_blank">{{ $product->code_url }}</a>
                </div>
            </div>
            @auth
                @if (auth()->user()->id === $product->user_id)
                    <div class="flex justify-end mt-4 mb-5 lg:items-start items-center justify-end mt-4">
                        <a href="{{route('product.edit', $product)}}"><x-primary-button class="bg-teal-700 float-right">編集</x-primary-button></a>
                        <form method="post" action="{{route('product.destroy', $product)}}">
                            @csrf
                            @method('delete')
                            <x-primary-button class="bg-red-700 float-right ml-4" onClick="return confirm('本当に削除しますか？');">削除</x-primary-button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </div>
    </section>
</x-app-layout>

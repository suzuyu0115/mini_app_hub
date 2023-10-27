<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            アプリを編集
        </h2>
        <x-input-error class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" :messages="$errors->all()"/>
        <x-message :message="session('message')" />
    </x-slot>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mx-4 sm:p-8">
                <form method="post" action="{{ route('product.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="md:flex items-center mt-8">
                        <div class="w-full flex flex-col">
                            <label for="name" class="font-semibold leading-none mt-4">サービス名</label>
                            <input type="text" name="name" class="w-auto py-2 placeholder-gray-300 border border-gray-300 rounded-md" id="name" value="{{ old('name', $product->name) }}">
                        </div>
                    </div>

                    <div class="w-full flex flex-col">
                            <label for="content" class="font-semibold leading-none mt-4">概要</label>
                            <textarea name="content" class="w-auto py-2 border border-gray-300 rounded-md" id="content" cols="30" rows="10">{{ old('content', $product->content) }}</textarea>
                    </div>

                    <div class="md:flex items-center mt-8">
                        <div class="w-full flex flex-col">
                            <label for="url" class="font-semibold leading-none mt-4">サービスURL</label>
                            <input type="text" name="url" class="w-auto py-2 placeholder-gray-300 border border-gray-300 rounded-md" id="url" value="{{ old('url', $product->url) }}">
                        </div>
                    </div>

                    <div class="md:flex items-center mt-8">
                        <div class="w-full flex flex-col">
                            <label for="code_url" class="font-semibold leading-none mt-4">コードURL</label>
                            <input type="text" name="code_url" class="w-auto py-2 placeholder-gray-300 border border-gray-300 rounded-md" id="code_url" value="{{ old('code_url', $product->code_url) }}">
                        </div>
                    </div>

                    <br>
                    <div class="w-full flex flex-col">
                        @if($product->image)
                            <img src="{{ asset('storage/images/'.$product->image)}}" class="mx-auto" style="height:300px;">
                        @endif
                        <label for="image" class="font-semibold leading-none mt-4">OGP画像</label>
                        <div>
                            <input id="image" type="file" name="image">
                        </div>
                    </div>

                    <x-primary-button class="mt-4">
                        編集する
                    </x-primary-button>

                </form>
            </div>
        </div>
</x-app-layout>

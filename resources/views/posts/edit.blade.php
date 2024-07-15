<x-app-layout>
<x-slot name="header">
        <div class="div flex  items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Post') }}
            </h2>
            <a href="{{ route('posts.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                {{ __('Back') }}
            </a>
        </div>
    </x-slot>

    @if(session('success'))
    <div class="max-w-6xl mx-auto bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a1 1 0 010 1.414L11.414 10l2.934 2.934a1 1 0 11-1.414 1.414L10 11.414l-2.934 2.934a1 1 0 01-1.414-1.414L8.586 10 5.652 7.066a1 1 0 111.414-1.414L10 8.586l2.934-2.934a1 1 0 011.414 0z"/></svg>
        </span>
    </div>
    @endif

    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('posts.update', $post) }}">
            @csrf
            @method('patch')
            <x-input-label for="title" :value="__('Title')" />
            <x-text-input id="title" class="block mt-1 w-full mb-2" type="text" name="title" placeholder="{{ __('Post title') }}" :value="old('title', $post->title)" required autofocus autocomplete="title" />
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
            <x-input-label for="body" :value="__('Content')" class="mb-2" />
            <textarea
                name="body"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('body', $post->body) }}</textarea>
            <x-input-error :messages="$errors->get('body')" class="mt-2" />

            <!-- Tags -->
            <div class="mt-4">
                <x-input-label for="post_groups" :value="__('Tags')" />
                <select id="post_groups" name="post_groups[]" class="block mt-1 w-full" multiple>
                    @foreach($postGroups as $postGroup)
                        <option value="{{ $postGroup->id }}" @if($post->postGroups->contains($postGroup->id)) selected @endif>{{ $postGroup->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('post_groups')" class="mt-2" />
            </div>

            <div class="mt-4 space-x-2">
                <x-primary-button>{{ __('Update') }}</x-primary-button>
                <a href="{{ route('posts.index') }}">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>
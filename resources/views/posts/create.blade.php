<x-app-layout>
<x-slot name="header">
        <div class="div flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Post') }}
            </h2>
            <a href="{{ route('posts.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                {{ __('Back') }}
            </a>
        </div>
    </x-slot>


    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf
            <x-input-label for="title" :value="__('Title')" />
            <x-text-input id="title" class="block mt-1 w-full mb-2" type="text" name="title" placeholder="{{ __('Post title') }}" :value="old('title')" required autofocus autocomplete="title" />
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
            <x-input-label for="body" :value="__('Content')" class="mb-2" />
            <textarea
                name="body"
                rows="10"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                placeholder="{{ __('Enter content here') }}"
            >{{ old('body') }}</textarea>
            <x-input-error :messages="$errors->get('body')" class="mt-2" />

            <!-- Post Groups Tags -->
            <div class="mt-4">
                <x-input-label for="post_groups" :value="__('Tags')" />
                <x-select-multiple-input
                    id="post_groups" 
                    name="post_groups[]" 
                    :options="$postGroups->pluck('name', 'id')->toArray()"
                    :value="old('post_groups', [])"
                    class="mt-1 block w-full"
                    />
                <x-input-error :messages="$errors->get('post_groups')" class="mt-2" />
            </div>

            <!-- Images Upload -->
            <div class="mt-8">
                <x-input-label for="images" :value="__('Upload Images Max 2MB')" />
                <input id="images" type="file" name="images[]" class="block mt-1 w-full" multiple />
                <x-input-error :messages="$errors->get('images')" class="mt-2" />
            </div>

            <!-- Documents Upload -->
            <div class="mt-8">
                <x-input-label for="documents" :value="__('Upload Documents(PDF/Docx) Max 5MB')" />
                <input id="documents" type="file" name="documents[]" class="block mt-1 w-full" multiple accept=".pdf,.docx" />
                <x-input-error :messages="$errors->get('documents')" class="mt-2" />
            </div>

            <div class="mt-4 space-x-2">
                <x-primary-button>{{ __('Create') }}</x-primary-button>
                <a href="{{ route('posts.index') }}">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>
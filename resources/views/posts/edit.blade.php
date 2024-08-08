<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
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
        <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <x-input-label for="title" :value="__('Title')" />
            <x-text-input id="title" class="block mt-1 w-full mb-2" type="text" name="title" placeholder="{{ __('Post title') }}" :value="old('title', $post->title)" required autofocus autocomplete="title" />
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
            <x-input-label for="body" :value="__('Content')" class="mb-2" />
            <textarea
                name="body"
                rows="10"
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

            @if($post->images->isNotEmpty())
            <!-- Existing Images -->
            <div class="mt-8">
                <x-input-label :value="__('Existing Images')" />
                <div class="grid grid-cols-3 gap-4">
                    @foreach($post->images as $image)
                        <div id="image-{{$image->id}}"class="relative flex mr-4">
                            <img src="{{ asset($image->url) }}" alt="Image" class="w-full h-auto">
                            <!-- Add a delete button or other controls if necessary -->
                            <button type="button" class="self-start text-red-500 hover:text-red-700" onclick="confirmDeleteImage({{$image->id}})">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Images Upload -->
            <div class="mt-8">
                <x-input-label for="images" :value="__('Upload Images')" />
                <input id="images" type="file" name="images[]" class="block mt-1 w-full" multiple />
                <x-input-error :messages="$errors->get('images')" class="mt-2" />
            </div>

            @if($post->documents->isNotEmpty())
            <!-- Existing documents -->
            <div class="mt-8">
                <x-input-label :value="__('Existing Documents')" />
                <div class="flex flex-col">
                    @foreach($post->documents as $document)
                    <div class="flex items-center border-t hover:underline hover:text-blue-700">
                        <div id="document-{{$document->id}}" class="flex justify-between py-2 w-full">
                        @php
                            $originalFilename = basename($document->url);
                            $filenameParts = explode('_', $originalFilename);
                            $customFilename = implode('_', array_slice($filenameParts, 4));
                        @endphp
                        <a href="{{ asset($document->url) }}" target="_blank" class="text-blue-600">
                            {{ $customFilename }}
                        </a>
                        <button type="button" class="text-red-500 hover:text-red-700" onclick="confirmDeleteDocument({{$document->id}})">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Documents Upload -->
            <div class="mt-8">
                <x-input-label for="documents" :value="__('Upload Documents(PDF)')" />
                <input id="documents" type="file" name="documents[]" class="block mt-1 w-full" multiple accept=".pdf" />
                <x-input-error :messages="$errors->get('documents')" class="mt-2" />
            </div>

            <div class="mt-8 space-x-2">
                <x-primary-button>{{ __('Update') }}</x-primary-button>
                <a href="{{ route('posts.index') }}">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>

<script>
    // Add CSRF token meta tag in the <head> section of your HTML
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function confirmDeleteDocument(id) {
        // Show confirmation dialog
        const isConfirmed = confirm('Are you sure you want to delete this document?');
        
        if (isConfirmed) {
            // Proceed with AJAX deletion
            deleteDocument(id);
        }
    }

    async function deleteDocument(id) {
        try {
            const response = await fetch(`/posts/edit/document/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if (response.ok) {
                // Remove the document div from the DOM
                document.getElementById(`document-${id}`).remove();
            } else {
                // Handle errors (optional)
                console.error('Failed to delete document');
                alert('Failed to delete document. Please try again.');
            }
        } catch (error) {
            // Handle fetch errors (optional)
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        }
    }

    function confirmDeleteImage(id) {
        // Show confirmation dialog
        const isConfirmed = confirm('Are you sure you want to delete this image?');
        
        if (isConfirmed) {
            // Proceed with AJAX deletion
            deleteImage(id);
        }
    }

    async function deleteImage(id) {
        try {
            const response = await fetch(`/posts/edit/image/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if (response.ok) {
                // Remove the image div from the DOM
                document.getElementById(`image-${id}`).remove();
            } else {
                // Handle errors (optional)
                console.error('Failed to delete image');
                alert('Failed to delete image. Please try again.');
            }
        } catch (error) {
            // Handle fetch errors (optional)
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        }
    }
</script>

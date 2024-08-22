<div class="flex space-x-2 bg-white shadow-sm rounded-lg p-6">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
    </svg>
    <div class="flex-1">
        <div class="flex justify-between items-center">
            <div>
                <span class="text-blue-800">
                    <a href="{{ route('profile.show', $post->user)}}" >
                        {{ $post->user->name }}
                    </a>
                </span>
                <span class="text-gray-900 text-xl">{{ __('>') }}</span>
                <span class="text-gray-800 font-bold">{{ $post->post_groups_names }}</span>
                <div class="-mt-2">
                    <small class="text-sm text-gray-600">on {{ $post->created_at->format('j M Y, g:i a') }}</small>
                    @unless ($post->created_at->eq($post->published_at))
                        <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                    @endunless
                </div>
            </div>
            @if ($post->user->is(auth()->user()))
                <x-dropdown>
                    <x-slot name="trigger">
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('posts.edit', $post)">
                            {{ __('Edit') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('posts.destroy', $post) }}">
                            @csrf
                            @method('delete')
                            <x-dropdown-link :href="route('posts.destroy', $post)" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Delete') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            @endif
        </div>

        <h1 class="mt-4 text-lg text-gray-900"><strong>{{ $post->title }}</strong></h1>
        <p class="mt-4 text-lg text-gray-900">{{ $post->body }}</p>

        @if($post->images->isNotEmpty())
            @include('posts.post-images')
        @endif

        @if($post->documents->isNotEmpty())
        <div class="mt-2 flex flex-col border-t">
            @foreach($post->documents as $document)
            <div class="flex items-center py-2 hover:bg-gray-50">
                <div class="flex space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-blue-600 hover:text-blue-700 size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
                @php
                    $originalFilename = basename($document->url);
                    $filenameParts = explode('_', $originalFilename);
                    $customFilename = implode('_', array_slice($filenameParts, 4));
                @endphp
                <a href="{{ asset($document->url) }}" target="_blank" class="text-blue-600 hover:text-blue-700 hover:underline">
                    {{ $customFilename }}
                </a>
                </div>
                <!-- Add a delete button or other controls if necessary -->
            </div>
            <hr>
            @endforeach
        </div>
        @endif

        <hr class="my-4">
        
        <!-- Action Buttons -->
        <div class="flex items-center space-x-4">    
            <x-like-button :post="$post" />
            <x-comment-button :post="$post" />
            <x-bookmark-button :post="$post" />
        </div>

        <!-- Show Comments Link Button -->
        <button id="show-comments-btn-{{ $post->id }}" 
                data-post-id="{{ $post->id }}" 
                class="show-comments-btn my-2 text-base text-blue-800"
                onclick="toggleComments({{ $post->id }})" 
                {{ $post->comment_count >= 1 ? '' : 'disabled' }}>
                @if($post->comment_count >= 1)
                    Show Comments
                @else
                    <span class="text-gray-800"></span>
                @endif
                </button>

        <!-- Comments Section -->
        <div id="comments-section-{{ $post->id }}" class="mt-2 hidden"></div>

        <!-- Add a message input section-->
        <div class="max-w-lg py-2">
            <form id="comment-form-{{ $post->id }}" method="POST" action="{{ route('comments.store') }}">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <div class="flex">
                    @php $inputName = "title-$post->id"; @endphp
                    <textarea
                        name="{{ $inputName }}"
                        placeholder="{{ __('Leave a comment...') }}"
                        rows="1"
                        required
                        class="block w-full border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-l-lg shadow-sm"
                    >{{ old($inputName) }}</textarea>
                    
                    <button type="button" onclick="submitComment({{ $post->id }})" class="border border-gray-300 px-4 rounded-r-lg shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 hover:text-blue-600" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get($inputName)" class="mt-2" />
            </form>
        </div>

    </div>
</div>
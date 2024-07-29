<div class="comment-box max-w-lg">
    <div class="flex space-x-1"> 
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" viewBox="0 0 24 24" fill="currentColor" class="size-6">
        <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
        </svg>

        <div>      
            <div class="div flex space-x-2">
            <span class="text-blue-800">
                <a href="{{ route('profile.show', $comment->user)}}" >
                    {{ $comment->user->name }}
                </a>
            </span>
            <div class="div">
                    <small class="text-sm text-gray-600">on {{ $comment->created_at->format('j M, g:i a') }}</small>
                    @unless ($comment->created_at->eq($comment->updated_at))
                        <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                    @endunless
                </div>
            </div>
            <div class="div -mt-0.5">
                {{  $comment->message }}
            </div>
        </div>
    </div>
</div>
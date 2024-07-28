<!-- resources/views/components/bookmark-button.blade.php -->
<div>
    <button class="bookmark-button" data-post-id="{{ $post->id }}" data-bookmarked="{{ $bookmarked ? 'true' : 'false' }}">
    @if ($bookmarked)
            <!-- Filled Bookmark Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M5 3v16.5l7-3.15 7 3.15V3z" />
            </svg>
        @else
            <!-- Outline Bookmark Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v16.5l7-3.15 7 3.15V3z" />
            </svg>
        @endif
    </button>
</div>


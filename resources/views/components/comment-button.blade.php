<!-- resources/views/components/comment-button.blade.php -->
<div class="flex space-x-1">
    <button class="comment-button" data-post-id="{{ $post->id }}" data-commented="{{ $commented ? 'true' : 'false' }}" data-user-comments-count="{{ $userCommentsCount }}" onclick="toggleComments({{ $post->id }})" {{ $post->comment_count >= 1 ? '' : 'disabled' }}>
    @if ($userCommentsCount >= 1)
            <!-- Filled comment Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 hover:text-blue-600" viewBox="0 0 24 24" fill="currentColor" class="size-6" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.068.157 2.148.279 3.238.364.466.037.893.281 1.153.671L12 21l2.652-3.978c.26-.39.687-.634 1.153-.67 1.09-.086 2.17-.208 3.238-.365 1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
            </svg>
        @else
            <!-- Outline comment Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 hover:text-blue-600" viewBox="0 0 24 24" fill="none" class="size-6" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.068.157 2.148.279 3.238.364.466.037.893.281 1.153.671L12 21l2.652-3.978c.26-.39.687-.634 1.153-.67 1.09-.086 2.17-.208 3.238-.365 1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
            </svg>
        @endif
    </button>
    <span id="comment-count-{{ $post->id }}"class="comment-count min-w-3">{{ $post->comment_count }}</span>
</div>

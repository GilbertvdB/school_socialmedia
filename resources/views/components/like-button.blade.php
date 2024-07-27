<!-- resources/views/components/like-button.blade.php -->
<div>
    <button class="like-button" data-post-id="{{ $post->id }}" data-liked="{{ $liked ? 'true' : 'false' }}">
        {{ $liked ? 'Unlike' : 'Like' }}
    </button>
    <span class="like-count">{{ $post->like_count }}</span>
</div>

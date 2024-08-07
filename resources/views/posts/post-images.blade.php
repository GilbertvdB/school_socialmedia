<div class="mt-4 flex space-x-2 border">
    <!-- @foreach($post->images as $image) -->
        <div class="border">
            <img src="{{ asset($image->url) }}" alt="Image" class="">
        </div>
    <!-- @endforeach -->
</div>
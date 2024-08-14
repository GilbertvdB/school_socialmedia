<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Bookmarks') }}
            </h2>
            <a href="{{ URL::previous() }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                {{ __('Back') }}
            </a>
        </div>
    </x-slot>
    
    <div class="max-w-7xl mx-auto p-6 sm:px-6 lg:p-8">
        <div class="grid gap-y-8">
            @if ($bookmarks->isEmpty())
                <p>No bookmarks available.</p>
            @else
                @foreach ($bookmarks as $bookmark)
                    @include('posts.post-box', ['post' => $bookmark->post])
                @endforeach
            @endif
        </div>

        <div class="mt-4">
            {{ $bookmarks->links() }}
        </div>
    </div>
    <script> const userId = {{ Auth::id() }}; </script>
    <script src="{{ asset('js/comments.js') }}"></script>
</x-app-layout>

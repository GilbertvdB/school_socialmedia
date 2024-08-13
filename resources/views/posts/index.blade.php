<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Posts') }}
            </h2>
            <a href="{{ route('posts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                {{ __('Add Post') }}
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
    @if ($posts->isEmpty())
        <p class="text-gray-700">No items available.</p>
    @else
        <div class="grid gap-y-8">
            @foreach ($posts as $post)
                @include('posts.post-box')
            @endforeach
        </div>

        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    @endif
    </div>
    <script> const userId = {{ Auth::id() }}; </script>
    <script src="{{ asset('js/comments.js') }}"></script>
</x-app-layout>
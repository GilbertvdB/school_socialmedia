<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight py-2">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>
    
    <div class="max-w-6xl mx-auto p-6 sm:px-6 lg:p-8">
        <div class="mt-4 grid gap-y-8">
            @foreach ($posts as $post)
                @include('posts.post-box')
            @endforeach
        </div>
    </div>
</x-app-layout>

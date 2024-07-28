<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation-vertical')

            
            <div class="flex flex-col-2">
                <div class="hidden sm:flex border relative bg-white w-1/5">
                    <div class="flex flex-col w-full">
                        <div class="sticky top-0">
                            <!-- Navigation Links -->
                            <div class="hidden space-y-1 sm:-my-px sm:flex">
                                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                    {{ __('Dashboard') }}
                                </x-nav-link>
                            </div>
                            
                            @unless(Auth::user()->role === 'parent')
                            <div class="hidden space-y-1 sm:-my-px sm:flex">
                                <x-nav-link :href="route('posts.index')" :active="request()->routeIs('posts.*')">
                                    {{ __('Posts') }}
                                </x-nav-link>
                            </div>
                            @endunless

                            @if( Auth::user()->role === 'admin' )
                            <div class="hidden space-y-1 sm:-my-px sm:flex">
                                <x-nav-link :href="route('classrooms.index')" :active="request()->routeIs('classrooms.*')">
                                    {{ __('Classrooms') }}
                                </x-nav-link>
                            </div>
                            <div class="hidden space-y-1 sm:-my-px sm:flex">
                                <x-nav-link :href="route('postgroups.index')" :active="request()->routeIs('postgroups.*')">
                                    {{ __('Post Groups') }}
                                </x-nav-link>
                            </div>
                            <div class="hidden space-y-1 sm:-my-px sm:flex">
                                <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                                    {{ __('Users') }}
                                </x-nav-link>
                            </div>
                            <div class="hidden space-y-1 sm:-my-px sm:flex">
                                <x-nav-link :href="route('students.index')" :active="request()->routeIs('students.*')">
                                    {{ __('Students') }}
                                </x-nav-link>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Page Content -->
                <main class="w-full">
                    <!-- Page Heading -->
                    @isset($header)
                        <header class="bg-white shadow">
                            <div class="max-w-7xl mx-auto py-1 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endisset
                    
                    {{ $slot }}
                </main>
                <!-- Like/Unlike button -->    
                <script>
                document.addEventListener('DOMContentLoaded', function () {
                    document.body.addEventListener('click', function (event) {
                        // Handle like button click
                        const likeButton = event.target.closest('.like-button');
                
                        if (likeButton) {
                            const postId = likeButton.getAttribute('data-post-id');
                            const liked = likeButton.getAttribute('data-liked') === 'true';

                            fetch(`/posts/${postId}/toggle-like`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({})
                            })
                            .then(response => response.json())
                            .then(data => {
                                const likeIcon = likeButton.querySelector('svg');

                                const likeCountSpan = likeButton.nextElementSibling;
                                likeCountSpan.textContent = data.like_count;

                                if (data.liked) {
                                    // Replace with filled bookmark icon
                                    likeIcon.setAttribute('fill', 'currentColor');
                                    likeButton.setAttribute('data-bookmarked', 'true');
                                } else {
                                    // Replace with outline bookmark icon
                                    likeIcon.setAttribute('fill', 'none');
                                    likeButton.setAttribute('data-bookmarked', 'false');
                                }
                            });
                        }

                        // Handle bookmark button click
                        const bookmarkButton = event.target.closest('.bookmark-button');
                
                        if (bookmarkButton) {
                            const postId = bookmarkButton.getAttribute('data-post-id');
                            const bookmarked = bookmarkButton.getAttribute('data-bookmarked') === 'true';

                            fetch(`/posts/${postId}/toggle-bookmark`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({})
                            })
                            .then(response => response.json())
                            .then(data => {
                                const bookmarkIcon = bookmarkButton.querySelector('svg');
                                if (data.bookmarked) {
                                    // Replace with filled bookmark icon
                                    bookmarkIcon.setAttribute('fill', 'currentColor');
                                    bookmarkIcon.innerHTML = `
                                        <path d="M5 3v16.5l7-3.15 7 3.15V3z" />
                                    `;
                                    bookmarkButton.setAttribute('data-bookmarked', 'true');
                                } else {
                                    // Replace with outline bookmark icon
                                    bookmarkIcon.setAttribute('fill', 'none');
                                    bookmarkIcon.innerHTML = `
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v16.5l7-3.15 7 3.15V3z" />
                                    `;
                                    bookmarkButton.setAttribute('data-bookmarked', 'false');
                                }
                            });
                        }
                    });
                });
            </script>


            
            </div>
        </div>
    </body>
</html>

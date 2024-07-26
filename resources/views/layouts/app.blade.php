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
            </div>
        </div>
    </body>
</html>

@php
    use App\Enums\Role;
@endphp
<div class="hidden sm:flex border relative bg-white w-1/5 min-h-screen">
    <div class="flex flex-col w-full">
        <div class="sticky top-0">
            <!-- Navigation Links -->
            <div class="hidden space-y-1 sm:-my-px sm:flex">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>
            </div>
            
            @if(Auth::user()->role !== Role::Parent && Auth::user()->role !== Role::Student)
            <div class="hidden space-y-1 sm:-my-px sm:flex">
                <x-nav-link :href="route('posts.index')" :active="request()->routeIs('posts.*')">
                    {{ __('Posts') }}
                </x-nav-link>
            </div>
            @endif

            @if( Auth::user()->role === Role::Admin )
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
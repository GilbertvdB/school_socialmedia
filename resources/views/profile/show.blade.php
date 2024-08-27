<x-app-layout>
<x-slot name="header">
        <div class="div flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('View Profile') }}
            </h2>
            <a href="{{ URL::previous() }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                {{ __('Back') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Profile') }}
                        </h2>
                    </header>
                    <hr class="mb-4">
                    <div class="flex flex-col">
                        <div class="w-24 h-24 rounded-full overflow-hidden border border-gray-200">
                            <img src="https://via.placeholder.com/150" alt="Profile Image" class="w-full h-full object-cover">
                        </div>
                        <div class="mt-4">
                            <div class="text-xl font-medium text-gray-900">{{ $user->name }}{{ $user->firstname }} {{ $user->lastname }}</div>
                        </div>
                    </div>
                </div>
            </div>


            @if($user->role)
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.show-contact-information')
                </div>
            </div>

                @if( $user->role === Role::Parent)
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border">
                    <div class="max-w-xl">
                        @include('profile.partials.show-children-information')
                    </div>
                </div>
                @endif
            @endif

            @if( !$user->role)
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border">
                <div class="max-w-xl">
                    @include('profile.partials.show-parent-information')
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>

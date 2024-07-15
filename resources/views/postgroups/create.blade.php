<x-app-layout>
    <x-slot name="header">
        <div class="div flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add PostGroups') }}
            </h2>
            <a href="{{ route('postgroups.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                {{ __('Back') }}
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('postgroups.store') }}">
            @csrf

            <!-- Group Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Group Description -->
            <div class="mt-4">
                <x-input-label for="description" :value="__('Description')" />
                <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description')" required />
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ms-4">
                    {{ __('Add PostGroup') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>

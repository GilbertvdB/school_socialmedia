<x-app-layout>
    <x-slot name="header">
        <div class="div flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add Classrooms') }}
            </h2>
            <a href="{{ route('classrooms.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                {{ __('Back') }}
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('classrooms.store') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Capacity -->
            <div class="mt-4">
                <x-input-label for="capacity" :value="__('Capacity')" />
                <x-text-input id="capacity" class="block mt-1 w-full" type="number" name="capacity" :value="old('capacity')" required />
                <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ms-4">
                    {{ __('Add Classroom') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>

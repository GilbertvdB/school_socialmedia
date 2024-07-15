<x-app-layout>
    <x-slot name="header">
        <div class="div flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Classrooms') }}
            </h2>
            <a href="{{ route('classrooms.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                {{ __('Back') }}
            </a>
        </div>
    </x-slot>

    @if(session('success'))
    <div class="max-w-6xl mx-auto bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a1 1 0 010 1.414L11.414 10l2.934 2.934a1 1 0 11-1.414 1.414L10 11.414l-2.934 2.934a1 1 0 01-1.414-1.414L8.586 10 5.652 7.066a1 1 0 111.414-1.414L10 8.586l2.934-2.934a1 1 0 011.414 0z"/></svg>
        </span>
    </div>
    @endif

    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('classrooms.update', $classroom) }}">
            @csrf
            @method('patch')
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $classroom->name)" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Capacity -->
            <div class="mt-4">
                <x-input-label for="capacity" :value="__('Capacity')" />
                <x-text-input id="capacity" class="block mt-1 w-full" type="number" name="capacity" :value="old('capacity', $classroom->capacity)" required />
                <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ms-4">
                    {{ __('Edit Classroom') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
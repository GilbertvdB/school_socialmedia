@php
    use App\Enums\Gender;
@endphp
<x-app-layout>
<x-slot name="header">
<div class="div flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Student') }}
            </h2>
            <a href="{{ route('students.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                {{ __('Back') }}
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('students.store') }}">
            @csrf
            <!-- Firstname -->
            <div>
                <x-input-label for="firstname" :value="__('Firstname')" />
                <x-text-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" placeholder="Stundents given name" required autofocus autocomplete="firstname" />
                <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
            </div>

            <!-- Lastname -->
            <div>
                <x-input-label for="lastname" :value="__('Lastname')" />
                <x-text-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" placeholder="Students last name" required autofocus autocomplete="lastname" />
                <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
            </div>

            <!-- Birthdate -->
            <div class="mt-4">
                <x-input-label for="birthdate" :value="__('Year of Birth')" />
                <x-text-input id="birthdate" class="block mt-1 w-full" type="date" name="birthdate" :value="old('birthdate')" required />
                <x-input-error :messages="$errors->get('birthdate')" class="mt-2" />
            </div>

            <!-- Gender -->
            <div class="mt-4">
                <x-input-label for="gender" :value="__('Gender')" />
                <x-select-input 
                    id="gender" 
                    name="gender" 
                    class="mt-1 block w-full"
                    :options="Gender::toArray()" 
                    :value="old('gender')"
                    required 
                    autocomplete="gender" />
                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
            </div>
            
            <!-- Classroom -->
            <div class="mt-4">
                <x-input-label for="classroom" :value="__('Classroom')" />
                <x-select-multiple-input
                    id="classroom" 
                    name="classroom[]" 
                    :options="$classrooms->pluck('name', 'id')->toArray()"
                    :value="old('classroom', [])"
                    class="mt-1 block w-full"
                    />
                <x-input-error :messages="$errors->get('classroom')" class="mt-2" />
            </div>

            <!-- Parents Select Mutiple -->
            <div class="mt-4">
                <x-input-label for="parents" :value="__('Parents')" />
                <x-select-multiple-input
                    id="parents" 
                    name="parents[]" 
                    :options="$parents->pluck('name', 'id')"
                    :value="old('parents', [])"
                    class="mt-1 block w-full"
                    />
                <x-input-error :messages="$errors->get('parents')" class="mt-2" />
            </div>


            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ms-4">
                    {{ __('Add student') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>

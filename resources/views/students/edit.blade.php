@php
    use App\Enums\Gender;
@endphp
<x-app-layout>
<x-slot name="header">
<div class="div flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Student') }}
            </h2>
            <a href="{{ route('students.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
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
        <form method="POST" action="{{ route('students.update', $student) }}">
            @csrf
            @method('patch')
            <!-- Firstname -->
            <div>
                <x-input-label for="firstname" :value="__('Firstname')" />
                <x-text-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname', $student->firstname)" required autofocus autocomplete="firstname" />
                <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
            </div>

            <!-- Lastname -->
            <div>
                <x-input-label for="lastname" :value="__('Lastname')" />
                <x-text-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname', $student->lastname)" required autofocus autocomplete="lastname" />
                <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
            </div>

            <!-- Birthdate -->
            <div class="mt-4">
                <x-input-label for="birthdate" :value="__('Year of Birth')" />
                <x-text-input id="birthdate" class="block mt-1 w-full" type="date" name="birthdate" :value="old('birthdate', $student->birthdate)" required />
                <x-input-error :messages="$errors->get('birthdate')" class="mt-2" />
            </div>

            <!-- Gender Enum Select-->
            <div class="mt-4">
                <x-input-label for="gender" :value="__('Gender')" />
                <x-select-input 
                    id="gender" 
                    name="gender" 
                    :options="Gender::toArray()" 
                    :value="old('gender', $student->gender)"
                    class="mt-1 block w-full"
                    required 
                    autocomplete="gender"
                    />
                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
            </div>
            
            <!-- Classroom Select Multiple -->
            <div class="mt-4">
                <x-input-label for="classroom" :value="__('Classroom')" />
                <x-select-multiple-input
                    id="classroom" 
                    name="classroom[]" 
                    :options="$classrooms->pluck('name', 'id')->toArray()"
                    :value="$student->classroom->pluck('id')->toArray()"
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
                    :options="$parents->pluck('name', 'id')->toArray()"
                    :value="$student->parents->pluck('id')->toArray()"
                    class="mt-1 block w-full"
                    />
                <x-input-error :messages="$errors->get('parents')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ms-4">
                    {{ __('Edit student') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>

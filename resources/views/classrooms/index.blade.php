<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Classrooms') }}
            </h2>
            <a href="{{ route('classrooms.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                {{ __('Add Classroom') }}
            </a>
        </div>
    </x-slot>
    
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">

        <!-- display table -->
        <div class="container mx-auto">
            
            <x-table :items="$classrooms" 
                 :columns="['Name', 'Capacity']" 
                 :fields="['name', 'capacity']"
                 editRoute="classrooms.edit"
                 deleteRoute="classrooms.destroy" />
        </div>

    </div>
</x-app-layout>
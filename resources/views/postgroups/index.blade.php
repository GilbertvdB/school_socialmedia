<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('PostGroups') }}
            </h2>
            <a href="{{ route('postgroups.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                {{ __('Add PostGroup') }}
            </a>
        </div>
    </x-slot>
    
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">

        <!-- display table -->
        <div class="container mx-auto">
            
        <x-table :items="$postGroups" 
                 :columns="['Name', 'Description']" 
                 :fields="['name', 'description']"
                 editRoute="postgroups.edit"
                 deleteRoute="postgroups.destroy" />
        </div>

    </div>
</x-app-layout>
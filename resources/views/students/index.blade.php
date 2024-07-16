<x-app-layout>
<x-slot name="header">
    <div class="div flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Students') }}
            </h2>
            <a href="{{ route('students.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                {{ __('Add Student') }}
            </a>
        </div>
    </x-slot>
    
    <div class="max-w-6xl mx-auto p-4 sm:p-6 lg:p-8 border">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Students Table') }}
            </h2>

        <!-- display table -->
        <div class="container mx-auto px-4">
            <!-- <h1 class="text-2xl font-bold mb-4">Students</h1> -->
            
            @if ($students->isEmpty())
                <p class="text-gray-700">No students available.</p>
            @else
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-300">FirstName</th>
                            <th class="py-2 px-4 border-b border-gray-300">LastName</th>
                            <th class="py-2 px-4 border-b border-gray-300">Birthdate</th>
                            <th class="py-2 px-4 border-b border-gray-300">Gender</th>
                            <th class="py-2 px-4 border-b border-gray-300">Class</th>
                            <th class="py-2 px-4 border-b border-gray-300">Parents</th>
                            <th class="py-2 px-4 border-b border-gray-300 text-right">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $student->firstname }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $student->lastname }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $student->birthdate }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ ucfirst($student->gender) }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center"> {{ $student->classroom_name }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center"> 
                                    <!-- Settings Dropdown -->
                                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                                        <x-dropdown align="left" width="48">
                                            <x-slot name="trigger">
                                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                    <div>{{ __('Parents') }}</div>

                                                    <div class="ms-1">
                                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                </button>
                                            </x-slot>

                                            <x-slot name="content">
                                            @foreach( $student->parents as $parent )
                                                <x-dropdown-link :href="route('profile.edit')">
                                                    {{ $parent->name }}
                                                </x-dropdown-link>
                                            @endforeach
                                            </x-slot>
                                        </x-dropdown>
                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-gray-300 text-right">
                                    <a href="{{ route('students.edit', $student->id) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                    <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 ml-2" onclick="return confirm('Are you sure you want to delete this student?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>
</x-app-layout>
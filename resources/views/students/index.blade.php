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
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ __('Parents') }}</td>
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
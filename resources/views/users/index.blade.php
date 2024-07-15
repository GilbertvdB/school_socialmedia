<x-app-layout>
<x-slot name="header">
    <div class="div flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users') }}
            </h2>
            <a href="{{ route('register') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                {{ __('Add User') }}
            </a>
        </div>
    </x-slot>
    
    <div class="max-w-6xl mx-auto p-4 sm:p-6 lg:p-8 border">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users Table') }}
            </h2>

        <!-- display table -->
        <div class="container mx-auto px-4">
            <!-- <h1 class="text-2xl font-bold mb-4">Users</h1> -->
            
            @if ($users->isEmpty())
                <p class="text-gray-700">No users available.</p>
            @else
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-300">Name</th>
                            <th class="py-2 px-4 border-b border-gray-300">Email</th>
                            <th class="py-2 px-4 border-b border-gray-300">Role</th>
                            <th class="py-2 px-4 border-b border-gray-300">Post Groups</th>
                            <th class="py-2 px-4 border-b border-gray-300 text-right">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $user->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $user->email }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $user->role }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $user->post_groups_names }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-right">
                                    <a href="{{ route('users.edit', $user->id) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 ml-2" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
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
@if ($items->isEmpty())
    <p class="text-gray-700">No items available.</p>
@else
    <table class="min-w-full bg-white rounded-t-lg">
        <thead>
            <tr class="text-left">
                @foreach ($columns as $column)
                    <th class="py-4 px-4 border-b border-gray-300">{{ $column }}</th>
                @endforeach
                <th class="py-4 px-4 border-b border-gray-300">Actions</th>
            </tr>
        </thead>    
        <tbody class="border">
            @foreach ($items as $item)
                <tr class="odd:bg-gray-50 even:bg-white hover:bg-indigo-50 text-left">
                    @foreach ($fields as $field)
                        <td class="py-4 px-4 border-b border-gray-300">{{ $item->$field }}</td>
                    @endforeach
                    <td class="py-4 px-4 border-b border-gray-300">
                        <a href="{{ route($editRoute, $item->id) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                        <form action="{{ route($deleteRoute, $item->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 ml-2" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $items->links() }}
    </div>
@endif

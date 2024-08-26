<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Children') }}
        </h2>
    </header>
    <hr class="mb-4">

    @if ($user->students->isEmpty())
        <p class="text-gray-700 italic">No child/children registered yet.</p>
    @else
        @foreach($user->students as $child)
        <div class="mb-4">
            <a href="{{ route('students.show', $child->uuid)}}" class="text-lg font-medium text-blue-700">
                {{ $child->firstname }} {{ $child->lastname }}
            </a>
        </div>
        @endforeach
    @endif
</section>

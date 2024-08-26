<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Parents') }}
        </h2>
    </header>
    <hr class="mb-4">

    @if ($user->parents->isEmpty())
        <p class="text-gray-700 italic">No parent registered yet.</p>
    @else
        @foreach($user->parents as $parent)
        <div class="mb-4">
            <a href="{{ route('profile.show', $parent->uuid)}}" class="text-lg font-medium text-blue-700">
                {{ $parent->name }}
            </a>
        </div>
        @endforeach
    @endif
</section>

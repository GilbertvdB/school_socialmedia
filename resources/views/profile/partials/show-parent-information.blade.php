<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Parents') }}
        </h2>
    </header>
    <hr class="mb-4">

    @foreach($user->parents as $parent)
    <div class="mb-4">
        <a href="{{ route('profile.show', $parent)}}" class="text-lg font-medium text-blue-700">
            {{ $parent->name }}
        </a>
    </div>
    @endforeach
</section>

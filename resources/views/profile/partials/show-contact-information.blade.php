<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Contact Information') }}
        </h2>
    </header>
    <hr class="mb-4">

    <div>
        <p>{{ $user->email }}</p>
        @if($user->role === Role::Parent && $user->contact)
            <p>{{ $user->contact->number }}</p>
            <p>{{ $user->contact->address }}</p>
            <p>{{ $user->contact->postal_code }}</p>
            <p>{{ $user->contact->city }}</p>
        @endif
    </div>
</section>

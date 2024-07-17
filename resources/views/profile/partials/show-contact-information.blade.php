<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Contact Information') }}
        </h2>
    </header>
    <hr class="mb-4">
    
    <div>
        <p>{{ $user->email }}</p>
        @if($user->role == 'parent')
            <p>+31 06 nummer</p>
            <p>Adressstraat 24, Stadmere</p>
        @endif
    </div>
</section>

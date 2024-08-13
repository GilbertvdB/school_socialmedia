<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight py-2">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div id="posts-container" class="max-7xl mx-auto p-6 sm:px-6 lg:p-8">
    @if ($posts->isEmpty())
        <p class="text-gray-700">No items available.</p>
    @else
        <div class="grid gap-y-8">
            @foreach ($posts as $post)
                @include('posts.post-box', ['post' => $post])
            @endforeach
        </div>
    @endif
    </div>

    <div id="loading" class="text-center py-4 flex" style="display: none;">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 animate-spin">
        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
        </svg>
        <span class="text-gray-500">Loading...</span>
    </div>

    <script>
        const userId = {{ Auth::id() }}; // Logged-in user's ID
        let page = 1;
        let loading = false;

        const loadMorePosts = () => {
            if (loading) return Promise.resolve(); // Prevent multiple requests
            loading = true;
            page++;
            return fetch(`{{ url('dashboard/posts?page=') }}${page}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const postsContainer = document.querySelector('#posts-container .grid');
                    postsContainer.insertAdjacentHTML('beforeend', data.html);
                    nextPageUrl = data.next_page_url;
                    if (!nextPageUrl) {
                        window.removeEventListener('scroll', handleScroll);
                    }
                    loading = false;
                })
                .catch(error => {
                    console.error('Error loading more posts:', error);
                    loading = false; // Reset loading state on error
                });
        };

        const handleScroll = () => {
            const { scrollTop, scrollHeight, clientHeight } = document.documentElement;
            if (scrollTop + clientHeight >= scrollHeight - 5) {
                document.getElementById('loading').style.display = 'block';
                loadMorePosts().then(() => {
                    document.getElementById('loading').style.display = 'none';
                });
            }
        };

        window.addEventListener('scroll', handleScroll);
    </script>
    <script src="{{ asset('js/comments.js') }}"></script>
</x-app-layout>
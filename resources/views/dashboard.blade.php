<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight py-2">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div id="posts-container" class="max-w-6xl mx-auto p-6 sm:px-6 lg:p-8">
        <div class="grid gap-y-8">
            @foreach ($posts as $post)
                @include('posts.post-box', ['post' => $post])
            @endforeach
        </div>
    </div>

    <div id="loading" class="text-center py-4" style="display: none;">
        <span class="text-gray-500">Loading...</span>
    </div>

    <script>
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
</x-app-layout>

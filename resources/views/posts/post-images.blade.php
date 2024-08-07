<button x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'view-post-images-{{$post->id}}')">
    <div class="mt-4 flex space-x-2 overflow-hidden h-20 lg:h-40 md:h-40 sm:h-20 relative">
        @foreach($post->images->slice(0, 4) as $index => $image)
            <div class="{{ $index >= 2 ? 'hidden sm:block' : '' }}">
                <img src="{{ asset($image->url) }}" alt="Image" class="w-full h-full object-cover">
            </div>
        @endforeach
            @if(count($post->images) > 1)
            <div class="w-content h-full px-4 flex items-center round-lg shadow-sm bg-gray-50">
                More ...
            </div>
            @endif
        <div class="w-full h-1/5 bg-white/75 absolute bottom-4 flex items-center">
            <span class="pl-6">{{ count($post->images)}}{{ count($post->images) > 1 ? '+ Images' : ' Image' }}</span>
        </div>
    </div>
</button>

<x-modal name="view-post-images-{{$post->id}}" maxWidth="6xl"> 
    <div class="flex overflow-hidden relative">
        <!-- Slider Container -->
        <div id="slider-{{$post->id}}" class="flex transition-transform duration-500 ease-in-out">
            @foreach($post->images as $image)
                <div class="w-full flex-shrink-0">
                    <img src="{{ asset($image->url) }}" alt="Image" class="w-full h-full object-cover">
                </div>
            @endforeach
        </div>

        <!-- Navigation Buttons -->
        <button id="prev-{{$post->id}}" class="absolute top-1/2 left-0 transform -translate-y-1/2 bg-gray-800 text-white p-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button id="next-{{$post->id}}" class="absolute top-1/2 right-0 transform -translate-y-1/2 bg-gray-800 text-white p-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slider = document.getElementById('slider-{{$post->id}}');
            const slides = slider.children;
            const totalSlides = slides.length;
            let currentIndex = 0;
    
            const nextButton = document.getElementById('next-{{$post->id}}');
            const prevButton = document.getElementById('prev-{{$post->id}}');
    
            nextButton.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % totalSlides;
                updateSlider();
            });
    
            prevButton.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
                updateSlider();
            });
    
            function updateSlider() {
                slider.style.transform = `translateX(-${currentIndex * 100}%)`;
            }
        });
    </script>
</x-modal> 

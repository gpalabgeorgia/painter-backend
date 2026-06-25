@if($videoData)
    <section class="video-section">
        <div class="container video-container">

            <div class="video-wrapper" id="customVideoPlayer" style="position: relative; width: 100%; aspect-ratio: 16 / 9; overflow: hidden;">
                <video id="mainVideo"
                       poster="{{ $videoData->video_cover ? asset($videoData->video_cover) : asset('img/painter-artist-portfolio-home-about-painter-img.jpg') }}"
                       style="width: 100%; height: 100%; object-fit: cover; display: block; position: absolute; top: 0; left: 0;">
                    <source src="{{ asset($videoData->video_url) }}" type="video/mp4">
                    Your browser not approve video
                </video>

                <button class="play-btn" id="videoPlayBtn" aria-label="Play video" style="z-index: 2;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                </button>
            </div>

            {{-- Динамическая подпись из базы данных --}}
            <h2 class="video-caption">{{ $videoData->title ?? 'Awards' }}</h2>
        </div>
    </section>
@endif

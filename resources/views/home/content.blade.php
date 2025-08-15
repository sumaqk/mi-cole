@include('home/layout/header')

<style>
    .content-container {
        padding: 40px 20px;
        min-height: 100vh;
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        animation: aguaTranquila 20s ease-in-out infinite;
    }

    @keyframes aguaTranquila {

        0%,
        70% {
            background: linear-gradient(105deg, #4facfe 0%, #00f2fe 100%);
        }

        40% {
            background: linear-gradient(105deg, #4facfe 0%, #00f2fe 100%);
        }
    }

    .page-title {
        text-align: center;
        color: #fff;
        font-size: 3rem;
        font-weight: bold;
        margin-bottom: 50px;
    }

    .category-section {
        margin-bottom: 40px;
        /* Reducido para eliminar espacios */
    }

    .category-header {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 25px;
        padding-left: 20px;
    }

    .category-icon {
        margin-right: 15px;
        filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.3));
        font-size: 2rem;
        color: #fff;
    }

    .category-title {
        color: #fff;
        font-size: 1.8rem;
        font-weight: 600;
        display: flex;
        justify-content: center;
        text-align: center;
    }

    .content-type-header {
        color: #fff;
        font-size: 1.2rem;
        margin-bottom: 15px;
        padding-left: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .content-type-icon {
        margin-right: 10px;
        font-size: 1.4rem;
    }

    .carousel-container {
        position: relative;
        overflow: hidden;
        margin-bottom: 20px;
        padding: 15px 0;
    }

    .carousel {
        display: flex;
        gap: 20px;
        padding: 0 20px;
        scroll-behavior: auto;
        overflow-x: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
        /* justify-content: center; */
        justify-content: flex-start;
        align-items: center;
    }

    .carousel::-webkit-scrollbar {
        display: none;
    }

    .content-card {
        min-width: 320px;
        height: 280px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 192, 255, 05);
        overflow: hidden;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .content-card::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(45deg, #00f2fe, #4facfe, #00f2fe, #4facfe);
        background-size: 400% 400%;
        border-radius: 17px;
        z-index: -1;
        opacity: 0;
        animation: neonRotate 3s linear infinite;
        transition: opacity 0.3s ease;
    }

    .content-card:hover::before {
        opacity: 1;
    }

    /* @keyframes neonRotate {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    } */

    .card-image {
        width: 100%;
        height: 160px;
        /* background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); */
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        border-bottom: 1px solid #dee2e6;
        overflow: hidden;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .content-card:hover .card-image img {
        transform: scale(1.1);
    }

    .card-image i {
        font-size: 3.5rem;
        color: #6c757d;
        opacity: 0.8;
    }

    .card-content {
        padding: 15px;
        height: 120px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
    }

    .card-title {
        font-size: 1rem;
        font-weight: 600;
        color: #333;
        margin: 0 0 4px 0;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.0em;
    }

    .card-description {
        font-size: 0.85rem;
        color: #666;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 10px;
        flex-grow: 1;
        min-height: 2.8em;
    }

    .card-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        padding-top: 8px;
        border-top: 1px solid #f0f0f0;
    }

    .card-type {
        background: linear-gradient(45deg, #667eea, #764ba2);
        color: white;
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .card-views {
        color: #666;
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .featured-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: linear-gradient(45deg, #feca57, #ff9ff3);
        color: white;
        padding: 5px 8px;
        border-radius: 15px;
        font-size: 0.7rem;
        font-weight: bold;
        z-index: 5;
    }

    .scroll-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.9);
        border: none;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        font-size: 1.2rem;
        color: #333;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .scroll-btn:hover {
        background: white;
        transform: translateY(-50%) scale(1.1);
    }

    .scroll-btn.left {
        left: 10px;
    }

    .scroll-btn.right {
        right: 10px;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
    }

    .modal-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 20px;
        border-radius: 10px;
        max-width: 90%;
        max-height: 90%;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .modal-video {
        width: 900px;
        height: 600px;
    }

    .modal-content-doc {
        width: 900px;
        height: 700px;
    }

    .modal-close {
        position: absolute;
        top: 10px;
        right: 15px;
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        z-index: 1001;
    }

    .modal-close:hover {
        color: black;
    }

    .file-header {
        padding: 15px 20px;
        background: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        margin: -20px -20px 0 -20px;
        border-radius: 10px 10px 0 0;
    }

    .content-info {
        padding: 20px;
        background: #fff;
        border-bottom: 1px solid #dee2e6;
        max-height: 200px;
        overflow-y: auto;
    }

    .content-info h4 {
        margin: 0 0 10px 0;
        color: #333;
        font-size: 1.1rem;
    }

    .content-info p {
        margin: 0;
        color: #666;
        line-height: 1.5;
        font-size: 0.9rem;
    }

    .file-viewer {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 0;
    }

    .file-embed {
        flex: 1;
        width: 100%;
        border: none;
        min-height: 400px;
    }

    iframe,
    video,
    audio,
    embed {
        width: 100%;
        height: 100%;
        border: none;
    }

    .card-content.no-description {
        justify-content: center;
    }

    .card-content.no-description .card-title {
        margin-bottom: auto;
    }

    @media (max-width: 768px) {

        .modal-video,
        .modal-content-doc {
            width: 95%;
            height: 70vh;
        }

        .page-title {
            font-size: 2rem;
        }

        .content-card {
            min-width: 280px;
            height: 260px;
        }

        .card-image {
            height: 140px;
        }

        .card-content {
            height: 100px;
        }
    }

    .card-type.pdf {
        background: linear-gradient(45deg, #dc3545, #e74c3c);
    }

    .card-type.audio {
        background: linear-gradient(45deg, #28a745, #2ecc71);
    }

    .card-type.video {
        background: linear-gradient(45deg, #007bff, #3498db);
    }

    .card-type.youtube {
        background: linear-gradient(45deg, #ff0000, #ff4757);
    }

    .titulo {
        color: #fff,
            font-weight: bold;
        font-size: 39px;
    }

    .subtitulos {
        color: #fff,
            font-weight: bold;
        font-size: 20px;
    }

    .audio-player-card {
        margin: 0px 0;
        padding: 0px;
        /* background: rgba(0, 242, 254, 0.1);
        border-radius: 8px;
        border: 1px solid rgba(0, 242, 254, 0.3); */
    }

    .audio-player-card audio {
        width: 100%;
        height: 35px;
        outline: none;
        border-radius: 5px;
    }

    .audio-player-card audio::-webkit-media-controls-panel {
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 5px;
    }

    .video-card-image {
        position: relative;
    }

    .video-play-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(0, 0, 0, 0.7);
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        transition: all 0.3s ease;
        z-index: 5;
    }

    .video-play-overlay:hover {
        background: rgba(0, 0, 0, 0.9);
        transform: translate(-50%, -50%) scale(1.1);
    }

    .content-card:hover .video-play-overlay {
        background: rgba(0, 242, 254, 0.9);
        box-shadow: 0 0 20px rgba(0, 242, 254, 0.5);
    }
</style>

<div class="content-container">
    <h1 class="page-title titulo"><i class="fas fa-book" style="color: #fffff;"></i> Contenido Educativo</h1>

    @foreach ($categoriesWithContent as $categoryName => $categoryData)
        <div class="category-section">
            <div class="category-header">
                {{-- <div class="category-icon">{!! $categoryData['icon'] !!}</div> --}}
                <h2 class="category-title ">{{ $categoryName }}</h2>
            </div>
            @if (!empty($categoryData['contents']))
                <div class="content-type-header">
                    <i class="fas fa-file-pdf" style="color: #fff;"></i>
                    Contenido
                </div>
                <div class="carousel-container">
                    <button class="scroll-btn left" onclick="scrollCarousel('content-{{ $loop->index }}', 'left')">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <div class="carousel" id="content-{{ $loop->index }}">
                        @foreach ($categoryData['contents'] as $content)
                            @if (in_array($content->file_type, ['mp3', 'wav']))
                                <div class="content-card">
                                @else
                                    <div class="content-card"
                                        onclick="openContentModal('{{ $content->id }}', '{{ addslashes($content->title) }}', '{{ $content->content_file }}', '{{ $content->file_type }}', '{{ addslashes($content->content) }}')">
                            @endif

                            <div class="card-image">
                                @if (!empty($content->thumbnail))
                                    <img src="{{ asset('storage/contenido/images/' . $content->thumbnail) }}"
                                        alt="{{ $content->title }}"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                                    <div
                                        style="display: none; align-items: center; justify-content: center; width: 100%; height: 100%;">
                                        @if ($content->file_type == 'pdf')
                                            <i class="fas fa-file-pdf" style="color: #dc3545; font-size: 3.5rem;"></i>
                                        @elseif(in_array($content->file_type, ['mp3', 'wav']))
                                            <i class="fas fa-music" style="color: #28a745; font-size: 3.5rem;"></i>
                                        @else
                                            <i class="fas fa-file-text" style="font-size: 3.5rem;"></i>
                                        @endif
                                    </div>
                                @else
                                    @if ($content->file_type == 'pdf')
                                        <i class="fas fa-file-pdf" style="color: #dc3545; font-size: 3.5rem;"></i>
                                    @elseif(in_array($content->file_type, ['mp3', 'wav']))
                                        <i class="fas fa-music" style="color: #28a745; font-size: 3.5rem;"></i>
                                    @else
                                        <i class="fas fa-file-text" style="font-size: 3.5rem;"></i>
                                    @endif
                                @endif

                                @if ($content->is_featured)
                                    <div class="featured-badge">⭐ Destacado</div>
                                @endif
                            </div>
                            <div class="card-meta">
                            </div>

                            <div class="card-content {{ empty($content->excerpt) ? 'no-description' : '' }}">
                                <h3 class="card-title">{{ $content->title }}</h3>

                                @if (in_array($content->file_type, ['mp3', 'wav']))
                                    <div class="audio-player-card">
                                        <audio controls style="width: 100%; height: 35px;">
                                            <source
                                                src="{{ asset('storage/contenido/files/' . $content->content_file) }}"
                                                type="audio/{{ $content->file_type }}">
                                            Tu navegador no soporta audio HTML5.
                                        </audio>
                                    </div>
                                @else
                                    @if (!empty($content->excerpt))
                                        <div class="card-description">{{ $content->excerpt }}</div>
                                    @endif
                                @endif
                            </div>
                    </div>
            @endforeach
        </div>
        <button class="scroll-btn right" onclick="scrollCarousel('content-{{ $loop->index }}', 'right')">
            <i class="fas fa-chevron-right"></i>
        </button>
</div>
@endif

    @if (!empty($categoryData['videos']))
    <div class="content-type-header subtitulos">
        <i class="fas fa-file-video" style="color: #fff"></i>
        Videos Relacionados
    </div>
    
    {{-- AGREGA ESTE DIV CONTENEDOR --}}
    <div class="carousel-container">
        {{-- BOTÓN IZQUIERDO --}}
        <button class="scroll-btn left" onclick="scrollCarousel('video-{{ $loop->index }}', 'left')">
            <i class="fas fa-chevron-left"></i>
        </button>
        
        <div class="carousel" id="video-{{ $loop->index }}">
            @foreach ($categoryData['videos'] as $video)
                <div class="content-card"
                    onclick="openVideoModal('{{ $video->id }}', '{{ addslashes($video->title) }}', '{{ $video->video_file ?? '' }}', '{{ $video->youtube_url ?? '' }}')">

                    <div class="card-image video-card-image">
                        @if (!empty($video->thumbnail))
                            <img src="{{ asset('storage/videos/thumbnails/' . $video->thumbnail) }}"
                                alt="{{ $video->title }}"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                            <div style="display: none; align-items: center; justify-content: center; width: 100%; height: 100%;">
                                @if ($video->youtube_url)
                                    <i class="fab fa-youtube" style="color: #ff0000; font-size: 3.5rem;"></i>
                                @else
                                    <i class="fas fa-play-circle" style="color: #007bff; font-size: 3.5rem;"></i>
                                @endif
                            </div>
                        @else
                            @if ($video->youtube_url)
                                <i class="fab fa-youtube" style="color: #ff0000; font-size: 3.5rem;"></i>
                            @else
                                <i class="fas fa-play-circle" style="color: #007bff; font-size: 3.5rem;"></i>
                            @endif
                        @endif

                        <div class="video-play-overlay">
                            @if ($video->youtube_url)
                                <i class="fab fa-youtube"></i>
                            @else
                                <i class="fas fa-play"></i>
                            @endif
                        </div>
                    </div>

                    <div class="card-content {{ empty($video->description) ? 'no-description' : '' }}">
                        <h3 class="card-title">{{ $video->title }}</h3>

                        @if (!empty($video->description))
                            <div class="card-description">{{ $video->description }}</div>
                        @endif
                        {{-- <div class="card-meta">
                            <span class="card-type {{ $video->youtube_url ? 'youtube' : 'video' }}">
                                @if ($video->youtube_url)
                                    📺 YouTube
                                @else
                                    🎬 Video
                                @endif
                            </span>
                            <span class="card-views">
                                <i class="fas fa-play"></i>
                                Ver
                            </span>
                        </div> --}}
                    </div>
                </div>
            @endforeach
        </div>
        
        {{-- BOTÓN DERECHO --}}
        <button class="scroll-btn right" onclick="scrollCarousel('video-{{ $loop->index }}', 'right')">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
@endif

</div>
@endforeach
</div>

<!-- Modal para contenido -->
<div id="contentModal" class="modal">
    <div class="modal-content modal-content-doc">
        <span class="modal-close" onclick="closeModal()">&times;</span>
        <div class="file-header">
            <h3 id="modalTitle" style="margin: 0;"></h3>
        </div>
        <div id="modalBody" class="file-viewer"></div>
    </div>
</div>

<!-- Modal para videos -->
<div id="videoModal" class="modal">
    <div class="modal-content modal-video">
        <span class="modal-close" onclick="closeModal()">&times;</span>
        <div class="file-header">
            <h3 id="videoModalTitle" style="margin: 0;"></h3>
        </div>
        <div id="videoModalBody" class="file-viewer"></div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
<script>
    function openContentModal(id, title, fileName, fileType, content) {
        document.getElementById('modalTitle').innerHTML = title;

        let modalBodyContent = '';

        // Descripción arriba
        if (content && content.trim() !== '') {
            modalBodyContent += '<div class="content-info"><h4>Descripción:</h4><p>' + content + '</p></div>';
        }

        // Archivo abajo
        if (fileName && fileType) {
            if (fileType === 'pdf') {
                modalBodyContent += '<embed src="/storage/contenido/files/' + fileName +
                    '" type="application/pdf" class="file-embed">';
            } else if (fileType === 'mp3' || fileType === 'wav') {
                modalBodyContent +=
                    '<div style="padding: 20px; text-align: center;"><audio controls style="width: 100%; max-width: 500px;"><source src="/storage/contenido/files/' +
                    fileName + '" type="audio/' + fileType + '">Tu navegador no soporta audio HTML5.</audio></div>';
            } else {
                modalBodyContent = content || 'No hay contenido disponible';
            }
        } else {
            modalBodyContent = content || 'No hay contenido disponible';
        }

        document.getElementById('modalBody').innerHTML = modalBodyContent;
        document.getElementById('contentModal').style.display = 'block';
    }

    function openVideoModal(id, title, videoFile, youtubeUrl) {
        document.getElementById('videoModalTitle').innerHTML = title;

        if (youtubeUrl) {
            const videoId = extractYouTubeId(youtubeUrl);
            document.getElementById('videoModalBody').innerHTML = '<iframe src="https://www.youtube.com/embed/' +
                videoId + '" allowfullscreen></iframe>';
        } else if (videoFile) {
            document.getElementById('videoModalBody').innerHTML =
                '<video controls style="width: 100%; height: 100%;"><source src="/storage/videos/' + videoFile +
                '" type="video/mp4">Tu navegador no soporta videos HTML5.</video>';
        }

        document.getElementById('videoModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('contentModal').style.display = 'none';
        document.getElementById('videoModal').style.display = 'none';
        document.getElementById('videoModalBody').innerHTML = '';
        document.getElementById('modalBody').innerHTML = '';
    }

    function extractYouTubeId(url) {
        const regex = /(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/;
        const match = url.match(regex);
        return match ? match[1] : '';
    }

    function scrollCarousel(carouselId, direction) {
        const carousel = document.getElementById(carouselId);
        const scrollAmount = 350;

        const startPos = carousel.scrollLeft;
        const targetPos = direction === 'left' ?
            Math.max(0, startPos - scrollAmount) :
            startPos + scrollAmount;

        const duration = 200;
        const startTime = performance.now();

        function animate(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const easeProgress = 1 - Math.pow(1 - progress, 3);

            carousel.scrollLeft = startPos + (targetPos - startPos) * easeProgress;

            if (progress < 1) {
                requestAnimationFrame(animate);
            }
        }

        requestAnimationFrame(animate);
    }

    function initAutoScroll() {
        const carousels = document.querySelectorAll('.carousel');

        carousels.forEach(carousel => {
            const container = carousel.parentElement;
            const cards = carousel.children.length;

            if (cards > 3) {
                let scrollInterval;

                container.addEventListener('mousemove', (e) => {
                    const rect = container.getBoundingClientRect();
                    const mouseX = e.clientX - rect.left;
                    const containerWidth = rect.width;
                    const mousePercent = mouseX / containerWidth;

                    clearInterval(scrollInterval);

                    // Si el mouse está en el lado izquierdo, scroll a la izquierda
                    if (mousePercent < 0.3) {
                        scrollInterval = setInterval(() => {
                            carousel.scrollLeft -= 5;
                        }, 16);
                    }
                    // Si el mouse está en el lado derecho, scroll a la derecha  
                    else if (mousePercent > 0.7) {
                        scrollInterval = setInterval(() => {
                            carousel.scrollLeft += 5;
                        }, 16);
                    }
                });

                container.addEventListener('mouseleave', () => {
                    clearInterval(scrollInterval);
                });
            }
        });
    }

    window.onclick = function(event) {
        const contentModal = document.getElementById('contentModal');
        const videoModal = document.getElementById('videoModal');

        if (event.target === contentModal || event.target === videoModal) {
            closeModal();
        }
    }

    function checkImageExists(img) {
        img.onerror = function() {
            this.style.display = 'none';
            const fallback = this.nextElementSibling;
            if (fallback) {
                fallback.style.display = 'flex';
            }
        };
    }

    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('.card-image img');
        images.forEach(checkImageExists);
        initAutoScroll();
    });
</script>

@include('home/layout/footer')

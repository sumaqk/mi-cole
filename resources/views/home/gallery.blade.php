@include('home/layout/header')

<style>
    body {
        background: linear-gradient(135deg, #0077be 0%, #00a8cc 100%);
        min-height: 100vh;
        overflow-x: hidden;
    }

    .water-wave {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(0, 119, 190, 0.1) 0%, rgba(0, 168, 204, 0.1) 100%);
        overflow: hidden;
        z-index: -1;
    }

    .water-wave::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 200%;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1000 100'%3E%3Cpath d='M421.9,6.5c22.6-2.5,51.5,0.4,75.5,5.3c23.6,4.9,70.9,23.5,100.5,35.7c75.8,32.2,133.7,44.5,192.6,49.7c23.6,2.1,48.7,3.5,103.4-2.5c54.7-6,106.2-25.6,106.2-25.6V0H0v30.3c0,0,72,32.6,158.4,30.5c39.2-0.7,92.8-6.7,133-18.6c27.7-8.2,44.6-16.6,69.5-18.8C384.4,20.9,400.4,21.4,421.9,6.5z' fill='rgba(255,255,255,0.1)'/%3E%3C/svg%3E") repeat-x;
        animation: wave 10s linear infinite;
    }

    @keyframes wave {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    .bubble {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        animation: float 6s ease-in-out infinite;
        z-index: 1;
    }

    .bubble:nth-child(1) {
        width: 40px;
        height: 40px;
        left: 10%;
        animation-delay: 0s;
    }

    .bubble:nth-child(2) {
        width: 20px;
        height: 20px;
        left: 20%;
        animation-delay: 2s;
    }

    .bubble:nth-child(3) {
        width: 60px;
        height: 60px;
        left: 35%;
        animation-delay: 4s;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(100vh) rotate(0deg);
            opacity: 0;
        }

        10%,
        90% {
            opacity: 1;
        }

        50% {
            transform: translateY(-10vh) rotate(180deg);
        }
    }

    .water-header {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        position: relative;
        overflow: hidden;
        min-height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .header-content {
        text-align: center;
        z-index: 2;
        position: relative;
    }

    .water-drop {
        display: inline-block;
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #74b9ff, #0984e3);
        border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
        margin-bottom: 20px;
        animation: droplet 2s ease-in-out infinite;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        position: relative;
    }

    .water-drop::before {
        content: '📸';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 24px;
    }

    @keyframes droplet {

        0%,
        100% {
            transform: translateY(0) scale(1);
        }

        50% {
            transform: translateY(-5px) scale(1.02);
        }
    }

    .section-container {
        background: rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(15px);
        border-radius: 20px;
        margin: 40px auto;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        animation: slideInUp 0.8s ease-out;
    }

    @keyframes slideInUp {
        from {
            transform: translateY(50px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .section-title {
        background: linear-gradient(90deg, #ffffff, #ffffff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: bold;
        padding: 30px;
        text-align: center;
        position: relative;
        overflow: hidden;
        font-size: 32px letter-spacing: 5px;
        text-transform: uppercase;
    }


    .photo-gallery {
        padding: 20px;
    }

    .gallery-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .institution-selector {
        position: relative;
        min-width: 300px;
    }

    .selector-btn {
        background: linear-gradient(135deg, #0077be, #00a8cc);
        color: white;
        border: none;
        padding: 15px 25px;
        border-radius: 15px;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
        text-align: left;
        position: relative;
        transition: all 0.3s ease;
    }

    .selector-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .selector-btn::after {
        content: '▼';
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        transition: transform 0.3s ease;
    }

    .selector-btn.open::after {
        transform: translateY(-50%) rotate(180deg);
    }

    .dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        max-height: 300px;
        overflow-y: auto;
        z-index: 100;
        display: none;
    }

    .dropdown.show {
        display: block;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dropdown-item {
        padding: 12px 20px;
        cursor: pointer;
        transition: background 0.2s ease;
        border-bottom: 1px solid #f0f0f0;
    }

    .dropdown-item:hover {
        background: #f8f9fa;
    }

    .dropdown-item.active {
        background: #e3f2fd;
        color: #0077be;
        font-weight: 600;
    }

    .gallery-stats {
        background: rgba(0, 119, 190, 0.1);
        padding: 15px 20px;
        border-radius: 15px;
        text-align: center;
        min-width: 200px;
    }

    .photo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .photo-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .photo-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
    }

    .photo-card img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .photo-card:hover img {
        transform: scale(1.05);
    }

    .photo-info {
        padding: 20px;
    }

    .photo-date {
        font-size: 13px;
        color: #666;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .photo-title {
        font-weight: bold;
        color: #2d3748;
        margin-bottom: 10px;
        font-size: 16px;
    }

    .photo-institution {
        font-size: 14px;
        color: #0077be;
        font-weight: 600;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #666;
    }

    .empty-icon {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        animation: modalFadeIn 0.3s ease;
    }

    @keyframes modalFadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .modal-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-width: 95vw;
        max-height: 95vh;
        width: auto;
        height: auto;
        animation: modalZoomIn 0.3s ease;
    }

    @keyframes modalZoomIn {
        from {
            transform: translate(-50%, -50%) scale(0.8);
        }

        to {
            transform: translate(-50%, -50%) scale(1);
        }
    }

    .modal img {
        width: auto;
        height: auto;
        max-width: 95vw;
        max-height: 95vh;
        object-fit: contain;
        border-radius: 10px;
        display: block;
    }

    .close {
        position: absolute;
        top: 20px;
        right: 30px;
        color: white;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
        z-index: 1001;
    }

    .video-section {
        padding: 55px;
    }

    .video-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        height: 600px;
    }

    .main-video {
        background: #000;
        border-radius: 20px;
        overflow: hidden;
    }


    .main-video video {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
        background: #000;
    }

    .video-meta {
        margin-top: 14px;
        color: #fff;
    }


    .video-frame {
        position: relative;
        width: 100%;
    }

    .video-frame::before {
        content: "";
        display: block;
        padding-top: 56.25%;
    }


    .video-info {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.9));
        color: white;
        padding: 40px 25px 25px;
    }

    .video-title {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .video-description {
        opacity: 0.9;
        line-height: 1.5;
        margin-bottom: 14px;
    }

    .video-btn {
        background: linear-gradient(135deg, #0077be, #00a8cc);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 20px;
        font-weight: 300;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .video-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    .playlist {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 25px;
        overflow-y: auto;
    }

    .playlist-title {
        color: #2d3748;
        font-weight: bold;
        margin-bottom: 25px;
        text-align: center;
        font-size: 1.2rem;
    }

    .playlist-item {
        display: flex;
        gap: 15px;
        padding: 15px;
        border-radius: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 12px;
        background: white;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .playlist-item:hover {
        background: #f8f9fa;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .playlist-item.active {
        background: linear-gradient(135deg, rgba(0, 119, 190, 0.1), rgba(0, 168, 204, 0.1));
        border: 2px solid #0077be;
    }

    .playlist-thumbnail {
        width: 90px;
        height: 70px;
        border-radius: 10px;
        object-fit: cover;
        background: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #666;
        font-size: 24px;
    }

    .playlist-info {
        flex: 1;
        color: #2d3748;
    }

    .playlist-item-title {
        font-weight: 600;
        font-size: 15px;
        margin-bottom: 6px;
        line-height: 1.3;
    }

    .playlist-item-desc {
        font-size: 13px;
        opacity: 0.7;
        line-height: 1.4;
    }

    @media (max-width: 768px) {
        .video-container {
            grid-template-columns: 1fr;
            height: auto;
        }

        .main-video {
            height: 300px;
        }

        .playlist {
            height: 300px;
        }

        .gallery-controls {
            flex-direction: column;
            align-items: stretch;
        }

        .institution-selector {
            min-width: 100%;
        }

        .photo-grid {
            grid-template-columns: 1fr;
        }
    }

    .elegant-container {
        width: 100%;
        margin: 20px auto;
        background: linear-gradient(90deg, #4facfe, #00f2fe);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        padding: 20px;
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .titulo {
        color: white;
        font-weight: bold;
        padding: 30px;
        text-align: center;
        position: relative;
        overflow: hidden;
        font-size: 32px;
        letter-spacing: 5px;
        text-transform: uppercase;
    }

    .modal-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 1001;
        width: 48px;
        height: 48px;
        border: none;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(6px);
        color: #fff;
        font-size: 28px;
        line-height: 48px;
        text-align: center;
        cursor: pointer;
        transition: background .2s ease, transform .2s ease;
        user-select: none;
    }

    .modal-nav:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-50%) scale(1.05);
    }

    .modal-prev {
        left: 20px;
    }

    .modal-next {
        right: 20px;
    }

    .modal .disabled {
        opacity: .35;
        pointer-events: none;
    }
</style>

<div class="water-wave">
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
</div>

<div class="water-header">
    <div class="header-content">
        <div class="water-drop"></div>
        <h1 class="text-white font-weight-bold mb-3" style="font-size: 2.5rem;">
            Galería de la Ruta del Agua
        </h1>
        <p class="text-white h4 mb-0">
            Documentando el progreso de nuestras instituciones
        </p>
    </div>
</div>

<div class="elegant-container">
    @php
        $totalImages = 0;
        $institutionsWithImages = [];

        foreach ($imagesByInstitution ?? [] as $institutionName => $images) {
            $imageCount = 0;
            foreach ($images as $image) {
                foreach ([$image->urlImage1, $image->urlImage2, $image->urlImage3] as $url) {
                    if (resolveImgSrc($url)) {
                        $imageCount++;
                    }
                }
            }
            if ($imageCount > 0) {
                $institutionsWithImages[$institutionName] = [
                    'images' => $images,
                    'count' => $imageCount,
                ];
                $totalImages += $imageCount;
            }
        }

    @endphp
    @php
        use Illuminate\Support\Facades\Storage;
        use Illuminate\Support\Str;

        function resolveImgSrc($path)
        {
            if (!filled($path)) {
                return null;
            }
            $path = trim($path);

            if (Str::startsWith($path, ['http://', 'https://', '//'])) {
                return $path;
            }

            if (Str::startsWith($path, 'storage/')) {
                $rel = Str::after($path, 'storage/');
                return Storage::disk('public')->exists($rel) ? asset($path) : null;
            }
            return file_exists(public_path($path)) ? asset($path) : null;
        }
    @endphp


    @if (count($institutionsWithImages) > 0)
        <div class="">
            <div class="">
                <h2 class="titulo">Galería de Mediciones por Institución</h2>
            </div>
            <div class="photo-gallery">
                <div class="gallery-controls">
                    <div class="institution-selector">
                        <button class="selector-btn" onclick="toggleDropdown()">
                            <span id="selectedInstitution">Seleccionar Institución</span>
                        </button>
                        <div class="dropdown" id="institutionDropdown">
                            @foreach ($institutionsWithImages as $institutionName => $data)
                                <div class="dropdown-item"
                                    onclick="selectInstitution('{{ $loop->index }}', '{{ $institutionName }}', {{ $data['count'] }})">
                                    {{ $institutionName }} <small>({{ $data['count'] }} fotos)</small>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="gallery-stats">
                        <div><strong id="currentCount">{{ $totalImages }}</strong> fotos totales</div>
                        <div><small id="currentInstitution">{{ count($institutionsWithImages) }} instituciones</small>
                        </div>
                    </div>
                </div>

                @foreach ($institutionsWithImages as $institutionName => $data)
                    <div class="photo-grid" id="institution-{{ $loop->index }}" style="display:none;">
                        @foreach ($data['images'] as $image)
                            @foreach ([$image->urlImage1, $image->urlImage2, $image->urlImage3] as $u)
                                @php $src = resolveImgSrc($u); @endphp
                                @if ($src)
                                    <div class="photo-card" onclick="openModal('{{ $src }}')">
                                        <img src="{{ $src }}" alt="" loading="lazy"
                                            onerror="this.closest('.photo-card')?.remove();">
                                        <div class="photo-info">
                                            <div class="photo-date">{{ $image->created_at->format('d M Y') }}</div>
                                            <div class="photo-title">Medición de Cloro Residual</div>
                                            <div class="photo-institution">{{ $institutionName }}</div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                @endforeach

            </div>
        </div>
    @else
        <div class="section-container">
            <div class="section-title">
                <h2 class="mb-0">📸 Galería de Mediciones</h2>
            </div>
            <div class="photo-gallery">
                <div class="empty-state">
                    <div class="empty-icon">🏫</div>
                    <h3>No hay imágenes disponibles</h3>
                    <p>Aún no se han subido mediciones con imágenes desde las instituciones.</p>
                </div>
            </div>
        </div>
    @endif

    <div class="section-container">
        <h2 class="titulo">Videos Educativos</h2>
            {{-- <h2 class="titulo">Videos Educativos</h2> --}}
            <div class="video-section">
                @if (isset($videos) && $videos->count() > 0)
                    <div class="video-container">
                        <div>
                            @php
                                $firstVideo = $videos->first();
                                $videoPath = public_path(str_replace(asset(''), '', $firstVideo->route));
                            @endphp

                            <div class="main-video">
                                @if (file_exists($videoPath))
                                    <div class="video-frame">
                                        <video id="mainVideo" controls preload="metadata">
                                            <source src="{{ asset($firstVideo->route) }}" type="video/mp4">
                                            Tu navegador no soporta el elemento video.
                                        </video>
                                    </div>
                                @else
                                    <div class="video-missing">❌ Video no encontrado: {{ $firstVideo->route }}</div>
                                @endif
                            </div>

                            <!-- Meta debajo del video -->
                            <div class="video-meta">
                                <div class="video-title" id="videoTitle">{{ $firstVideo->title }}</div>
                                <div class="video-description" id="videoDescription">{{ $firstVideo->description }}
                                </div>
                                <button class="video-btn" id="videoMoreBtn"
                                    onclick="window.location.href='{{ route('home.content_detail', $firstVideo->id) }}'">
                                    Ver Más Detalles
                                </button>
                            </div>
                        </div>
                        <div class="playlist">
                            <div class="playlist-title">Lista de Reproducción ({{ $videos->count() }} videos)</div>
                            @foreach ($videos as $video)
                                @php $videoExists = file_exists(public_path(str_replace(asset(''), '', $video->route))); @endphp
                                <div class="playlist-item {{ $loop->first ? 'active' : '' }} {{ !$videoExists ? 'video-error' : '' }}"
                                    onclick="playVideo('{{ asset($video->route) }}',
                                    {{ json_encode($video->title) }},
                                    {{ json_encode($video->description) }},
                                    '{{ route('home.content_detail', $video->id) }}',
                                    this,
                                    {{ $videoExists ? 'true' : 'false' }})">
                                    <div class="playlist-thumbnail">{{ $videoExists ? '🎥' : '❌' }}</div>
                                    <div class="playlist-info">
                                        <div class="playlist-item-title">{{ $video->title }}</div>
                                        <div class="playlist-item-desc">{{ Str::limit($video->description, 60) }}</div>
                                        @if (!$videoExists)
                                            <small style="color: red;">Video no encontrado</small>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">🎬</div>
                        <h3>No hay videos disponibles</h3>
                        <p>Próximamente estarán disponibles videos educativos sobre el cuidado del agua.</p>
                    </div>
                @endif
            </div>
    </div>
</div>

<div id="imageModal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <div class="modal-content">
        <img id="modalImage" src="" alt="">
        <button class="modal-nav modal-prev" onclick="prevImage()" aria-label="Anterior">‹</button>
        <button class="modal-nav modal-next" onclick="nextImage()" aria-label="Siguiente">›</button>
    </div>
</div>

<script>
    let selectedIndex = -1;

    function toggleDropdown() {
        const dropdown = document.getElementById('institutionDropdown');
        const btn = document.querySelector('.selector-btn');
        dropdown.classList.toggle('show');
        btn.classList.toggle('open');
    }

    function selectInstitution(index, name, count) {
        document.querySelectorAll('.photo-grid').forEach(grid => {
            grid.style.display = 'none';
        });
        const selectedGrid = document.getElementById('institution-' + index);
        if (selectedGrid) selectedGrid.style.display = 'grid';
        const items = Array.from(document.querySelectorAll('#institutionDropdown .dropdown-item'));
        items.forEach(i => i.classList.remove('active'));
        if (items[index]) items[index].classList.add('active');
        const $sel = document.getElementById('selectedInstitution');
        const $cnt = document.getElementById('currentCount');
        const $cur = document.getElementById('currentInstitution');
        if ($sel) $sel.textContent = name;
        if ($cnt) $cnt.textContent = count;
        if ($cur) $cur.textContent = name;
        selectedIndex = index;
        if (typeof buildGallery === 'function') {
            buildGallery();
        }

        toggleDropdown();
    }
    if (typeof window.openModal !== 'function') {
        window.openModal = function(imageSrc) {
            const img = document.getElementById('modalImage');
            const modal = document.getElementById('imageModal');
            if (img) img.src = imageSrc;
            if (modal) modal.style.display = 'block';
        };
    }

    if (typeof window.closeModal !== 'function') {
        window.closeModal = function() {
            const modal = document.getElementById('imageModal');
            if (modal) modal.style.display = 'none';
        };
    }

    function playVideo(src, title, description, detailUrl, element, exists = true) {
        if (!exists) {
            alert('Este video no está disponible');
            return;
        }

        const mainVideo = document.getElementById('mainVideo');
        const videoTitle = document.getElementById('videoTitle');
        const videoDescription = document.getElementById('videoDescription');
        const videoBtn = document.querySelector('.video-btn');

        const cleanTitle = String(title).replace(/['"]/g, '');
        const cleanDescription = String(description).replace(/['"]/g, '');

        if (mainVideo) {
            mainVideo.src = src;
            mainVideo.load();
            mainVideo.play().catch(() => {});
        }
        if (videoTitle) videoTitle.textContent = cleanTitle;
        if (videoDescription) videoDescription.textContent = cleanDescription;
        if (videoBtn) videoBtn.onclick = () => window.location.href = detailUrl;

        document.querySelectorAll('.playlist-item').forEach(item => item.classList.remove('active'));
        if (element) element.classList.add('active');
    }
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('institutionDropdown');
        const btn = document.querySelector('.selector-btn');
        if (!event.target.closest('.institution-selector')) {
            dropdown.classList.remove('show');
            btn.classList.remove('open');
        }
    });
    window.onclick = function(event) {
        const modal = document.getElementById('imageModal');
        if (event.target === modal) {
            if (typeof closeModal === 'function') closeModal();
        }
    };
    (function init() {
        const items = Array.from(document.querySelectorAll('#institutionDropdown .dropdown-item'));
        if (!items.length) return;
        const first = items[0];
        const txt = first.textContent.trim();
        const name = txt.split('(')[0].trim();
        const m = txt.match(/\((\d+)/);
        const count = m ? parseInt(m[1]) : 0;

        selectInstitution(0, name, count);
    })();
</script>

<script>
    let gallery = [];
    let currentIdx = 0;

    function buildGallery() {
        const grid = document.getElementById('institution-' + selectedIndex);
        if (!grid) {
            gallery = [];
            return;
        }
        const imgs = grid.querySelectorAll('.photo-card img');
        gallery = Array.from(imgs).map(img => img.getAttribute('src')).filter(Boolean);
    }

    function showImage(idx) {
        if (!gallery.length) return;
        currentIdx = (idx + gallery.length) % gallery.length;
        const src = gallery[currentIdx];
        const modalImg = document.getElementById('modalImage');
        modalImg.src = src;
        // document.querySelector('.modal-prev').classList.toggle('disabled', currentIdx === 0);
        // document.querySelector('.modal-next').classList.toggle('disabled', currentIdx === gallery.length - 1);
    }

    function openModal(imageSrc) {
        buildGallery();
        if (!gallery.length) return;

        const idx = gallery.indexOf(imageSrc);
        currentIdx = idx >= 0 ? idx : 0;

        showImage(currentIdx);
        document.getElementById('imageModal').style.display = 'block';
    }


    function closeModal() {
        document.getElementById('imageModal').style.display = 'none';
    }

    function nextImage() {
        showImage(currentIdx + 1);
    }

    function prevImage() {
        showImage(currentIdx - 1);
    }
    document.addEventListener('keydown', (e) => {
        const modalOpen = document.getElementById('imageModal').style.display === 'block';
        if (!modalOpen) return;
        if (e.key === 'ArrowRight') nextImage();
        if (e.key === 'ArrowLeft') prevImage();
        if (e.key === 'Escape') closeModal();
    });
    let touchStartX = null;
    document.getElementById('imageModal').addEventListener('touchstart', e => {
        touchStartX = e.changedTouches[0].clientX;
    }, {
        passive: true
    });
    document.getElementById('imageModal').addEventListener('touchend', e => {
        if (touchStartX === null) return;
        const dx = e.changedTouches[0].clientX - touchStartX;
        if (Math.abs(dx) > 40) {
            dx < 0 ? nextImage() : prevImage();
        }
        touchStartX = null;
    }, {
        passive: true
    });
</script>


@include('home/layout/footer')

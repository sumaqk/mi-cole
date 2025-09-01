@include('home/layout/header')

<style>
    body {
        min-height: 100vh;
        overflow-x: hidden;
    }

    .ruta-header {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        position: relative;
        overflow: hidden;
        min-height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 40px;
    }

    .ruta-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 200%;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1000 100'%3E%3Cpath d='M421.9,6.5c22.6-2.5,51.5,0.4,75.5,5.3c23.6,4.9,70.9,23.5,100.5,35.7c75.8,32.2,133.7,44.5,192.6,49.7c23.6,2.1,48.7,3.5,103.4-2.5c54.7-6,106.2-25.6,106.2-25.6V0H0v30.3c0,0,72,32.6,158.4,30.5c39.2-0.7,92.8-6.7,133-18.6c27.7-8.2,44.6-16.6,69.5-18.8C384.4,20.9,400.4,21.4,421.9,6.5z' fill='rgba(255,255,255,0.1)'/%3E%3C/svg%3E") repeat-x;
        animation: wave 10s linear infinite;
        z-index: 1;
    }

    @keyframes wave {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    .header-content {
        text-align: center;
        z-index: 2;
        position: relative;
    }

    .water-icon {
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

    .water-icon::before {
        content: '🚰';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 28px;
    }

    @keyframes droplet {
        0%, 100% { transform: translateY(0) scale(1); }
        50% { transform: translateY(-5px) scale(1.02); }
    }

    .slider-container {
        background: rgba(255, 255, 255, 0.4);
        backdrop-filter: blur(15px);
        border-radius: 25px;
        margin: 30px auto;
        max-width: 1200px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
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

    .slider-header {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        padding: 25px 30px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .slider-header h2 {
        font-size: 1.8rem;
        font-weight: bold;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        letter-spacing: 1px;
    }

    .slider-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='rgba(255,255,255,0.05)' fill-opacity='1'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.3;
    }

    .slider-content {
        padding: 40px 30px;
    }

    .image-slider {
        position: relative;
        width: 100%;
        height: 500px;
        overflow: hidden;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        background: #f8f9fa;
    }

    .slider-wrapper {
        display: flex;
        transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        height: 100%;
    }

    .slide {
        min-width: 100%;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .slide:hover img {
        transform: scale(1.05);
    }

    .slide-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0,0,0,0.8));
        color: white;
        padding: 30px 25px 20px;
        transform: translateY(100%);
        transition: transform 0.3s ease;
    }

    .slide:hover .slide-overlay {
        transform: translateY(0);
    }

    .slide-title {
        font-size: 1.3rem;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .slide-description {
        opacity: 0.9;
        font-size: 0.95rem;
        line-height: 1.5;
    }

    .slider-controls {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border: none;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
        color: white;
        font-size: 20px;
        font-weight: bold;
    }

    .slider-controls:hover {
        background: rgba(255,255,255,0.4);
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }

    .prev-btn {
        left: 20px;
    }

    .next-btn {
        right: 20px;
    }

    .slider-dots {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 25px;
        padding-bottom: 10px;
    }

    .dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(79, 172, 254, 0.3);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .dot.active {
        background: #4facfe;
        transform: scale(1.2);
        box-shadow: 0 4px 12px rgba(79, 172, 254, 0.4);
    }

    .slider-info {
        text-align: center;
        margin-top: 20px;
        color: #666;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .ruta-header {
            min-height: 200px;
        }

        .slider-container {
            margin: 20px 15px;
        }

        .slider-content {
            padding: 20px 15px;
        }

        .image-slider {
            height: 350px;
        }

        .slider-header h2 {
            font-size: 1.4rem;
        }

        .slider-controls {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }

        .prev-btn {
            left: 10px;
        }

        .next-btn {
            right: 10px;
        }
    }
</style>

<div class="ruta-header">
    <div class="header-content">
        <div class="water-icon"></div>
        <h1 class="text-white font-weight-bold mb-3" style="font-size: 2.5rem;">
            Ruta del Agua Abancay
        </h1>
        <p class="text-white h4 mb-0">
            Conoce el recorrido del agua en nuestra ciudad
        </p>
    </div>
</div>

<!-- Slider para Alumnos -->
<div class="slider-container">
    <div class="slider-header">
        <h2>🎓 Ruta del Agua - Alumnos</h2>
    </div>
    <div class="slider-content">
        <div class="image-slider" id="slider-alumnos">
            <div class="slider-wrapper" id="slider-wrapper-alumnos">
                @php
                    $alumnosImages = [];
                    $imageNumbers = [3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 21, 22, 23, 24, 25];
                    
                    foreach($imageNumbers as $num) {
                        $imagePath = "img/rutas/abancay/rutaaguaalumnos/{$num}.jpg";
                        if(file_exists(public_path($imagePath))) {
                            $alumnosImages[] = $imagePath;
                        }
                    }
                @endphp
                
                @foreach($alumnosImages as $index => $image)
                <div class="slide">
                    <img src="{{ asset($image) }}" alt="Ruta del Agua Alumnos {{ $index + 1 }}" loading="lazy">
                    <div class="slide-overlay">
                        <div class="slide-title">Etapa {{ $index + 1 }} - Estudiantes</div>
                        <div class="slide-description">Los estudiantes aprenden sobre el ciclo del agua y su importancia en nuestra comunidad.</div>
                    </div>
                </div>
                @endforeach
            </div>
            
            @if(count($alumnosImages) > 1)
            <button class="slider-controls prev-btn" onclick="moveSlider('alumnos', -1)">‹</button>
            <button class="slider-controls next-btn" onclick="moveSlider('alumnos', 1)">›</button>
            @endif
        </div>
        
        @if(count($alumnosImages) > 1)
        <div class="slider-dots" id="dots-alumnos">
            @for($i = 0; $i < count($alumnosImages); $i++)
            <span class="dot {{ $i === 0 ? 'active' : '' }}" onclick="goToSlide('alumnos', {{ $i }})"></span>
            @endfor
        </div>
        @endif
        
        <div class="slider-info">
            <strong>{{ count($alumnosImages) }}</strong> imágenes disponibles del recorrido con estudiantes
        </div>
    </div>
</div>

<!-- Slider para Docentes -->
<div class="slider-container">
    <div class="slider-header">
        <h2>👨‍🏫 Ruta del Agua - Docentes</h2>
    </div>
    <div class="slider-content">
        <div class="image-slider" id="slider-docentes">
            <div class="slider-wrapper" id="slider-wrapper-docentes">
                @php
                    $docentesImages = [];
                    for($i = 1; $i <= 23; $i++) {
                        $imagePath = "img/rutas/abancay/rutaaguadocentes/d{$i}.jpg";
                        if(file_exists(public_path($imagePath))) {
                            $docentesImages[] = $imagePath;
                        }
                    }
                @endphp
                
                @foreach($docentesImages as $index => $image)
                <div class="slide">
                    <img src="{{ asset($image) }}" alt="Ruta del Agua Docentes {{ $index + 1 }}" loading="lazy">
                    <div class="slide-overlay">
                        <div class="slide-title">Etapa {{ $index + 1 }} - Docentes</div>
                        <div class="slide-description">Capacitación docente sobre gestión del agua y metodologías de enseñanza ambiental.</div>
                    </div>
                </div>
                @endforeach
            </div>
            
            @if(count($docentesImages) > 1)
            <button class="slider-controls prev-btn" onclick="moveSlider('docentes', -1)">‹</button>
            <button class="slider-controls next-btn" onclick="moveSlider('docentes', 1)">›</button>
            @endif
        </div>
        
        @if(count($docentesImages) > 1)
        <div class="slider-dots" id="dots-docentes">
            @for($i = 0; $i < count($docentesImages); $i++)
            <span class="dot {{ $i === 0 ? 'active' : '' }}" onclick="goToSlide('docentes', {{ $i }})"></span>
            @endfor
        </div>
        @endif
        
        <div class="slider-info">
            <strong>{{ count($docentesImages) }}</strong> imágenes disponibles del recorrido con docentes
        </div>
    </div>
</div>

<script>
    // Estado de los sliders
    const sliders = {
        alumnos: { currentSlide: 0, totalSlides: {{ count($alumnosImages) }} },
        docentes: { currentSlide: 0, totalSlides: {{ count($docentesImages) }} }
    };

    function moveSlider(sliderName, direction) {
        const slider = sliders[sliderName];
        const wrapper = document.getElementById(`slider-wrapper-${sliderName}`);
        
        slider.currentSlide += direction;
        
        if (slider.currentSlide >= slider.totalSlides) {
            slider.currentSlide = 0;
        } else if (slider.currentSlide < 0) {
            slider.currentSlide = slider.totalSlides - 1;
        }
        
        updateSlider(sliderName);
    }

    function goToSlide(sliderName, slideIndex) {
        sliders[sliderName].currentSlide = slideIndex;
        updateSlider(sliderName);
    }

    function updateSlider(sliderName) {
        const slider = sliders[sliderName];
        const wrapper = document.getElementById(`slider-wrapper-${sliderName}`);
        const dots = document.querySelectorAll(`#dots-${sliderName} .dot`);
        
        // Mover slider
        const translateX = -slider.currentSlide * 100;
        wrapper.style.transform = `translateX(${translateX}%)`;
        
        // Actualizar dots
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === slider.currentSlide);
        });
    }

    // Auto-slide cada 5 segundos
    setInterval(() => {
        if (sliders.alumnos.totalSlides > 1) {
            moveSlider('alumnos', 1);
        }
        if (sliders.docentes.totalSlides > 1) {
            moveSlider('docentes', 1);
        }
    }, 5000);

    // Navegación con teclado
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            moveSlider('alumnos', -1);
            moveSlider('docentes', -1);
        } else if (e.key === 'ArrowRight') {
            moveSlider('alumnos', 1);
            moveSlider('docentes', 1);
        }
    });

    // Touch/swipe support
    let touchStartX = 0;
    let touchEndX = 0;

    ['alumnos', 'docentes'].forEach(sliderName => {
        const slider = document.getElementById(`slider-${sliderName}`);
        
        slider.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        });

        slider.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe(sliderName);
        });
    });

    function handleSwipe(sliderName) {
        const swipeThreshold = 50;
        const diff = touchStartX - touchEndX;
        
        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                moveSlider(sliderName, 1); // Swipe left
            } else {
                moveSlider(sliderName, -1); // Swipe right
            }
        }
    }
</script>

@include('home/layout/footer')
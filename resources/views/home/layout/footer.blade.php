<!-- Footer Start -->
<style>
/* Footer Moderno - CSS Integrado */
.footer-modern {
    background: linear-gradient(135deg, #0f4c75 0%, #3282b8 50%, #0f4c75 100%);
    color: white;
    position: relative;
    overflow: hidden;
    margin-top: 3rem;
    padding: 0;
}

.footer-waves {
    position: absolute;
    top: -50px;
    left: 0;
    width: 100%;
    height: 60px;
    z-index: 1;
}

.footer-waves svg {
    width: 100%;
    height: 100%;
}

.wave-1 {
    fill: rgba(255, 255, 255, 0.1);
    animation: waveMove1 8s ease-in-out infinite;
}

.wave-2 {
    fill: rgba(255, 255, 255, 0.05);
    animation: waveMove2 6s ease-in-out infinite reverse;
}

@keyframes waveMove1 {
    0%, 100% { transform: translateX(0px); }
    50% { transform: translateX(-50px); }
}

@keyframes waveMove2 {
    0%, 100% { transform: translateX(0px); }
    50% { transform: translateX(30px); }
}

.footer-content {
    position: relative;
    z-index: 2;
    padding: 4rem 2rem 2rem;
}

.footer-brand {
    margin-bottom: 2rem;
}

.brand-link {
    display: flex;
    align-items: center;
    text-decoration: none;
    transition: all 0.3s ease;
}

.brand-link:hover {
    transform: translateY(-3px);
    text-decoration: none;
}

.brand-icon {
    background: linear-gradient(45deg, #4facfe, #00f2fe);
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    box-shadow: 0 10px 25px rgba(79, 172, 254, 0.3);
}

.brand-icon i {
    font-size: 1.8rem;
    color: white;
}

.brand-text {
    font-size: 2.5rem;
    font-weight: bold;
    color: white;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.footer-subtitle {
    color: #4facfe;
    font-size: 1.3rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

.footer-description {
    line-height: 1.6;
    opacity: 0.9;
    margin-bottom: 2rem;
}

.social-links {
    display: flex;
    gap: 15px;
    margin-top: 2rem;
}

.social-link {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    transition: all 0.3s ease;
    text-decoration: none;
}

.social-link.twitter { background: linear-gradient(45deg, #1da1f2, #0d8bd9); }
.social-link.facebook { background: linear-gradient(45deg, #4267b2, #365899); }
.social-link.linkedin { background: linear-gradient(45deg, #0077b5, #005885); }
.social-link.instagram { background: linear-gradient(45deg, #e4405f, #c13584); }

.social-link:hover {
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 15px 30px rgba(0,0,0,0.3);
    text-decoration: none;
    color: white;
}

.footer-title {
    color: #4facfe;
    font-size: 1.4rem;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
}

.contact-icon {
    background: rgba(79, 172, 254, 0.2);
    width: 45px;
    height: 45px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #4facfe;
    flex-shrink: 0;
}

.contact-details h5 {
    color: #4facfe;
    margin-bottom: 5px;
    font-size: 1rem;
}

.contact-details p {
    margin: 0;
    opacity: 0.9;
    font-size: 0.9rem;
}

.footer-links {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.footer-link {
    display: flex;
    align-items: center;
    gap: 12px;
    color: white;
    text-decoration: none;
    padding: 10px 15px;
    border-radius: 8px;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.05);
}

.footer-link:hover {
    background: rgba(79, 172, 254, 0.2);
    transform: translateX(10px);
    color: #4facfe;
    text-decoration: none;
}

.footer-link i {
    color: #4facfe;
    width: 20px;
}

.footer-bottom {
    background: rgba(0, 0, 0, 0.2);
    padding: 2rem 0;
    border-top: 1px solid rgba(79, 172, 254, 0.3);
}

.copyright-text {
    margin: 0;
    opacity: 0.8;
    text-align: center;
}

.highlight {
    color: #4facfe;
    font-weight: bold;
}

.back-to-top-modern {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 55px;
    height: 55px;
    background: linear-gradient(45deg, #4facfe, #00f2fe);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 10px 25px rgba(79, 172, 254, 0.4);
    z-index: 1000;
    opacity: 0;
    transform: translateY(20px);
    text-decoration: none;
}

.back-to-top-modern.show {
    opacity: 1;
    transform: translateY(0);
}

.back-to-top-modern:hover {
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 15px 35px rgba(79, 172, 254, 0.6);
    text-decoration: none;
    color: white;
}

@media (max-width: 768px) {
    .brand-text { font-size: 2rem; }
    .social-links { justify-content: center; }
    .footer-content { padding: 3rem 1rem 2rem; }
}
</style>

<div class="footer-modern">
    <div class="footer-waves">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0V7.23C0,65.52,268.63,112.77,600,112.77S1200,65.52,1200,7.23V0Z" class="wave-1"></path>
            <path d="M0,0V15.81C0,72.92,259.74,119.44,580,119.44S1160,72.92,1160,15.81V0Z" class="wave-2"></path>
        </svg>
    </div>

    <div class="container-fluid footer-content">
        <div class="row">
            <div class="col-lg-5 col-md-6 mb-5">
                <div class="footer-brand">
                    <a href="{{ route('home.index') }}" class="brand-link">
                        <div class="brand-icon">
                            <i class="fas fa-water"></i>
                        </div>
                        <span class="brand-text">MiCole</span>
                    </a>
                </div>
                
                <h4 class="footer-subtitle">Sistema Regional de Registro de Cloro</h4>
                <p class="footer-description">
                    Este es un espacio donde los estudiantes pueden aprender a medir el cloro en el agua de sus escuelas.
                    Con este sistema, podrás hacer tus propias verificaciones y descubrir información divertida y útil sobre el agua.
                    ¡Conviértete en un experto y cuida de tu entorno mientras te diviertes!
                </p>
                
                <div class="social-links">
                    <a href="#" class="social-link twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-link facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-link linkedin">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="social-link instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-5">
                <h3 class="footer-title">
                    <i class="fas fa-map-marker-alt"></i>
                    Ubícanos
                </h3>
                
                <div class="contact-info">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h5>Dirección</h5>
                            <p>Jr. Puno N° 107, Abancay – Apurímac</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <h5>Correo Electrónico</h5>
                            <p>sumaqkawsanapaqapurimac@gmail.com</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h5>Teléfono</h5>
                            <p>+51 83 321022</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-12 mb-5">
                <h3 class="footer-title">
                    <i class="fas fa-link"></i>
                    Navegación
                </h3>
                
                <div class="footer-links">
                    <a href="{{ route('home.index') }}" class="footer-link">
                        <i class="fas fa-home"></i>
                        <span>Inicio</span>
                    </a>
                    <a href="{{ route('home.about') }}" class="footer-link">
                        <i class="fas fa-info-circle"></i>
                        <span>Acerca de Nosotros</span>
                    </a>
                    <a href="{{ route('home.content') }}" class="footer-link">
                        <i class="fas fa-book"></i>
                        <span>Contenido</span>
                    </a>
                    <a href="{{ route('home.gallery') }}" class="footer-link">
                        <i class="fas fa-images"></i>
                        <span>Galería</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container-fluid">
            <p class="copyright-text">
                &copy; 2025 <span class="highlight">Gobierno Regional de Apurímac</span>. 
                Todos los derechos reservados.
            </p>
        </div>
    </div>
</div>

<a href="#" class="back-to-top-modern" id="backToTop">
    <i class="fas fa-chevron-up"></i>
</a>

<script>
// Back to Top funcional integrado
window.addEventListener('scroll', function() {
    const backToTop = document.getElementById('backToTop');
    if (window.pageYOffset > 300) {
        backToTop.classList.add('show');
    } else {
        backToTop.classList.remove('show');
    }
});

document.getElementById('backToTop').addEventListener('click', function(e) {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
});
</script>
<!-- Footer End -->

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>

<script src="{{ asset('home/lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('home/lib/owlcarousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('home/lib/isotope/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('home/lib/lightbox/js/lightbox.min.js') }}"></script>

<script src="{{ asset('home/mail/jqBootstrapValidation.min.js') }}"></script>
<script src="{{ asset('home/mail/contact.js') }}"></script>
<script src="{{ asset('home/js/main.js') }}"></script>
</body>
</html>
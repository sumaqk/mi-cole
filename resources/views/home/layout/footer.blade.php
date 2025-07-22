   <!-- Footer Start -->
   <div class="container-fluid bg-secondary text-white mt-5 py-5 px-sm-3 px-md-5">
       <div class="row pt-5">
           <div class="col-lg-6 col-md-6 mb-5">
               <a href="{{ route('home.index') }}" class="navbar-brand font-weight-bold text-primary m-0 mb-4 p-0"
                   style="font-size: 40px; line-height: 40px;">
                   <i class="fas fa-water"></i>
                   <span class="text-white">MiCole</span>
               </a>
               <h4 style="color: white">Sistema Regional de Registro de Cloro</h4>
               <p>Este es un espacio donde los estudiantes pueden aprender a medir el cloro en el agua de sus escuelas.
                   Con este sistema,
                   podrás hacer tus propias verificaciones y descubrir información divertida y útil sobre el agua.
                   ¡Conviértete en un experto y cuida de tu entorno
                   mientras te diviertes!</p>
               <div class="d-flex justify-content-start mt-4">
                   <a class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
                       style="width: 38px; height: 38px;" href="#"><i class="fab fa-twitter"></i></a>
                   <a class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
                       style="width: 38px; height: 38px;" href="#"><i class="fab fa-facebook-f"></i></a>
                   <a class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
                       style="width: 38px; height: 38px;" href="#"><i class="fab fa-linkedin-in"></i></a>
                   <a class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
                       style="width: 38px; height: 38px;" href="#"><i class="fab fa-instagram"></i></a>
               </div>
           </div>
           <div class="col-lg-3 col-md-6 mb-5">
               <h3 class="text-primary mb-4">Ubícanos</h3>
               <div class="d-flex">
                   <h4 class="fa fa-map-marker-alt text-primary"></h4>
                   <div class="pl-3">
                       <h5 class="text-white">Direccíon</h5>
                       <p>Jr. Puno N° 107, Abancay – Apurimac</p>
                   </div>
               </div>
               <div class="d-flex">
                   <h4 class="fa fa-envelope text-primary"></h4>
                   <div class="pl-3">
                       <h5 class="text-white">Correo Electronico</h5>
                       <p>info@example.com</p>
                   </div>
               </div>
               <div class="d-flex">
                   <h4 class="fa fa-phone-alt text-primary"></h4>
                   <div class="pl-3">
                       <h5 class="text-white">Telefono</h5>
                       <p>+012 345 67890</p>
                   </div>
               </div>
           </div>
           <div class="col-lg-3 col-md-6 mb-5">
               <h3 class="text-primary mb-4">Links</h3>
               <div class="d-flex flex-column justify-content-start">
                   <a class="text-white mb-2" href="{{ route('home.index') }}"><i
                           class="fa fa-angle-right mr-2"></i>Inicio</a>
                   <a class="text-white mb-2" href="{{ route('home.about') }}"><i
                           class="fa fa-angle-right mr-2"></i>Acerca de Nosotros</a>
                   <a class="text-white mb-2" href="{{ route('home.content') }}"><i
                           class="fa fa-angle-right mr-2"></i>Contenido</a>
                   <a class="text-white" href="{{ route('home.gallery') }}"><i
                           class="fa fa-angle-right mr-2"></i>Galeria</a>
               </div>
           </div>
       </div>
       <div class="container-fluid pt-5" style="border-top: 1px solid rgba(23, 162, 184, .2);;">
           <p class="m-0 text-center text-white">
               &copy; <a class="text-primary font-weight-bold" href="#">Gobierno Regional de Apurímac 2024</a>.
               Todos los derechos reservados. Designed
               by
               <a class="text-primary font-weight-bold" href="https://www.linkedin.com/in/anthony-meza-bautista-48801a323" target="_blank">Desarrollo Social - AMB</a>
           </p>
       </div>
   </div>
   <!-- Footer End -->


   <!-- Back to Top -->
   <a href="#" class="btn btn-primary p-3 back-to-top"><i class="fa fa-angle-double-up"></i></a>


   <!-- JavaScript Libraries -->
   <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>

   <script src="{{ asset('home/lib/easing/easing.min.js') }}"></script>
   <script src="{{ asset('home/lib/owlcarousel/owl.carousel.min.js') }}"></script>
   <script src="{{ asset('home/lib/isotope/isotope.pkgd.min.js') }}"></script>
   <script src="{{ asset('home/lib/lightbox/js/lightbox.min.js') }}"></script>

   <!-- Contact Javascript File -->
   <script src="{{ asset('home/mail/jqBootstrapValidation.min.js') }}"></script>
   <script src="{{ asset('home/mail/contact.js') }}"></script>

   <!-- Template Javascript -->
   <script src="{{ asset('home/js/main.js') }}"></script>
   </body>

   </html>

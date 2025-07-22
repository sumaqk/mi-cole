@include('home/layout/header')
<!-- Header Start -->
<div class="container-fluid bg-primary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h3 class="display-3 font-weight-bold text-white">{{ $content->title }}</h3>
        <div class="d-inline-flex text-white">
            <p class="m-0"><a class="text-white" href="">Home</a></p>
            <p class="m-0 px-2">/</p>
            <p class="m-0">Contenido</p>
        </div>
    </div>
</div>
<!-- Header End -->


<!-- Class Start -->
<div class="container-fluid">
    <!-- About Start -->
    <div class="container-fluid">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="mb-5">                       
                        <video id="miVideo" class="img-fluid rounded w-100 mb-4"
                            src="{{ asset( $video->route ) }}"
                            style="box-shadow: 0 30px 60px rgb(0, 0, 0);" controls></video>

                        <div class="text-center pb-2">
                            <p class="section-title px-5"><span class="px-2">Más</span></p>
                            <h2 class="mb-4">Información</h2>
                        </div>

                        <div id="pdfViewer" class="rounded w-100 mb-4"
                            style="height: 800px; overflow-y: auto; box-shadow: 0 30px 60px rgb(0, 0, 0);">
                        </div>
                        <div>
                            <a href="{{ asset($content->route) }}"
                                class="btn btn-primary py-2 px-4" download="{{$content->title}}.pdf">
                                Descargar PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- About End -->
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Esperar a que el video esté cargado
        const video = document.getElementById('miVideo');
        video.addEventListener('loadedmetadata', function() {
            this.currentTime = 5; // Establecer el tiempo inicial en 5 segundos
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
<script>
    const pdfPath = '{{ asset($content->route) }}';

    // Configuración inicial de PDF.js
    const pdfjsLib = window['pdfjs-dist/build/pdf'];

    // Contenedor donde se mostrarán todas las páginas del PDF
    const pdfViewer = document.getElementById('pdfViewer');

    // Función para renderizar todas las páginas del PDF
    function renderPDF(pdfDoc) {
        pdfViewer.innerHTML = ''; // Limpiar el contenedor antes de renderizar de nuevo

        // Obtener el ancho del contenedor
        const containerWidth = pdfViewer.clientWidth;

        // Recorrer todas las páginas del PDF
        for (let pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
            pdfDoc.getPage(pageNum).then(function(page) {
                // Calcular la escala con base en el ancho del contenedor
                const viewport = page.getViewport({
                    scale: 1
                });
                const scale = containerWidth / viewport.width; // Ajustar la escala al ancho del contenedor
                const scaledViewport = page.getViewport({
                    scale: scale
                });

                // Crear un canvas para cada página
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.height = scaledViewport.height;
                canvas.width = scaledViewport.width;

                // Añadir el canvas al contenedor
                pdfViewer.appendChild(canvas);

                // Renderizar la página en el canvas
                const renderContext = {
                    canvasContext: context,
                    viewport: scaledViewport
                };
                page.render(renderContext);
            });
        }
    }

    // Cargar el documento PDF y renderizar
    pdfjsLib.getDocument(pdfPath).promise.then(function(pdfDoc) {
        renderPDF(pdfDoc);

        // Volver a renderizar el PDF cuando se redimensione la pantalla
        window.addEventListener('resize', function() {
            renderPDF(pdfDoc);
        });
    });
</script>

@include('home/layout/footer')

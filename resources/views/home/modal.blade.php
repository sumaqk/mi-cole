<div id="newContentModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">¡Nuevo Contenido!</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ $modal->content }}</p>
                <br>
                <div class="card-container">
                    <div class="card">
                        <a href="{{ asset('home/material agua/ANEXOS/Roger y la Magia del Agua.pdf') }}" target="_blank">
                            <div class="badge badge-success">Nuevo</div>
                            <div class="badge badge-info">Cuento</div>
                            <img src="{{ asset('home/material agua/ANEXOS/rojer.png') }}" class="card-img-top" alt="..." style="height: 300px; object-fit: cover;">
                            <div class="card-body">
                                <p class="card-text">Roger y la magia del agua.</p>
                            </div>
                        </a>
                    </div>
                    <div class="card">
                        <a href="{{ asset('home/material agua/ANEXOS/Mi Cole Con Agua Segura.pdf') }}" target="_blank">
                            <div class="badge badge-success">Nuevo</div>
                            <div class="badge badge-warning">Estrategia</div>
                            <img src="{{ asset('home/material agua/ANEXOS/micole.png') }}" class="card-img-top" alt="..." style="height: 300px; object-fit: cover;">
                            <div class="card-body">
                                <p class="card-text">Mi cole con Agua Segura.</p>
                            </div>
                        </a>
                    </div>
                    <div class="card">
                        <a href="{{ asset('home/material agua/ANEXOS/Los Guardianes del Agua.pdf') }}" target="_blank">
                            <div class="badge badge-success">Nuevo</div>
                            <div class="badge badge-info">Cuento</div>
                            <img src="{{ asset('home/material agua/ANEXOS/guardianes.png') }}" class="card-img-top" alt="..." style="height: 300px; object-fit: cover;">
                            <div class="card-body">
                                <p class="card-text">Los Guardianes del Agua.</p>
                            </div>
                        </a>
                    </div>
                </div>  
            </div>
            <div class="modal-footer">                
                <a href="#materiales" type="button" class="btn btn-primary btn-lg btn-block" id="navigateButton">Click aqui para ver todo el contenido</a>
            </div>
        </div>
    </div>
</div>

<style>
    .modal .modal-body {
        background: linear-gradient(#ffffff, #31adff);        
    }

    .modal .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .modal .card {
        width: calc(33.333% - 10px);
        /* 3 cards per row with some spacing */
        margin-bottom: 20px;
        /* Espaciado entre filas */
        overflow: hidden;
        /* Para evitar que la imagen se desborde */
        position: relative;
        /* Necesario para posicionar el badge */
        transition: transform 0.3s;
        /* Transición suave */
    }

    .modal .card-text {
        color: rgb(48, 48, 48);
        font-weight: bold;
        text-align: center;
    }

    .modal .card:hover {
        transform: scale(1.05);
        /* Aumenta el tamaño al pasar el cursor */
    }

    .modal .card img {
        height: 300px;
        object-fit: cover;
        /* Asegura que la imagen se ajuste correctamente */
    }

    .modal .badge {
        position: absolute;
        /* Posiciona el badge */
        top: 10px;
        /* Ajusta la posición desde la parte superior */
        z-index: 1;
        /* Asegura que el badge esté por encima de otros elementos */        
    }

    .modal .badge-info, .modal .badge-warning {
        right: 10px;
        /* Ajusta la posición desde la derecha para el segundo badge */
        top: 40px;
        /* Ajusta la posición desde la parte superior para el segundo badge */
    }

    .modal .badge-success {
        right: 10px;
        /* Ajusta la posición desde la derecha para el primer badge */
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar el modal al cargar la página
        $('#newContentModal').modal('show');

        // Agregar el evento al botón de navegación
        document.getElementById('navigateButton').addEventListener('click', function(event) {
            event.preventDefault(); // Evita el comportamiento por defecto del enlace

            // Navegar a la sección
            const section = document.getElementById('materiales');
            section.scrollIntoView({ behavior: 'smooth' }); // Desplazamiento suave a la sección

            // Cerrar el modal usando Bootstrap
            $('#newContentModal').modal('hide'); // Cierra el modal
        });
    });
</script>

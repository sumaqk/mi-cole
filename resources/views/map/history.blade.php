@extends('template.layout')

@section('title', 'Historial de Mapas Capturados')

@section('cssSection')
    <style>
        .screenshot-card {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 15px;
            background: #fff;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .04);
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }
        
        .screenshot-card:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-color: #007bff;
        }
        
        .screenshot-preview {
            width: 200px;
            height: 120px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
            cursor: pointer;
        }
        
        .auto-badge {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
        }
        
        .manual-badge {
            background: linear-gradient(45deg, #007bff, #6610f2);
            color: white;
        }
        
        .modal-img {
            width: 100% !important;
            height: auto !important;
            max-width: none !important;
            display: block !important;
            margin: 0 auto !important;
            border-radius: 5px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        
        .modal-body {
            padding: 15px !important;
        }
    </style>
@endsection

@section('generalBody')
    <div class="nav-tabs-custom">
        <div class="tab-content">
            
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-sm-12">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h3 style="margin: 0; color: #495057;">
                                <i class="fa fa-history"></i> Historial de Mapas Capturados
                            </h3>
                            <p style="margin: 5px 0 0 0; color: #6c757d;">
                                Registro de todas las capturas de mapas realizadas
                            </p>
                        </div>
                        <div>
                            <a href="{{ route('index.admin') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Volver al Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @if($screenshots->isEmpty())
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alert alert-info text-center" style="padding: 40px;">
                            <i class="fa fa-camera" style="font-size: 48px; color: #17a2b8; margin-bottom: 20px;"></i>
                            <h4>No hay capturas de mapas registradas</h4>
                            <p>Aún no se han realizado capturas de mapas. Ve al dashboard y usa el botón "Capturar Mapa" para crear la primera captura.</p>
                            <a href="{{ route('index.admin') }}" class="btn btn-info">
                                <i class="fa fa-camera"></i> Ir a Capturar Mapa
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    @foreach($screenshots as $screenshot)
                        <div class="col-md-6 col-lg-4">
                            <div class="screenshot-card">
                                <div class="text-center" style="margin-bottom: 15px;">
                                    <img src="{{ asset($screenshot->filepath) }}" 
                                         alt="Mapa {{ $screenshot->month_name }} {{ $screenshot->year }}"
                                         class="screenshot-preview"
                                         data-toggle="modal" 
                                         data-target="#imageModal{{ $screenshot->id }}"
                                         title="Clic para ver en tamaño completo">
                                </div>
                                
                                <div style="text-align: center; margin-bottom: 10px;">
                                    <span class="badge {{ $screenshot->is_automatic ? 'auto-badge' : 'manual-badge' }}"
                                          style="padding: 5px 10px; font-size: 11px; border-radius: 12px;">
                                        @if($screenshot->is_automatic)
                                            <i class="fa fa-clock-o"></i> AUTOMÁTICA
                                        @else
                                            <i class="fa fa-user"></i> MANUAL
                                        @endif
                                    </span>
                                </div>
                                
                                <div style="text-align: center;">
                                    <h5 style="margin: 0 0 5px 0; color: #495057;">
                                        {{ $screenshot->month_name }} {{ $screenshot->year }}
                                    </h5>
                                    <p style="margin: 0 0 10px 0; color: #6c757d; font-size: 13px;">
                                        <i class="fa fa-calendar"></i> 
                                        {{ $screenshot->capture_date->format('d/m/Y') }}
                                    </p>
                                    @if($screenshot->description)
                                        <p style="margin: 0 0 15px 0; color: #6c757d; font-size: 12px;">
                                            {{ $screenshot->description }}
                                        </p>
                                    @endif
                                </div>
                                
                                <div style="text-align: center;">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-info" 
                                                data-toggle="modal" 
                                                data-target="#imageModal{{ $screenshot->id }}"
                                                title="Ver imagen completa">
                                            <i class="fa fa-eye"></i> Ver
                                        </button>
                                        <a href="{{ asset($screenshot->filepath) }}" 
                                           download="{{ $screenshot->filename }}"
                                           class="btn btn-sm btn-success"
                                           title="Descargar imagen">
                                            <i class="fa fa-download"></i> Descargar
                                        </a>
                                        <button class="btn btn-sm btn-danger" 
                                                data-toggle="modal" 
                                                data-target="#deleteModal{{ $screenshot->id }}"
                                                title="Eliminar mapa">
                                            <i class="fa fa-trash"></i> Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal para ver imagen completa -->
                        <div class="modal fade" id="imageModal{{ $screenshot->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">
                                            <i class="fa fa-map-marker"></i>
                                            Mapa de {{ $screenshot->month_name }} {{ $screenshot->year }}
                                        </h4>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-center" style="padding: 15px;">
                                        <img src="{{ asset($screenshot->filepath) }}" 
                                             alt="Mapa {{ $screenshot->month_name }} {{ $screenshot->year }}"
                                             class="modal-img"
                                             style="width: 100% !important; height: auto !important; display: block !important; margin: 0 auto !important; max-width: none !important;">
                                    </div>
                                    <div class="modal-footer">
                                        <div style="text-align: left; flex: 1;">
                                            <small class="text-muted">
                                                <strong>Capturado:</strong> {{ $screenshot->capture_date->format('d/m/Y H:i') }}<br>
                                                <strong>Tipo:</strong> {{ $screenshot->is_automatic ? 'Automática' : 'Manual' }}
                                            </small>
                                        </div>
                                        <a href="{{ asset($screenshot->filepath) }}" 
                                           download="{{ $screenshot->filename }}"
                                           class="btn btn-success">
                                            <i class="fa fa-download"></i> Descargar Imagen
                                        </a>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            Cerrar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal para confirmar eliminación -->
                        <div class="modal fade" id="deleteModal{{ $screenshot->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">
                                            <i class="fa fa-warning text-danger"></i>
                                            Confirmar Eliminación
                                        </h4>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Estás seguro de que quieres eliminar esta captura de mapa?</p>
                                        <div class="alert alert-warning">
                                            <strong>Mapa:</strong> {{ $screenshot->month_name }} {{ $screenshot->year }}<br>
                                            <strong>Capturado:</strong> {{ $screenshot->capture_date->format('d/m/Y H:i') }}<br>
                                            <strong>Tipo:</strong> {{ $screenshot->is_automatic ? 'Automática' : 'Manual' }}
                                        </div>
                                        <p class="text-danger">
                                            <i class="fa fa-exclamation-triangle"></i>
                                            <strong>Esta acción no se puede deshacer. La imagen será eliminada permanentemente.</strong>
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            Cancelar
                                        </button>
                                        <button type="button" 
                                                class="btn btn-danger" 
                                                onclick="deleteScreenshot({{ $screenshot->id }})">
                                            <i class="fa fa-trash"></i> Sí, Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Paginación -->
                @if($screenshots->hasPages())
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="text-center">
                                {{ $screenshots->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            
        </div>
    </div>
@endsection

@section('jsSection')
    <script>
        $(document).ready(function() {
            // Mejorar la experiencia de hover en las tarjetas
            $('.screenshot-card').hover(
                function() {
                    $(this).find('.screenshot-preview').css('transform', 'scale(1.02)');
                },
                function() {
                    $(this).find('.screenshot-preview').css('transform', 'scale(1)');
                }
            );
            
            // Transiciones suaves para las imágenes
            $('.screenshot-preview').css({
                'transition': 'all 0.3s ease',
                'transform-origin': 'center'
            });
        });
        
        // Función para eliminar captura de mapa
        function deleteScreenshot(screenshotId) {
            const deleteBtn = $(`#deleteModal${screenshotId} .btn-danger`);
            const originalText = deleteBtn.html();
            
            // Cambiar botón a estado de carga
            deleteBtn.html('<i class="fa fa-spinner fa-spin"></i> Eliminando...').prop('disabled', true);
            
            // Enviar petición DELETE al servidor
            fetch(`{{ url('map/delete') }}/${screenshotId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cerrar modal
                    $(`#deleteModal${screenshotId}`).modal('hide');
                    
                    // Mostrar mensaje de éxito
                    alert('✅ ' + data.message);
                    
                    // Recargar página para actualizar la lista
                    location.reload();
                } else {
                    alert('❌ Error: ' + data.message);
                    deleteBtn.html(originalText).prop('disabled', false);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Error al eliminar la captura');
                deleteBtn.html(originalText).prop('disabled', false);
            });
        }
    </script>
@endsection
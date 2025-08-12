@extends('template.layout')

@section('title', 'Nuevo Contenido')

@section('generalBody')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Nuevo Contenido</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('index/indexadmin')}}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{url('contenidoweb/contenido')}}">Contenido</a></li>
                    <li class="breadcrumb-item active">Nuevo</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa fa-plus"></i> Crear Contenido
                        </h3>
                    </div>

                    <form id="contentForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Título *</label>
                                        <input type="text" name="title" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Resumen/Extracto</label>
                                        <textarea name="excerpt" class="form-control" rows="3"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Contenido *</label>
                                        <textarea name="content" class="form-control" rows="8" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Archivo de Contenido (PDF, MP3, WAV, DOC)</label>
                                        <input type="file" name="content_file" id="contentFile" class="form-control" accept=".pdf,.mp3,.wav,.doc,.docx,.txt" onchange="showFileInfo(this)">
                                        <small class="text-muted">Máximo 50MB - Formatos: PDF, MP3, WAV, DOC, DOCX, TXT</small>
                                        <div id="fileInfo" class="mt-2" style="display: none;">
                                            <div class="alert alert-info">
                                                <i class="fa fa-file"></i>
                                                <span id="fileName"></span>
                                                <span id="fileSize" class="badge badge-secondary ml-2"></span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Imagen destacada --}}
                                    <div class="form-group">
                                        <label>Imagen Destacada</label>
                                        <input type="file" name="featured_image" id="featuredImage" class="form-control" accept="image/*" onchange="previewImage(this)">
                                        <small class="text-muted">Formatos: JPG, PNG, GIF - Máx. 5MB</small>
                                        <div id="imagePreview" class="mt-2" style="display: none;">
                                            <img src="" alt="Vista previa" class="img-thumbnail" style="max-width: 200px;">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Tags (separados por comas)</label>
                                        <input type="text" name="tags" class="form-control" placeholder="agua, educación, tutorial">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Categoría</label>
                                        <select name="category" class="form-control">
                                            <option value="">Seleccionar</option>
                                            <option value="Canciones">Canciones</option>
                                            <option value="Cuentos y Relatos">Cuentos y Relatos</option>
                                            <option value="Artículos Educativos">Artículos Educativos</option>
                                            <option value="Guías y Manuales">Guías y Manuales</option>
                                            <option value="Infografías y Carteles">Infografías y Carteles</option>
                                            <option value="Juegos y Actividades">Juegos y Actividades</option>
                                            <option value="Experimentos Caseros">Experimentos Caseros</option>
                                            <option value="Noticias">Noticias</option>
                                            <option value="Importancia del Agua">Importancia del Agua</option>
                                            <option value="El Agua para Consumo Humano">El Agua para Consumo Humano</option>
                                            <option value="Otros Usos del Agua">Otros Usos del Agua</option>
                                            <option value="Garantizando la Calidad del Agua">Garantizando la Calidad del Agua</option>
                                            <option value="Tensiones en Torno al Agua">Tensiones en Torno al Agua</option>
                                            <option value="El Uso Responsable del Agua">El Uso Responsable del Agua</option>
                                            <option value="Fascículos 1">Fascículos 1</option>
                                            <option value="Fascículos 2">Fascículos 2</option>
                                            <option value="Fascículos 3">Fascículos 3</option>
                                            <option value="Fascículos 4">Fascículos 4</option>
                                            <option value="Fascículos 5">Fascículos 5</option>
                                            <option value="Fascículos 6">Fascículos 6</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Subcategoría</label>
                                        <input type="text" name="subcategory" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Fecha de Publicación</label>
                                        <input type="datetime-local" name="published_at" class="form-control" value="{{date('Y-m-d\TH:i')}}">
                                    </div>

                                    <div class="form-group">
                                        <label>Orden</label>
                                        <input type="number" name="sort_order" class="form-control" value="0">
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="status" class="custom-control-input" id="status" checked>
                                            <label class="custom-control-label" for="status">Publicado</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="is_featured" class="custom-control-input" id="featured">
                                            <label class="custom-control-label" for="featured">Contenido Destacado</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fa fa-save"></i> Guardar Contenido
                            </button>
                            <a href="{{url('contenidoweb/contenido')}}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="uploadModal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Cargando...</span>
                </div>
                <h5 class="mt-3">Subiendo archivo...</h5>
                <p>Por favor espera mientras se procesa tu archivo</p>
                <div class="progress mt-3">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('jsSection')
<script>
function showFileInfo(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileSize = (file.size / 1024 / 1024).toFixed(2);
        
        document.getElementById('fileName').textContent = file.name;
        document.getElementById('fileSize').textContent = fileSize + ' MB';
        document.getElementById('fileInfo').style.display = 'block';
    }
}

function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.querySelector('#imagePreview img').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

document.getElementById('contentForm').addEventListener('submit', function(e) {
    const fileInput = document.getElementById('contentFile');
    
    if (fileInput.files && fileInput.files[0]) {
        $('#uploadModal').modal('show');
        
        let progress = 0;
        const progressBar = document.querySelector('.progress-bar');
        
        const interval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress > 90) progress = 90;
            progressBar.style.width = progress + '%';
        }, 200);
        
        setTimeout(() => {
            clearInterval(interval);
            progressBar.style.width = '100%';
        }, 3000);
    }
});
</script>
@endsection

@extends('template.layout')

@section('title', 'Nuevo Video')

@section('generalBody')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Nuevo Video</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('index/indexadmin')}}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{url('contenidoweb/videos')}}">Videos</a></li>
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
                            <i class="fa fa-plus"></i> Agregar Video
                        </h3>
                    </div>

                    <form id="videoForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Título *</label>
                                        <input type="text" name="title" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Descripción</label>
                                        <textarea name="description" class="form-control" rows="3"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Archivo de Video</label>
                                        <input type="file" name="video_file" id="videoFile" class="form-control" accept="video/*" onchange="showVideoInfo(this)">
                                        <small class="text-muted">Máximo 500MB - Formatos: MP4, AVI, MOV, WMV, WEBM</small>
                                        <div id="videoInfo" class="mt-2" style="display: none;">
                                            <div class="alert alert-info">
                                                <i class="fa fa-video"></i>
                                                <span id="videoName"></span>
                                                <span id="videoSize" class="badge badge-secondary ml-2"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>URL de YouTube (Alternativa)</label>
                                        <input type="url" name="youtube_url" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
                                        <small class="text-muted">Si pones YouTube, no necesitas subir archivo</small>
                                    </div>

                                    <div class="form-group">
                                        <label>Imagen Thumbnail</label>
                                        <input type="file" name="thumbnail" class="form-control" accept="image/*">
                                        <small class="text-muted">Imagen de vista previa (Opcional)</small>
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
                                        <label>Orden</label>
                                        <input type="number" name="sort_order" class="form-control" value="0">
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="status" class="custom-control-input" id="status" checked>
                                            <label class="custom-control-label" for="status">Activo</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="submitVideoBtn">
                                <i class="fa fa-save"></i> Guardar Video
                            </button>
                            <a href="{{url('contenidoweb/videos')}}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="uploadVideoModal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Cargando...</span>
                </div>
                <h5 class="mt-3">Subiendo video...</h5>
                <p>Por favor espera mientras se procesa tu video</p>
                <div class="progress mt-3">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                </div>
                <p class="text-muted mt-2">Los videos grandes pueden tardar varios minutos</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('jsSection')
<script>
function showVideoInfo(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileSize = (file.size / 1024 / 1024).toFixed(2);
        
        document.getElementById('videoName').textContent = file.name;
        document.getElementById('videoSize').textContent = fileSize + ' MB';
        document.getElementById('videoInfo').style.display = 'block';
        
        if (fileSize > 100) {
            document.getElementById('videoSize').className = 'badge badge-warning ml-2';
        } else {
            document.getElementById('videoSize').className = 'badge badge-success ml-2';
        }
    }
}

document.getElementById('videoForm').addEventListener('submit', function(e) {
    const fileInput = document.getElementById('videoFile');
    
    if (fileInput.files && fileInput.files[0]) {
        $('#uploadVideoModal').modal('show');
        
        let progress = 0;
        const progressBar = document.querySelector('#uploadVideoModal .progress-bar');
        
        const interval = setInterval(() => {
            progress += Math.random() * 10;
            if (progress > 85) progress = 85;
            progressBar.style.width = progress + '%';
        }, 500);
        
        setTimeout(() => {
            clearInterval(interval);
            progressBar.style.width = '100%';
        }, 5000);
    }
});
</script>
@endsection
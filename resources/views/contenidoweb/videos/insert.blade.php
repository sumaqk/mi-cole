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

                    <form method="POST" enctype="multipart/form-data">
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
                                        <input type="file" name="video_file" class="form-control" accept="video/*">
                                        <small class="text-muted">Formatos: MP4, AVI, MOV, WMV</small>
                                    </div>

                                    <div class="form-group">
                                        <label>URL de YouTube (Opcional)</label>
                                        <input type="url" name="youtube_url" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
                                    </div>

                                    <div class="form-group">
                                        <label>Imagen Thumbnail</label>
                                        <input type="file" name="thumbnail" class="form-control" accept="image/*">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Categoría</label>
                                        <select name="category" class="form-control">
                                            <option value="">Seleccionar</option>
                                            <option value="Educativo">Educativo</option>
                                            <option value="Tutorial">Tutorial</option>
                                            <option value="Documental">Documental</option>
                                            <option value="Capacitación">Capacitación</option>
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
                            <button type="submit" class="btn btn-primary">
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
@endsection
@extends('template.layout')

@section('title', 'Editar Video')

@section('generalBody')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Editar Video</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('index/indexadmin')}}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{url('contenidoweb/videos')}}">Videos</a></li>
                    <li class="breadcrumb-item active">Editar</li>
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
                            <i class="fa fa-edit"></i> Editar: {{$video->title ?: 'Video #' . $video->id}}
                        </h3>
                    </div>

                    <form method="POST" action="{{url('contenidoweb/videos/update/' . $video->id)}}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Título *</label>
                                        <input type="text" name="title" class="form-control" required value="{{$video->title}}">
                                    </div>

                                    <div class="form-group">
                                        <label>Descripción</label>
                                        <textarea name="description" class="form-control" rows="3">{{$video->description}}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Reemplazar Video (Opcional)</label>
                                        <input type="file" name="video_file" class="form-control" accept="video/*">
                                        @if($video->video_path)
                                            <small class="text-muted">Actual: {{basename($video->video_path)}}</small>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label>URL de YouTube</label>
                                        <input type="url" name="youtube_url" class="form-control" value="{{$video->youtube_url}}">
                                    </div>

                                    <div class="form-group">
                                        <label>Nuevo Thumbnail (Opcional)</label>
                                        <input type="file" name="thumbnail" class="form-control" accept="image/*">
                                        @if($video->thumbnail)
                                            <small class="text-muted">Actual: {{$video->thumbnail}}</small>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Categoría</label>
                                        <select name="category" class="form-control">
                                            <option value="">Seleccionar</option>
                                                <option value="Canciones"
                                                    {{ $content->category == 'Canciones' ? 'selected' : '' }}>Canciones
                                                </option>
                                                <option value="Cuentos y Relatos"
                                                    {{ $content->category == 'Cuentos y Relatos' ? 'selected' : '' }}>
                                                    Cuentos y Relatos</option>
                                                <option value="Artículos Educativos"
                                                    {{ $content->category == 'Artículos Educativos' ? 'selected' : '' }}>
                                                    Artículos Educativos</option>
                                                <option value="Guías y Manuales"
                                                    {{ $content->category == 'Guías y Manuales' ? 'selected' : '' }}>Guías
                                                    y Manuales</option>
                                                <option value="Infografías y Carteles"
                                                    {{ $content->category == 'Infografías y Carteles' ? 'selected' : '' }}>
                                                    Infografías y Carteles</option>
                                                <option value="Juegos y Actividades"
                                                    {{ $content->category == 'Juegos y Actividades' ? 'selected' : '' }}>
                                                    Juegos y Actividades</option>
                                                <option value="Experimentos Caseros"
                                                    {{ $content->category == 'Experimentos Caseros' ? 'selected' : '' }}>
                                                    Experimentos Caseros</option>
                                                <option value="Noticias"
                                                    {{ $content->category == 'Noticias' ? 'selected' : '' }}>Noticias
                                                </option>
                                                <option value="Importancia del Agua"
                                                    {{ $content->category == 'Importancia del Agua' ? 'selected' : '' }}>
                                                    Importancia del Agua</option>
                                                <option value="El Agua para Consumo Humano"
                                                    {{ $content->category == 'El Agua para Consumo Humano' ? 'selected' : '' }}>
                                                    El Agua para Consumo Humano</option>
                                                <option value="Otros Usos del Agua"
                                                    {{ $content->category == 'Otros Usos del Agua' ? 'selected' : '' }}>
                                                    Otros Usos del Agua</option>
                                                <option value="Garantizando la Calidad del Agua"
                                                    {{ $content->category == 'Garantizando la Calidad del Agua' ? 'selected' : '' }}>
                                                    Garantizando la Calidad del Agua</option>
                                                <option value="Tensiones en Torno al Agua"
                                                    {{ $content->category == 'Tensiones en Torno al Agua' ? 'selected' : '' }}>
                                                    Tensiones en Torno al Agua</option>
                                                <option value="El Uso Responsable del Agua"
                                                    {{ $content->category == 'El Uso Responsable del Agua' ? 'selected' : '' }}>
                                                    El Uso Responsable del Agua</option>
                                                <option value="Fascículos 1"
                                                    {{ $content->category == 'Fascículos 1' ? 'selected' : '' }}>Fascículos
                                                    1</option>
                                                <option value="Fascículos 2"
                                                    {{ $content->category == 'Fascículos 2' ? 'selected' : '' }}>Fascículos
                                                    2</option>
                                                <option value="Fascículos 3"
                                                    {{ $content->category == 'Fascículos 3' ? 'selected' : '' }}>Fascículos
                                                    3</option>
                                                <option value="Fascículos 4"
                                                    {{ $content->category == 'Fascículos 4' ? 'selected' : '' }}>Fascículos
                                                    4</option>
                                                <option value="Fascículos 5"
                                                    {{ $content->category == 'Fascículos 5' ? 'selected' : '' }}>Fascículos
                                                    5</option>
                                                <option value="Fascículos 6"
                                                    {{ $content->category == 'Fascículos 6' ? 'selected' : '' }}>Fascículos
                                                    6</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Orden</label>
                                        <input type="number" name="sort_order" class="form-control" value="{{$video->sort_order}}">
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="status" class="custom-control-input" id="status" {{$video->status ? 'checked' : ''}}>
                                            <label class="custom-control-label" for="status">Activo</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Actualizar Video
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
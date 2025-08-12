@extends('template.layout')

@section('title', 'Editar Contenido')

@section('generalBody')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Editar Contenido</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('index/indexadmin') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('contenidoweb/contenido') }}">Contenido</a></li>
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
                            <i class="fa fa-edit"></i> Editar: {{ $content->title ?: 'Sin título' }}
                        </h3>
                    </div>

                    <form method="POST" action="{{ url('contenidoweb/contenido/update/' . $content->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                {{-- Columna izquierda --}}
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Título *</label>
                                        <input type="text" name="title" class="form-control" required value="{{ old('title', $content->title) }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Resumen/Extracto</label>
                                        <textarea name="excerpt" class="form-control" rows="3">{{ old('excerpt', $content->excerpt) }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Contenido *</label>
                                        <textarea name="content" class="form-control" rows="10" required>{{ old('content', $content->content) }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Tags (separados por comas)</label>
                                        <input type="text" name="tags" class="form-control" value="{{ old('tags', $content->tags) }}">
                                    </div>

                                    {{-- Archivo PDF u otros --}}
                                    <div class="form-group">
                                        <label>Archivo relacionado (PDF, DOCX, etc.)</label>
                                        <input type="file" name="content_file" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx">

                                        @if (!empty($content->content_file ?? null))
                                            <div class="mt-2">
                                                <small class="text-muted d-block">Archivo actual:</small>
                                                <a href="{{ asset('storage/contenido/files/' . $content->content_file) }}" target="_blank">
                                                    {{ $content->content_file }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Columna derecha --}}
                                <div class="col-md-4">
                                    {{-- Imagen destacada --}}
                                    <div class="form-group">
                                        <label>Nueva Imagen Destacada (Thumbnail)</label>
                                        <input type="file" name="thumbnail" class="form-control" accept="image/*">

                                        @if (!empty($content->thumbnail ?? null))
                                            <div class="mt-2">
                                                <small class="text-muted d-block">Actual:</small>
                                                <img src="{{ asset('storage/contenido/images/' . $content->thumbnail) }}"
                                                     alt="Imagen actual"
                                                     class="img-fluid rounded"
                                                     style="max-height: 150px;">
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label>Categoría</label>
                                        <select name="category" class="form-control">
                                            <option value="">Seleccionar</option>
                                            @foreach(['Canciones','Cuentos y Relatos','Artículos Educativos','Guías y Manuales','Infografías y Carteles','Juegos y Actividades','Experimentos Caseros','Noticias','Importancia del Agua','El Agua para Consumo Humano','Otros Usos del Agua','Garantizando la Calidad del Agua','Tensiones en Torno al Agua','El Uso Responsable del Agua','Fascículos 1','Fascículos 2','Fascículos 3','Fascículos 4','Fascículos 5','Fascículos 6'] as $cat)
                                                <option value="{{ $cat }}" {{ $content->category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Subcategoría</label>
                                        <input type="text" name="subcategory" class="form-control" value="{{ old('subcategory', $content->subcategory) }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Fecha de Publicación</label>
                                        <input type="datetime-local" name="published_at" class="form-control"
                                            value="{{ old('published_at', $content->published_at ? \Carbon\Carbon::parse($content->published_at)->format('Y-m-d\TH:i') : '') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Orden</label>
                                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $content->sort_order) }}">
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="status" class="custom-control-input" id="status" {{ $content->status ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="status">Publicado</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="is_featured" class="custom-control-input" id="featured" {{ $content->is_featured ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="featured">Contenido Destacado</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Actualizar Contenido
                            </button>
                            <a href="{{ url('contenidoweb/contenido') }}" class="btn btn-secondary">
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

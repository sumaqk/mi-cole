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
                    <li class="breadcrumb-item"><a href="{{url('index/indexadmin')}}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{url('contenidoweb/contenido')}}">Contenido</a></li>
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
                            <i class="fa fa-edit"></i> Editar: {{$content->title}}
                        </h3>
                    </div>

                    <form method="POST" action="{{url('contenidoweb/contenido/update/' . $content->id)}}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Título *</label>
                                        <input type="text" name="title" class="form-control" required value="{{$content->title}}">
                                    </div>

                                    <div class="form-group">
                                        <label>Resumen/Extracto</label>
                                        <textarea name="excerpt" class="form-control" rows="3">{{$content->excerpt}}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Contenido *</label>
                                        <textarea name="content" class="form-control" rows="10" required>{{$content->content}}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Tags (separados por comas)</label>
                                        <input type="text" name="tags" class="form-control" value="{{$content->tags}}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Nueva Imagen Destacada</label>
                                        <input type="file" name="featured_image" class="form-control" accept="image/*">
                                        @if($content->featured_image)
                                            <small class="text-muted">Actual: {{$content->featured_image}}</small>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label>Categoría</label>
                                        <select name="category" class="form-control">
                                            <option value="">Seleccionar</option>
                                            <option value="Educación" {{$content->category == 'Educación' ? 'selected' : ''}}>Educación</option>
                                            <option value="Noticias" {{$content->category == 'Noticias' ? 'selected' : ''}}>Noticias</option>
                                            <option value="Tecnología" {{$content->category == 'Tecnología' ? 'selected' : ''}}>Tecnología</option>
                                            <option value="Salud" {{$content->category == 'Salud' ? 'selected' : ''}}>Salud</option>
                                            <option value="Medio Ambiente" {{$content->category == 'Medio Ambiente' ? 'selected' : ''}}>Medio Ambiente</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Subcategoría</label>
                                        <input type="text" name="subcategory" class="form-control" value="{{$content->subcategory}}">
                                    </div>

                                    <div class="form-group">
                                        <label>Fecha de Publicación</label>
                                        <input type="datetime-local" name="published_at" class="form-control" value="{{$content->published_at}}">
                                    </div>

                                    <div class="form-group">
                                        <label>Orden</label>
                                        <input type="number" name="sort_order" class="form-control" value="{{$content->sort_order}}">
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="status" class="custom-control-input" id="status" {{$content->status ? 'checked' : ''}}>
                                            <label class="custom-control-label" for="status">Publicado</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="is_featured" class="custom-control-input" id="featured" {{$content->is_featured ? 'checked' : ''}}>
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
@endsection
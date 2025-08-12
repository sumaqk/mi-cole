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
                            <i class="fa fa-plus"></i> Crear Artículo/Publicación
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
                                        <label>Resumen/Extracto</label>
                                        <textarea name="excerpt" class="form-control" rows="3" placeholder="Breve descripción del contenido..."></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Contenido *</label>
                                        <textarea name="content" class="form-control" rows="10" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Tags (separados por comas)</label>
                                        <input type="text" name="tags" class="form-control" placeholder="agua, salud, educación">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Imagen Destacada</label>
                                        <input type="file" name="featured_image" class="form-control" accept="image/*">
                                    </div>

                                    <div class="form-group">
                                        <label>Categoría</label>
                                        <select name="category" class="form-control">
                                            <option value="">Seleccionar</option>
                                            <option value="Educación">Educación</option>
                                            <option value="Noticias">Noticias</option>
                                            <option value="Tecnología">Tecnología</option>
                                            <option value="Salud">Salud</option>
                                            <option value="Medio Ambiente">Medio Ambiente</option>
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
                            <button type="submit" class="btn btn-primary">
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
@endsection
@extends('layout.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Gestión de Contenido
            <small>Blog y artículos del sistema</small>
        </h1>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Lista de Contenido</h3>
                <div class="box-tools pull-right">
                    <a href="{{url('home/material_agua/contenido_admin/insert')}}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Nuevo Contenido
                    </a>
                </div>
            </div>

            <div class="box-body">
                <form method="GET" class="row" style="margin-bottom: 15px;">
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control" placeholder="Buscar por título..." value="{{request('search')}}">
                    </div>
                    <div class="col-md-2">
                        <select name="category" class="form-control">
                            <option value="">Todas las categorías</option>
                            @foreach($categories as $cat)
                                <option value="{{$cat}}" {{request('category') == $cat ? 'selected' : ''}}>{{$cat}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-control">
                            <option value="">Todos los estados</option>
                            <option value="1" {{request('status') == '1' ? 'selected' : ''}}>Publicados</option>
                            <option value="0" {{request('status') == '0' ? 'selected' : ''}}>Borradores</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-default">
                            <i class="fa fa-search"></i> Filtrar
                        </button>
                        <a href="{{url('home/material_agua/contenido_admin')}}" class="btn btn-default">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th width="80">Imagen</th>
                                <th>Título</th>
                                <th>Categoría</th>
                                <th width="80">Vistas</th>
                                <th width="80">Estado</th>
                                <th width="80">Destacado</th>
                                <th width="100">Fecha</th>
                                <th width="140">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($contents as $content)
                                <tr>
                                    <td>{{$content->id}}</td>
                                    <td>
                                        @if($content->featured_image)
                                            <img src="{{$content->featured_image_url}}" class="img-thumbnail" style="width: 60px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-gray" style="width: 60px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fa fa-file-text"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{$content->title ?: 'Sin título'}}</strong>
                                        @if($content->excerpt)
                                            <br><small class="text-muted">{{Str::limit($content->excerpt, 60)}}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($content->category)
                                            <span class="label label-info">{{$content->category}}</span>
                                        @endif
                                        @if($content->subcategory)
                                            <br><small>{{$content->subcategory}}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-blue">{{$content->views_count}}</span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-xs {{$content->status ? 'btn-success' : 'btn-default'}}" onclick="toggleStatus({{$content->id}})">
                                            {{$content->status ? 'Publicado' : 'Borrador'}}
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-xs {{$content->is_featured ? 'btn-warning' : 'btn-default'}}" onclick="toggleFeatured({{$content->id}})">
                                            <i class="fa fa-star{{$content->is_featured ? '' : '-o'}}"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <small>{{$content->published_at ? $content->published_at->format('d/m/Y') : 'Sin fecha'}}</small>
                                    </td>
                                    <td>
                                        <a href="{{$content->url}}" class="btn btn-xs btn-info" target="_blank">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{url('home/material_agua/contenido_admin/edit/' . $content->id)}}" class="btn btn-xs btn-warning">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-xs btn-danger" onclick="deleteContent({{$content->id}})">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No hay contenido registrado</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="text-center">
                    {{$contents->appends(request()->query())->links()}}
                </div>
            </div>
        </div>
    </section>
</div>

<script>
function toggleStatus(id) {
    fetch(`/home/material_agua/contenido_admin/toggle-status/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function toggleFeatured(id) {
    fetch(`/home/material_agua/contenido_admin/toggle-featured/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function deleteContent(id) {
    if (confirm('¿Estás seguro de eliminar este contenido?')) {
        fetch(`/home/material_agua/contenido_admin/delete/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}
</script>
@endsection
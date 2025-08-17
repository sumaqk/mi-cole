@extends('template.layout')

@section('title', 'Gestión de Contenido')

@section('generalBody')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Gestión de Contenido</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('index/indexadmin')}}">Inicio</a></li>
                    <li class="breadcrumb-item active">Contenido</li>
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
                            <i class="fa fa-file-text"></i> Lista de Contenido
                        </h3>
                        <div class="card-tools">
                            <a href="{{url('contenidoweb/contenido/insert')}}" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i> Nuevo Contenido
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if(count($contents) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Título</th>
                                            <th>Categoría</th>
                                            <th>Estado</th>
                                            <th>Destacado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($contents as $content)
                                            <tr>
                                                <td>{{$content->id}}</td>
                                                <td>{{$content->title ?: 'Sin título'}}</td>
                                                <td>{{$content->category ?: 'Sin categoría'}}</td>
                                                <td>
                                                    @if($content->status)
                                                        <span class="badge badge-success">Publicado</span>
                                                    @else
                                                        <span class="badge badge-warning">Borrador</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($content->is_featured)
                                                        <i class="fa fa-star text-warning"></i>
                                                    @else
                                                        <i class="fa fa-star-o text-muted"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{url('contenidoweb/contenido/edit/' . $content->id)}}" class="btn btn-info btn-sm">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        
                                                        <!-- FORMULARIO PARA ELIMINAR - ESTO ES LO NUEVO -->
                                                        <form action="{{url('contenidoweb/contenido/delete/' . $content->id)}}" method="POST" style="display: inline;" onsubmit="return confirm('¿Eliminar contenido?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                        
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fa fa-file-text fa-3x text-muted mb-3"></i>
                                <h4 class="text-muted">No hay contenido registrado</h4>
                                <p class="text-muted">Comience creando nuevo contenido</p>
                                <a href="{{url('contenidoweb/contenido/insert')}}" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Crear Primer Contenido
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
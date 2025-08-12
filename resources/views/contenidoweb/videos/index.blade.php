@extends('template.layout')

@section('title', 'Gestión de Videos')

@section('generalBody')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Gestión de Videos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('index/indexadmin')}}">Inicio</a></li>
                    <li class="breadcrumb-item active">Videos</li>
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
                            <i class="fa fa-video-camera"></i> Lista de Videos
                        </h3>
                        <div class="card-tools">
                            <a href="{{url('contenidoweb/videos/insert')}}" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i> Nuevo Video
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if(count($videos) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Título</th>
                                            <th>Categoría</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($videos as $video)
                                            <tr>
                                                <td>{{$video->id}}</td>
                                                <td>{{$video->title ?: 'Sin título'}}</td>
                                                <td>{{$video->category ?: 'Sin categoría'}}</td>
                                                <td>
                                                    @if($video->status)
                                                        <span class="badge badge-success">Activo</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactivo</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{url('contenidoweb/videos/edit/' . $video->id)}}" class="btn btn-info btn-sm">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteVideo({{$video->id}})">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fa fa-video-camera fa-3x text-muted mb-3"></i>
                                <h4 class="text-muted">No hay videos registrados</h4>
                                <p class="text-muted">Comience creando un nuevo video</p>
                                <a href="{{url('contenidoweb/videos/insert')}}" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Crear Primer Video
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

@section('jsSection')
<script>
function deleteVideo(id) {
    if (confirm('¿Eliminar video?')) {
        fetch(`/contenidoweb/videos/delete/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(() => location.reload());
    }
}
</script>
@endsection
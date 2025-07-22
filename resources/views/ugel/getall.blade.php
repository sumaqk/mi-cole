@extends('template.layout')

@section('title', 'Gestión de UGELs')

@section('generalBody')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Gestión de UGELs</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('index/indexadmin')}}">Inicio</a></li>
                    <li class="breadcrumb-item active">UGELs</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa fa-graduation-cap"></i> Lista de UGELs
                        </h3>
                        <div class="card-tools">
                            <a href="{{ url('ugel/insert') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i> Nueva UGEL
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        @if(count($listTUgel) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Provincia</th>
                                            <th>Distrito</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($listTUgel as $ugel)
                                            <tr>
                                                <td>{{ $ugel->code }}</td>
                                                <td>
                                                    {{ $ugel->name }}
                                                    @if($ugel->director)
                                                        <br><small class="text-muted">Director: {{ $ugel->director }}</small>
                                                    @endif
                                                </td>
                                                <td>{{ $ugel->tProvince->name ?? 'N/A' }}</td>
                                                <td>{{ $ugel->tDistrict->name ?? 'N/A' }}</td>
                                                <td>
                                                    @if($ugel->is_active)
                                                        <span class="badge badge-success">Activa</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactiva</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="{{ url('ugel/edit/' . $ugel->idUgel) }}" 
                                                           class="btn btn-info btn-sm" 
                                                           title="Editar"
                                                           data-toggle="tooltip">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        
                                                        <form method="POST" action="{{ url('ugel/toggle-status/' . $ugel->idUgel) }}" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="btn btn-{{ $ugel->is_active ? 'warning' : 'success' }} btn-sm" 
                                                                    title="{{ $ugel->is_active ? 'Desactivar' : 'Activar' }}"
                                                                    data-toggle="tooltip"
                                                                    onclick="return confirm('¿Está seguro de {{ $ugel->is_active ? 'desactivar' : 'activar' }} esta UGEL?')">
                                                                <i class="fa fa-{{ $ugel->is_active ? 'times' : 'check' }}"></i>
                                                            </button>
                                                        </form>
                                                        
                                                        <form method="POST" action="{{ url('ugel/delete/' . $ugel->idUgel) }}" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="btn btn-danger btn-sm" 
                                                                    title="Eliminar"
                                                                    data-toggle="tooltip"
                                                                    onclick="return confirm('¿Está seguro de eliminar esta UGEL? Esta acción no se puede deshacer.')">
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

                            <!-- Paginación -->
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="text-muted">
                                        Mostrando {{ ($currentPage - 1) * 7 + 1 }} a 
                                        {{ min($currentPage * 7, count($listTUgel)) }} registros
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <div class="float-right">
                                        @if($quantityPage > 1)
                                            <nav>
                                                <ul class="pagination">
                                                    @if($currentPage > 1)
                                                        <li class="page-item">
                                                            <a class="page-link" href="{{ url('ugel/getall/' . ($currentPage - 1)) }}">Anterior</a>
                                                        </li>
                                                    @endif
                                                    
                                                    @for($i = 1; $i <= $quantityPage; $i++)
                                                        <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                                            <a class="page-link" href="{{ url('ugel/getall/' . $i) }}">{{ $i }}</a>
                                                        </li>
                                                    @endfor
                                                    
                                                    @if($currentPage < $quantityPage)
                                                        <li class="page-item">
                                                            <a class="page-link" href="{{ url('ugel/getall/' . ($currentPage + 1)) }}">Siguiente</a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </nav>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fa fa-graduation-cap fa-3x text-muted mb-3"></i>
                                <h4 class="text-muted">No hay UGELs registradas</h4>
                                <p class="text-muted">Comience creando una nueva UGEL</p>
                                <a href="{{ url('ugel/insert') }}" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Crear Primera UGEL
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
$(document).ready(function() {
    // Activar tooltips
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endsection
@extends('layout.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Nuevo Video</h1>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Agregar Video</h3>
            </div>

            <form method="POST" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Título *</label>
                                <input type="text" name="title" class="form-control" required value="{{old('title')}}">
                            </div>

                            <div class="form-group">
                                <label>Descripción</label>
                                <textarea name="description" class="form-control" rows="3">{{old('description')}}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Archivo de Video *</label>
                                <input type="file" name="video_file" class="form-control" accept="video/*" required>
                                <small class="text-muted">Formatos: MP4, AVI, MOV, WMV (Máx: 100MB)</small>
                            </div>

                            <div class="form-group">
                                <label>URL de YouTube (Opcional)</label>
                                <input type="url" name="youtube_url" class="form-control" value="{{old('youtube_url')}}" placeholder="https://www.youtube.com/watch?v=...">
                                <small class="text-muted">Si pones URL de YouTube, se mostrará como alternativa</small>
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
                                    <option value="">Seleccionar categoría</option>
                                    <option value="Educativo">Educativo</option>
                                    <option value="Tutorial">Tutorial</option>
                                    <option value="Documental">Documental</option>
                                    <option value="Capacitación">Capacitación</option>
                                    <option value="Institucional">Institucional</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Orden</label>
                                <input type="number" name="sort_order" class="form-control" value="{{old('sort_order', 0)}}">
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="status" checked> Activo
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Guardar Video
                    </button>
                    <a href="{{url('home/material_agua/videos_admin')}}" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
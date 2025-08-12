@extends('layout.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Editar Video</h1>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Editar: {{$video->title ?: 'Video #' . $video->id}}</h3>
            </div>

            <form method="POST" action="{{url('home/material_agua/videos_admin/update/' . $video->id)}}" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Título *</label>
                                <input type="text" name="title" class="form-control" required value="{{old('title', $video->title)}}">
                            </div>

                            <div class="form-group">
                                <label>Descripción</label>
                                <textarea name="description" class="form-control" rows="3">{{old('description', $video->description)}}</textarea>
                            </div>

                            @if($video->video_path)
                                <div class="form-group">
                                    <label>Video Actual</label>
                                    <div class="well well-sm">
                                        <i class="fa fa-file-video-o"></i> {{basename($video->video_path)}}
                                        <br><small class="text-muted">Archivo en servidor</small>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <label>Reemplazar Video (Opcional)</label>
                                <input type="file" name="video_file" class="form-control" accept="video/*">
                                <small class="text-muted">Dejar vacío para mantener el video actual</small>
                            </div>

                            <div class="form-group">
                                <label>URL de YouTube (Opcional)</label>
                                <input type="url" name="youtube_url" class="form-control" value="{{old('youtube_url', $video->youtube_url)}}" placeholder="https://www.youtube.com/watch?v=...">
                                <small class="text-muted">Alternativa al video del servidor</small>
                            </div>

                            @if($video->thumbnail)
                                <div class="form-group">
                                    <label>Thumbnail Actual</label>
                                    <div style="margin-bottom: 10px;">
                                        <img src="{{$video->thumbnail_url}}" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <label>Nuevo Thumbnail (Opcional)</label>
                                <input type="file" name="thumbnail" class="form-control" accept="image/*">
                                <small class="text-muted">Dejar vacío para mantener thumbnail actual</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Categoría</label>
                                <select name="category" class="form-control">
                                    <option value="">Seleccionar categoría</option>
                                    @foreach(['Educativo', 'Tutorial', 'Documental', 'Capacitación', 'Institucional'] as $cat)
                                        <option value="{{$cat}}" {{old('category', $video->category) == $cat ? 'selected' : ''}}>{{$cat}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Orden</label>
                                <input type="number" name="sort_order" class="form-control" value="{{old('sort_order', $video->sort_order)}}">
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="status" {{old('status', $video->status) ? 'checked' : ''}}> Activo
                                    </label>
                                </div>
                            </div>

                            @if($video->youtube_url)
                                <div class="form-group">
                                    <label>Vista Previa YouTube</label>
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe class="embed-responsive-item" src="{{$video->youtube_embed}}" allowfullscreen></iframe>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Actualizar Video
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
@extends('layout.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Editar Contenido</h1>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Editar: {{$content->title}}</h3>
            </div>

            <form method="POST" action="{{url('home/material_agua/contenido_admin/update/' . $content->id)}}" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Título *</label>
                                <input type="text" name="title" class="form-control" required value="{{old('title', $content->title)}}">
                            </div>

                            <div class="form-group">
                                <label>Resumen/Extracto</label>
                                <textarea name="excerpt" class="form-control" rows="3">{{old('excerpt', $content->excerpt)}}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Contenido *</label>
                                <textarea name="content" id="content-editor" class="form-control" rows="15" required>{{old('content', $content->content)}}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Tags (separados por comas)</label>
                                <input type="text" name="tags" class="form-control" value="{{old('tags', $content->tags)}}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Imagen Destacada Actual</label>
                                @if($content->featured_image)
                                    <div style="margin-bottom: 10px;">
                                        <img src="{{$content->featured_image_url}}" class="img-thumbnail" style="max-width: 100%; max-height: 200px;">
                                    </div>
                                @endif
                                <input type="file" name="featured_image" class="form-control" accept="image/*">
                                <small class="text-muted">Dejar vacío para mantener la imagen actual</small>
                            </div>

                            <div class="form-group">
                                <label>Categoría</label>
                                <select name="category" class="form-control">
                                    <option value="">Seleccionar categoría</option>
                                    @foreach(['Educación', 'Noticias', 'Tecnología', 'Salud', 'Medio Ambiente', 'Proyectos', 'Investigación'] as $cat)
                                        <option value="{{$cat}}" {{old('category', $content->category) == $cat ? 'selected' : ''}}>{{$cat}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Subcategoría</label>
                                <input type="text" name="subcategory" class="form-control" value="{{old('subcategory', $content->subcategory)}}">
                            </div>

                            <div class="form-group">
                                <label>Fecha de Publicación</label>
                                <input type="datetime-local" name="published_at" class="form-control" value="{{old('published_at', $content->published_at ? $content->published_at->format('Y-m-d\TH:i') : '')}}">
                            </div>

                            <div class="form-group">
                                <label>Orden</label>
                                <input type="number" name="sort_order" class="form-control" value="{{old('sort_order', $content->sort_order)}}">
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="status" {{old('status', $content->status) ? 'checked' : ''}}> Publicado
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="is_featured" {{old('is_featured', $content->is_featured) ? 'checked' : ''}}> Contenido Destacado
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Estadísticas</label>
                                <div class="info-box">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-eye"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Vistas</span>
                                        <span class="info-box-number">{{$content->views_count}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Actualizar Contenido
                    </button>
                    <a href="{{url('home/material_agua/contenido_admin')}}" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> Cancelar
                    </a>
                    <a href="{{$content->url}}" class="btn btn-info" target="_blank">
                        <i class="fa fa-eye"></i> Ver en sitio
                    </a>
                </div>
            </form>
        </div>
    </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: '#content-editor',
    height: 400,
    menubar: false,
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
        'insertdatetime', 'media', 'table', 'help', 'wordcount'
    ],
    toolbar: 'undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
    language: 'es'
});
</script>
@endsection
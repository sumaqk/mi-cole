@extends('layout.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Nuevo Contenido</h1>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Crear Artículo/Publicación</h3>
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
                                <label>Resumen/Extracto</label>
                                <textarea name="excerpt" class="form-control" rows="3" placeholder="Breve descripción del contenido...">{{old('excerpt')}}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Contenido *</label>
                                <textarea name="content" id="content-editor" class="form-control" rows="15" required>{{old('content')}}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Tags (separados por comas)</label>
                                <input type="text" name="tags" class="form-control" value="{{old('tags')}}" placeholder="agua, salud, educación, medio ambiente">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Imagen Destacada</label>
                                <input type="file" name="featured_image" class="form-control" accept="image/*">
                                <small class="text-muted">Imagen principal del artículo</small>
                            </div>

                            <div class="form-group">
                                <label>Categoría</label>
                                <select name="category" class="form-control">
                                    <option value="">Seleccionar categoría</option>
                                    <option value="Educación">Educación</option>
                                    <option value="Noticias">Noticias</option>
                                    <option value="Tecnología">Tecnología</option>
                                    <option value="Salud">Salud</option>
                                    <option value="Medio Ambiente">Medio Ambiente</option>
                                    <option value="Proyectos">Proyectos</option>
                                    <option value="Investigación">Investigación</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Subcategoría</label>
                                <input type="text" name="subcategory" class="form-control" value="{{old('subcategory')}}" placeholder="Subcategoría específica">
                            </div>

                            <div class="form-group">
                                <label>Fecha de Publicación</label>
                                <input type="datetime-local" name="published_at" class="form-control" value="{{old('published_at', date('Y-m-d\TH:i'))}}">
                            </div>

                            <div class="form-group">
                                <label>Orden</label>
                                <input type="number" name="sort_order" class="form-control" value="{{old('sort_order', 0)}}">
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="status" checked> Publicado
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="is_featured"> Contenido Destacado
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Guardar Contenido
                    </button>
                    <a href="{{url('home/material_agua/contenido_admin')}}" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> Cancelar
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
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;


class ContenidoWebController extends Controller
{
    // Método para mostrar contenido en el frontend
    public function index()
    {
        // Obtener contenido agrupado por categorías
        $contents = DB::table('tcontent')
            ->where('status', 1)
            ->orderBy('sort_order', 'asc')
            ->orderBy('published_at', 'desc')
            ->get();

        $videos = DB::table('tvideo')
            ->where('status', 1)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        // Agrupar por categorías
        $categoriesWithContent = [];

        foreach ($contents as $content) {
            $category = $content->category ?: 'Sin Categoría';

            if (!isset($categoriesWithContent[$category])) {
                $categoriesWithContent[$category] = [
                    'icon' => $this->getCategoryIcon($category),
                    'contents' => [],
                    'videos' => []
                ];
            }

            $categoriesWithContent[$category]['contents'][] = $content;
        }

        foreach ($videos as $video) {
            $category = $video->category ?: 'Sin Categoría';

            if (!isset($categoriesWithContent[$category])) {
                $categoriesWithContent[$category] = [
                    'icon' => $this->getCategoryIcon($category),
                    'contents' => [],
                    'videos' => []
                ];
            }

            $categoriesWithContent[$category]['videos'][] = $video;
        }

        return view('home.content', compact('categoriesWithContent'));
    }

    private function getCategoryIcon($category)
    {
        $icons = [
            'Cuentos y Relatos' => '📚',
            'Ciencias' => '🔬',
            'Historia' => '📜',
            'Matemáticas' => '🔢',
            'Arte' => '🎨',
            'Música' => '🎵'
        ];

        return $icons[$category] ?? '📁';
    }

    public function actionVideosIndex(Request $request)
    {
        $query = DB::table('tvideo')->orderBy('sort_order', 'asc')->orderBy('id', 'desc');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $videos = $query->paginate(20);
        $categories = DB::table('tvideo')->whereNotNull('category')->distinct()->pluck('category');

        return view('contenidoweb.videos.index', compact('videos', 'categories'));
    }

    public function actionVideosInsert(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'title'       => 'required|string|max:255',
                'description' => 'nullable|string',
                'category'    => 'nullable|string|max:100',
                'youtube_url' => 'nullable|url',
                'video_file'  => 'nullable|file|mimes:mp4,webm,avi,mov|max:500000',
                'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'sort_order'  => 'nullable|integer'
            ]);

            $data = [
                'title'       => $request->title,
                'description' => $request->description,
                'category'    => $request->category,
                'youtube_url' => $request->youtube_url,
                'status'      => $request->boolean('status') ? 1 : 0,
                'sort_order'  => $request->sort_order ?? 0,
                'created_by'  => Session::get('idUser'),
                'created_at'  => now(),
                'updated_at'  => now(),
            ];

            // Manejo de video
            if ($request->hasFile('video_file')) {
                $file = $request->file('video_file');
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

                // Crear directorio si no existe
                Storage::disk('archivos')->makeDirectory('videos');

                $file->storeAs('videos', $filename, 'archivos');
                $data['video_file'] = $filename;
                $data['file_type']  = $file->getClientOriginalExtension();
                $data['mime_type']  = $file->getMimeType();
                $data['file_size']  = $file->getSize();
            }

            // Manejo de thumbnail
            if ($request->hasFile('thumbnail')) {
                $thumb = $request->file('thumbnail');
                $thumbName = time() . '_thumb_' . Str::random(5) . '.' . $thumb->getClientOriginalExtension();

                // Crear directorio si no existe
                Storage::disk('archivos')->makeDirectory('videos/thumbnails');

                $thumb->storeAs('videos/thumbnails', $thumbName, 'archivos');
                $data['thumbnail'] = $thumbName;
            }

            DB::table('tvideo')->insert($data);
            return redirect()->route('videos.index')->with('success', 'Video subido correctamente');
        }

        return view('contenidoweb.videos.insert');
    }

    public function actionContenidoInsert(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'title' => 'required|string|max:255',
                'excerpt' => 'nullable|string|max:500',
                'content' => 'required|string',
                'category' => 'nullable|string|max:100',
                'subcategory' => 'nullable|string|max:100',
                'tags' => 'nullable|string',
                'content_file' => 'nullable|file|mimes:pdf,mp3,wav,doc,docx,txt|max:102400',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'sort_order' => 'nullable|integer',
                'published_at' => 'nullable|date'
            ]);

            $data = [
                'title' => $request->title,
                'excerpt' => $request->excerpt,
                'content' => $request->input('content'),
                'category' => $request->category,
                'subcategory' => $request->subcategory,
                'tags' => $request->tags,
                'slug' => Str::slug($request->title),
                'status' => $request->boolean('status') ? 1 : 0,
                'is_featured' => $request->boolean('is_featured') ? 1 : 0,
                'sort_order' => $request->sort_order ?? 0,
                'published_at' => $request->published_at ?? now(),
                'created_by' => Session::get('idUser'),
                'created_at' => now(),
                'updated_at' => now(),
                'views_count' => 0,
                'thumbnail' => null
            ];

            // Manejo de archivo de contenido
            if ($request->hasFile('content_file')) {
                $file = $request->file('content_file');
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

                if (!Storage::disk('archivos')->exists('contenido/files')) {
                    Storage::disk('archivos')->makeDirectory('contenido/files');
                }

                $file->storeAs('contenido/files', $filename, 'archivos');
                $data['content_file'] = $filename;
                $data['file_type'] = $file->getClientOriginalExtension();
                $data['mime_type'] = $file->getMimeType();
                $data['file_size'] = $file->getSize();
            }

            // Manejo de thumbnail
            if ($request->hasFile('thumbnail')) {
                $thumb = $request->file('thumbnail');
                $thumbName = time() . '_thumb_' . Str::random(5) . '.' . $thumb->getClientOriginalExtension();

                if (!Storage::disk('archivos')->exists('contenido/images')) {
                    Storage::disk('archivos')->makeDirectory('contenido/images');
                }

                $thumb->storeAs('contenido/images', $thumbName, 'archivos');
                $data['thumbnail'] = $thumbName;
            }

            DB::table('tcontent')->insert($data);
            return redirect()->route('contenido.index')->with('success', 'Contenido subido correctamente');
        }

        return view('contenidoweb.contenido.insert');
    }
    // Resto de métodos existentes...
    public function actionVideosEdit($id)
    {
        $video = DB::table('tvideo')->where('id', $id)->first();
        abort_unless($video, 404);
        return view('contenidoweb.videos.edit', compact('video'));
    }

    public function actionVideosUpdate(Request $request, $id)
    {
        $video = DB::table('tvideo')->where('id', $id)->first();
        abort_unless($video, 404);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'youtube_url' => 'nullable|url',
            'video_file' => 'nullable|file|mimes:mp4,webm,avi,mov|max:500000',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'sort_order' => 'nullable|integer'
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'youtube_url' => $request->youtube_url,
            'status' => $request->boolean('status') ? 1 : 0,
            'sort_order' => $request->sort_order ?? 0,
            'updated_at' => now(),
        ];

        if ($request->hasFile('video_file')) {
            if ($video->video_file && Storage::disk('archivos')->exists('videos/' . $video->video_file)) {
                Storage::disk('archivos')->delete('videos/' . $video->video_file);
            }
            $file = $request->file('video_file');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('videos', $filename, 'archivos');
            $data['video_file'] = $filename;
            $data['file_type'] = $file->getClientOriginalExtension();
            $data['mime_type'] = $file->getMimeType();
            $data['file_size'] = $file->getSize();
        }

        if ($request->hasFile('thumbnail')) {
            if ($video->thumbnail && Storage::disk('archivos')->exists('videos/thumbnails/' . $video->thumbnail)) {
                Storage::disk('archivos')->delete('videos/thumbnails/' . $video->thumbnail);
            }
            $thumb = $request->file('thumbnail');
            $thumbName = time() . '_thumb_' . Str::random(5) . '.' . $thumb->getClientOriginalExtension();
            $thumb->storeAs('videos/thumbnails', $thumbName, 'archivos');
            $data['thumbnail'] = $thumbName;
        }

        DB::table('tvideo')->where('id', $id)->update($data);
        return redirect()->route('videos.index')->with('success', 'Video actualizado correctamente');
    }

    public function actionVideosDelete($id)
    {
        $video = DB::table('tvideo')->where('id', $id)->first();
        if (!$video) {
            return response()->json(['success' => false, 'message' => 'Video no encontrado']);
        }

        if ($video->video_file && Storage::disk('archivos')->exists('videos/' . $video->video_file)) {
            Storage::disk('archivos')->delete('videos/' . $video->video_file);
        }

        if ($video->thumbnail && Storage::disk('archivos')->exists('videos/thumbnails/' . $video->thumbnail)) {
            Storage::disk('archivos')->delete('videos/thumbnails/' . $video->thumbnail);
        }

        DB::table('tvideo')->where('id', $id)->delete();
        return response()->json(['success' => true, 'message' => 'Video eliminado correctamente']);
    }

    public function actionContenidoIndex(Request $request)
    {
        $query = DB::table('tcontent')->orderBy('sort_order', 'asc')->orderBy('published_at', 'desc');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $contents = $query->paginate(15);
        $categories = DB::table('tcontent')->whereNotNull('category')->distinct()->pluck('category');

        return view('contenidoweb.contenido.index', compact('contents', 'categories'));
    }

    public function actionContenidoEdit($id)
    {
        $content = DB::table('tcontent')->where('id', $id)->first();
        abort_unless($content, 404);
        return view('contenidoweb.contenido.edit', compact('content'));
    }

    public function actionContenidoUpdate(Request $request, $id)
    {
        $content = DB::table('tcontent')->where('id', $id)->first();
        abort_unless($content, 404);

        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category' => 'nullable|string|max:100',
            'subcategory' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'content_file' => 'nullable|file|mimes:pdf,mp3,wav,doc,docx,txt|max:102400',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'sort_order' => 'nullable|integer'
        ]);

        $data = [
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'content' => $request->input('content'),
            'category' => $request->category,
            'subcategory' => $request->subcategory,
            'tags' => $request->tags,
            'status' => $request->boolean('status') ? 1 : 0,
            'is_featured' => $request->boolean('is_featured') ? 1 : 0,
            'sort_order' => $request->sort_order ?? 0,
            'updated_at' => now(),
        ];

        if ($request->title !== $content->title) {
            $data['slug'] = Str::slug($request->title);
        }

        if ($request->hasFile('content_file')) {
            if ($content->content_file && Storage::disk('archivos')->exists('contenido/files/' . $content->content_file)) {
                Storage::disk('archivos')->delete('contenido/files/' . $content->content_file);
            }
            $file = $request->file('content_file');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('contenido/files', $filename, 'archivos');
            $data['content_file'] = $filename;
            $data['file_type'] = $file->getClientOriginalExtension();
            $data['mime_type'] = $file->getMimeType();
            $data['file_size'] = $file->getSize();
        }

        if ($request->hasFile('thumbnail')) {
            if ($content->thumbnail && Storage::disk('archivos')->exists('contenido/images/' . $content->thumbnail)) {
                Storage::disk('archivos')->delete('contenido/images/' . $content->thumbnail);
            }
            $thumb = $request->file('thumbnail');
            $thumbName = time() . '_thumb_' . Str::random(5) . '.' . $thumb->getClientOriginalExtension();
            $thumb->storeAs('contenido/images', $thumbName, 'archivos');
            $data['thumbnail'] = $thumbName;
        }

        DB::table('tcontent')->where('id', $id)->update($data);
        return redirect()->route('contenido.index')->with('success', 'Contenido actualizado correctamente');
    }

    public function actionContenidoDelete($id)
    {
        $content = DB::table('tcontent')->where('id', $id)->first();
        if (!$content) {
            return response()->json(['success' => false, 'message' => 'Contenido no encontrado']);
        }

        if ($content->content_file && Storage::disk('archivos')->exists('contenido/files/' . $content->content_file)) {
            Storage::disk('archivos')->delete('contenido/files/' . $content->content_file);
        }

        if ($content->thumbnail && Storage::disk('archivos')->exists('contenido/images/' . $content->thumbnail)) {
            Storage::disk('archivos')->delete('contenido/images/' . $content->thumbnail);
        }

        DB::table('tcontent')->where('id', $id)->delete();
        return response()->json(['success' => true, 'message' => 'Contenido eliminado correctamente']);
    }
}
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ContenidoWebController extends Controller
{
    public function actionVideosIndex(Request $request)
    {
        $query = DB::table('tvideo')->orderBy('sort_order', 'asc')->orderBy('id', 'desc');
        
        if ($request->filled('category') && $request->category != '') {
            $query->where('category', $request->category);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        
        $videos = $query->paginate(20);
        $categories = DB::table('tvideo')->distinct()->whereNotNull('category')->pluck('category');
        
        return view('contenidoweb.videos.index', compact('videos', 'categories'));
    }

    public function actionVideosInsert(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'youtube_url' => $request->youtube_url,
                'status' => $request->has('status') ? 1 : 0,
                'sort_order' => $request->sort_order ?? 0,
                'created_by' => Session::get('idUser')
            ];

            if ($request->hasFile('video_file')) {
                $file = $request->file('video_file');
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('videos', $filename, 'public');
                $data['video_path'] = 'storage/videos/' . $filename;
            }

            if ($request->hasFile('thumbnail')) {
                $thumb = $request->file('thumbnail');
                $thumbName = time() . '_thumb.' . $thumb->getClientOriginalExtension();
                $thumb->storeAs('videos/thumbnails', $thumbName, 'public');
                $data['thumbnail'] = $thumbName;
            }

            DB::table('tvideo')->insert($data);

            return redirect()->route('videos.index')->with('success', 'Video agregado correctamente');
        }

        return view('contenidoweb.videos.insert');
    }

    public function actionVideosEdit($id)
    {
        $video = DB::table('tvideo')->where('id', $id)->first();
        if (!$video) {
            abort(404);
        }
        
        $categories = DB::table('tvideo')->distinct()->whereNotNull('category')->pluck('category');
        
        return view('contenidoweb.videos.edit', compact('video', 'categories'));
    }

    public function actionVideosUpdate(Request $request, $id)
    {
        $video = DB::table('tvideo')->where('id', $id)->first();
        if (!$video) {
            abort(404);
        }
        
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'youtube_url' => $request->youtube_url,
            'status' => $request->has('status') ? 1 : 0,
            'sort_order' => $request->sort_order ?? 0
        ];

        if ($request->hasFile('video_file')) {
            if ($video->video_path && file_exists(public_path($video->video_path))) {
                unlink(public_path($video->video_path));
            }
            
            $file = $request->file('video_file');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('videos', $filename, 'public');
            $data['video_path'] = 'storage/videos/' . $filename;
        }

        if ($request->hasFile('thumbnail')) {
            if ($video->thumbnail && file_exists(public_path('storage/videos/thumbnails/' . $video->thumbnail))) {
                unlink(public_path('storage/videos/thumbnails/' . $video->thumbnail));
            }
            
            $thumb = $request->file('thumbnail');
            $thumbName = time() . '_thumb.' . $thumb->getClientOriginalExtension();
            $thumb->storeAs('videos/thumbnails', $thumbName, 'public');
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
        
        if ($video->video_path && file_exists(public_path($video->video_path))) {
            unlink(public_path($video->video_path));
        }
        
        if ($video->thumbnail && file_exists(public_path('storage/videos/thumbnails/' . $video->thumbnail))) {
            unlink(public_path('storage/videos/thumbnails/' . $video->thumbnail));
        }
        
        DB::table('tvideo')->where('id', $id)->delete();

        return response()->json(['success' => true, 'message' => 'Video eliminado correctamente']);
    }

    public function actionContenidoIndex(Request $request)
    {
        $query = DB::table('tcontent')->orderBy('sort_order', 'asc')->orderBy('published_at', 'desc');
        
        if ($request->filled('category') && $request->category != '') {
            $query->where('category', $request->category);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        
        $contents = $query->paginate(15);
        $categories = DB::table('tcontent')->distinct()->whereNotNull('category')->pluck('category');
        
        return view('contenidoweb.contenido.index', compact('contents', 'categories'));
    }

    public function actionContenidoInsert(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = [
                'title' => $request->title,
                'excerpt' => $request->excerpt,
                'content' => $request->content,
                'category' => $request->category,
                'subcategory' => $request->subcategory,
                'tags' => $request->tags,
                'slug' => Str::slug($request->title),
                'status' => $request->has('status') ? 1 : 0,
                'is_featured' => $request->has('is_featured') ? 1 : 0,
                'sort_order' => $request->sort_order ?? 0,
                'published_at' => $request->published_at ?? now(),
                'created_by' => Session::get('idUser')
            ];
            
            if ($request->hasFile('featured_image')) {
                $file = $request->file('featured_image');
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('contenido/images', $filename, 'public');
                $data['featured_image'] = $filename;
            }

            DB::table('tcontent')->insert($data);

            return redirect()->route('contenido.index')->with('success', 'Contenido agregado correctamente');
        }

        $categories = DB::table('tcontent')->distinct()->whereNotNull('category')->pluck('category');
        
        return view('contenidoweb.contenido.insert', compact('categories'));
    }

    public function actionContenidoEdit($id)
    {
        $content = DB::table('tcontent')->where('id', $id)->first();
        if (!$content) {
            abort(404);
        }
        
        $categories = DB::table('tcontent')->distinct()->whereNotNull('category')->pluck('category');
        
        return view('contenidoweb.contenido.edit', compact('content', 'categories'));
    }

    public function actionContenidoUpdate(Request $request, $id)
    {
        $content = DB::table('tcontent')->where('id', $id)->first();
        if (!$content) {
            abort(404);
        }
        
        $data = [
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'category' => $request->category,
            'subcategory' => $request->subcategory,
            'tags' => $request->tags,
            'status' => $request->has('status') ? 1 : 0,
            'is_featured' => $request->has('is_featured') ? 1 : 0,
            'sort_order' => $request->sort_order ?? 0
        ];

        if ($request->title !== $content->title) {
            $data['slug'] = Str::slug($request->title);
        }

        if ($request->hasFile('featured_image')) {
            if ($content->featured_image && file_exists(public_path('storage/contenido/images/' . $content->featured_image))) {
                unlink(public_path('storage/contenido/images/' . $content->featured_image));
            }
            
            $file = $request->file('featured_image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('contenido/images', $filename, 'public');
            $data['featured_image'] = $filename;
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
        
        if ($content->featured_image && file_exists(public_path('storage/contenido/images/' . $content->featured_image))) {
            unlink(public_path('storage/contenido/images/' . $content->featured_image));
        }
        
        DB::table('tcontent')->where('id', $id)->delete();

        return response()->json(['success' => true, 'message' => 'Contenido eliminado correctamente']);
    }

    public function actionContenidoToggleStatus($id)
    {
        $content = DB::table('tcontent')->where('id', $id)->first();
        if (!$content) {
            return response()->json(['success' => false, 'message' => 'Contenido no encontrado']);
        }
        
        $newStatus = $content->status ? 0 : 1;
        DB::table('tcontent')->where('id', $id)->update(['status' => $newStatus]);

        return response()->json([
            'success' => true, 
            'status' => $newStatus,
            'message' => $newStatus ? 'Contenido activado' : 'Contenido desactivado'
        ]);
    }

    public function actionContenidoToggleFeatured($id)
    {
        $content = DB::table('tcontent')->where('id', $id)->first();
        if (!$content) {
            return response()->json(['success' => false, 'message' => 'Contenido no encontrado']);
        }
        
        $newFeatured = $content->is_featured ? 0 : 1;
        DB::table('tcontent')->where('id', $id)->update(['is_featured' => $newFeatured]);

        return response()->json([
            'success' => true, 
            'is_featured' => $newFeatured,
            'message' => $newFeatured ? 'Marcado como destacado' : 'Removido de destacados'
        ]);
    }
}
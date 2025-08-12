<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\TVideo;
use App\Models\TContent;

class ContenidoWebController extends Controller
{
    public function actionVideosIndex(Request $request)
    {
        $query = TVideo::orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');
        
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
        $categories = TVideo::distinct('category')->whereNotNull('category')->pluck('category');
        
        return view('home.material_agua.videos.index', compact('videos', 'categories'));
    }

    public function actionVideosInsert(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'category' => 'nullable|string|max:100',
                'youtube_url' => 'nullable|url',
                'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv|max:102400',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'sort_order' => 'nullable|integer'
            ]);

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

            $data['status'] = $request->has('status');
            $data['sort_order'] = $data['sort_order'] ?? 0;
            $data['created_by'] = Session::get('idUser');

            TVideo::create($data);

            return redirect()->route('videos.index')->with('success', 'Video agregado correctamente');
        }

        return view('home.material_agua.videos.insert');
    }

    public function actionVideosEdit($id)
    {
        $video = TVideo::findOrFail($id);
        $categories = TVideo::distinct('category')->whereNotNull('category')->pluck('category');
        
        return view('home.material_agua.videos.edit', compact('video', 'categories'));
    }

    public function actionVideosUpdate(Request $request, $id)
    {
        $video = TVideo::findOrFail($id);
        
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'youtube_url' => 'nullable|url',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv|max:102400',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'nullable|integer'
        ]);

        if ($request->hasFile('video_file')) {
            if ($video->video_path && file_exists(public_path($video->video_path))) {
                unlink(public_path($video->video_path));
            }
            
            $file = $request->file('video_file');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('material_agua/videos'), $filename);
            $data['video_path'] = 'material_agua/videos/' . $filename;
        }

        if ($request->hasFile('thumbnail')) {
            if ($video->thumbnail && file_exists(public_path('material_agua/videos/thumbnails/' . $video->thumbnail))) {
                unlink(public_path('material_agua/videos/thumbnails/' . $video->thumbnail));
            }
            
            $thumb = $request->file('thumbnail');
            $thumbName = time() . '_thumb.' . $thumb->getClientOriginalExtension();
            $thumb->move(public_path('material_agua/videos/thumbnails'), $thumbName);
            $data['thumbnail'] = $thumbName;
        }

        $data['status'] = $request->has('status');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $video->update($data);

        return redirect()->route('videos.index')->with('success', 'Video actualizado correctamente');
    }

    public function actionVideosDelete($id)
    {
        $video = TVideo::findOrFail($id);
        
        if ($video->video_path && file_exists(public_path($video->video_path))) {
            unlink(public_path($video->video_path));
        }
        
        if ($video->thumbnail && file_exists(public_path('material_agua/videos/thumbnails/' . $video->thumbnail))) {
            unlink(public_path('material_agua/videos/thumbnails/' . $video->thumbnail));
        }
        
        $video->delete();

        return response()->json(['success' => true, 'message' => 'Video eliminado correctamente']);
    }

    public function actionContenidoIndex(Request $request)
    {
        $query = TContent::orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');
        
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
        $categories = TContent::distinct('category')->whereNotNull('category')->pluck('category');
        
        return view('home.material_agua.contenido.index', compact('contents', 'categories'));
    }

    public function actionContenidoInsert(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'excerpt' => 'nullable|string|max:500',
                'content' => 'required|string',
                'category' => 'nullable|string|max:100',
                'subcategory' => 'nullable|string|max:100',
                'tags' => 'nullable|string',
                'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'sort_order' => 'nullable|integer',
                'published_at' => 'nullable|date'
            ]);

            $data['slug'] = Str::slug($request->title);
            
            if ($request->hasFile('featured_image')) {
                $file = $request->file('featured_image');
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('contenido/images', $filename, 'public');
                $data['featured_image'] = $filename;
            }

            $data['status'] = $request->has('status');
            $data['is_featured'] = $request->has('is_featured');
            $data['sort_order'] = $data['sort_order'] ?? 0;
            $data['published_at'] = $data['published_at'] ?? now();
            $data['created_by'] = Session::get('idUser');

            TContent::create($data);

            return redirect()->route('contenido.index')->with('success', 'Contenido agregado correctamente');
        }

        $categories = TContent::distinct('category')->whereNotNull('category')->pluck('category');
        
        return view('home.material_agua.contenido.insert', compact('categories'));
    }

    public function actionContenidoEdit($id)
    {
        $content = TContent::findOrFail($id);
        $categories = TContent::distinct('category')->whereNotNull('category')->pluck('category');
        
        return view('home.material_agua.contenido.edit', compact('content', 'categories'));
    }

    public function actionContenidoUpdate(Request $request, $id)
    {
        $content = TContent::findOrFail($id);
        
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category' => 'nullable|string|max:100',
            'subcategory' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'nullable|integer',
            'published_at' => 'nullable|date'
        ]);

        if ($request->title !== $content->title) {
            $data['slug'] = Str::slug($request->title);
        }

        if ($request->hasFile('featured_image')) {
            if ($content->featured_image && file_exists(public_path('material_agua/contenido/images/' . $content->featured_image))) {
                unlink(public_path('material_agua/contenido/images/' . $content->featured_image));
            }
            
            $file = $request->file('featured_image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('material_agua/contenido/images'), $filename);
            $data['featured_image'] = $filename;
        }

        $data['status'] = $request->has('status');
        $data['is_featured'] = $request->has('is_featured');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $content->update($data);

        return redirect()->route('contenido.index')->with('success', 'Contenido actualizado correctamente');
    }

    public function actionContenidoDelete($id)
    {
        $content = TContent::findOrFail($id);
        
        if ($content->featured_image && file_exists(public_path('material_agua/contenido/images/' . $content->featured_image))) {
            unlink(public_path('material_agua/contenido/images/' . $content->featured_image));
        }
        
        $content->delete();

        return response()->json(['success' => true, 'message' => 'Contenido eliminado correctamente']);
    }

    public function actionContenidoToggleStatus($id)
    {
        $content = TContent::findOrFail($id);
        $content->status = !$content->status;
        $content->save();

        return response()->json([
            'success' => true, 
            'status' => $content->status,
            'message' => $content->status ? 'Contenido activado' : 'Contenido desactivado'
        ]);
    }

    public function actionContenidoToggleFeatured($id)
    {
        $content = TContent::findOrFail($id);
        $content->is_featured = !$content->is_featured;
        $content->save();

        return response()->json([
            'success' => true, 
            'is_featured' => $content->is_featured,
            'message' => $content->is_featured ? 'Marcado como destacado' : 'Removido de destacados'
        ]);
    }
}
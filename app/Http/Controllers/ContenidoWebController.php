<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\TVideo;
use App\Models\TContent;

class ContenidoWebController extends Controller
{
    // ============= GESTIÓN DE VIDEOS =============
    
    public function actionVideosIndex(Request $request)
    {
        $query = TVideo::with('creator')->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');
        
        // Filtros
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        
        $videos = $query->paginate(15);
        $categories = TVideo::distinct('category')->pluck('category')->filter();
        
        return view('contenidoweb.videos.index', compact('videos', 'categories'));
    }

    public function actionVideosInsert(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'video_url' => 'required|url',
                'video_type' => 'required|in:youtube,vimeo,local',
                'category' => 'nullable|string|max:50',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $data = $request->only([
                'title', 'description', 'video_url', 'video_type',
                'category', 'tags', 'is_featured', 'sort_order'
            ]);
            
            // Manejar thumbnail
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('videos/thumbnails', $filename, 'public');
                $data['thumbnail'] = $filename;
            }
            
            $data['status'] = $request->has('status');
            $data['is_featured'] = $request->has('is_featured');
            $data['published_at'] = $request->published_at ? $request->published_at : now();
            $data['created_by'] = Session::get('idUser');

            TVideo::create($data);

            return redirect()->route('contenidoweb.videos')->with('success', 'Video agregado correctamente');
        }

        return view('contenidoweb.videos.insert');
    }

    // ============= GESTIÓN DE CONTENIDO =============
    
    public function actionContenidoIndex(Request $request)
    {
        $query = TContent::with('creator')->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');
        
        // Filtros
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
        $categories = TContent::distinct('category')->pluck('category')->filter();
        
        return view('contenidoweb.contenido.index', compact('contents', 'categories'));
    }

    public function actionContenidoInsert(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'title' => 'required|string|max:255',
                'excerpt' => 'nullable|string|max:500',
                'content' => 'required|string',
                'category' => 'nullable|string|max:50',
                'subcategory' => 'nullable|string|max:50',
                'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $data = $request->only([
                'title', 'excerpt', 'content', 'category', 'subcategory',
                'tags', 'meta_title', 'meta_description', 'meta_keywords',
                'sort_order'
            ]);
            
            // Crear slug
            $data['slug'] = Str::slug($request->title);
            
            // Manejar imagen destacada
            if ($request->hasFile('featured_image')) {
                $file = $request->file('featured_image');
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('content/images', $filename, 'public');
                $data['featured_image'] = $filename;
            }
            
            $data['status'] = $request->has('status');
            $data['is_featured'] = $request->has('is_featured');
            $data['published_at'] = $request->published_at ? $request->published_at : now();
            $data['created_by'] = Session::get('idUser');

            TContent::create($data);

            return redirect()->route('contenidoweb.contenido')->with('success', 'Contenido agregado correctamente');
        }

        return view('contenidoweb.contenido.insert');
    }
}
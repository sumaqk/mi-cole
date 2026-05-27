<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContenidoController extends Controller
{
    // ─── PÚBLICOS ────────────────────────────────────────────────────────────

    public function contents(Request $request)
    {
        $contents = DB::table('tcontent')
            ->where('status', 1)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('published_at')
            ->get();

        $grouped = $contents->groupBy('category')->map(fn($items, $category) => [
            'category' => $category,
            'items'    => $items->values(),
        ])->values();

        return response()->json(['success' => true, 'data' => $grouped]);
    }

    public function contentDetail($id)
    {
        $content = DB::table('tcontent')->where('id', $id)->first();

        if (!$content) {
            return response()->json(['success' => false, 'message' => 'No encontrado.'], 404);
        }

        DB::table('tcontent')->where('id', $id)->increment('views_count');

        return response()->json(['success' => true, 'data' => $content]);
    }

    public function videos(Request $request)
    {
        $videos = DB::table('tvideo')
            ->where('status', 1)
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        $grouped = $videos->groupBy('category')->map(fn($items, $category) => [
            'category' => $category,
            'items'    => $items->values(),
        ])->values();

        return response()->json(['success' => true, 'data' => $grouped]);
    }

    // ─── ADMIN CATEGORÍAS ────────────────────────────────────────────────────

    public function adminCategories()
    {
        $fromContents = DB::table('tcontent')
            ->whereNotNull('category')->where('category', '!=', '')
            ->pluck('category');

        $fromVideos = DB::table('tvideo')
            ->whereNotNull('category')->where('category', '!=', '')
            ->pluck('category');

        $categories = $fromContents->merge($fromVideos)->unique()->sort()->values();

        return response()->json(['success' => true, 'data' => $categories]);
    }

    // ─── ADMIN CONTENIDO ─────────────────────────────────────────────────────

    public function adminContentsIndex(Request $request)
    {
        $perPage  = $request->get('per_page', 20);
        $search   = $request->get('search', '');
        $category = $request->get('category', '');

        $query = DB::table('tcontent')->orderByDesc('sort_order')->orderByDesc('published_at');

        if ($search)   $query->where('title', 'LIKE', "%{$search}%");
        if ($category) $query->where('category', $category);

        $contents = $query->paginate($perPage);

        return response()->json(['success' => true, 'data' => $contents]);
    }

    public function adminContentsStore(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'category'     => 'required|string|max:100',
            'excerpt'      => 'nullable|string|max:500',
            'content'      => 'nullable|string',
            'content_file' => 'nullable|file|mimes:pdf,mp3,wav,doc,docx,txt|max:102400',
            'thumbnail'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'sort_order'   => 'nullable|integer',
            'published_at' => 'nullable|date',
        ]);

        $data = [
            'title'        => trim($request->title),
            'category'     => trim($request->category),
            'excerpt'      => $request->excerpt,
            'content'      => $request->content,
            'slug'         => Str::slug($request->title),
            'status'       => $request->boolean('status') ? 1 : 0,
            'is_featured'  => $request->boolean('is_featured') ? 1 : 0,
            'sort_order'   => $request->get('sort_order', 0),
            'published_at' => $request->get('published_at', now()),
            'views_count'  => 0,
            'created_at'   => now(),
            'updated_at'   => now(),
        ];

        if ($request->hasFile('content_file')) {
            $file     = $request->file('content_file');
            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            Storage::disk('archivos')->makeDirectory('contenido/files');
            $file->storeAs('contenido/files', $filename, 'archivos');
            $data['content_file'] = $filename;
            $data['file_type']    = $file->getClientOriginalExtension();
            $data['mime_type']    = $file->getMimeType();
            $data['file_size']    = $file->getSize();
        }

        if ($request->hasFile('thumbnail')) {
            $thumb     = $request->file('thumbnail');
            $thumbName = time() . '_thumb_' . Str::random(5) . '.' . $thumb->getClientOriginalExtension();
            Storage::disk('archivos')->makeDirectory('contenido/images');
            $thumb->storeAs('contenido/images', $thumbName, 'archivos');
            $data['thumbnail'] = $thumbName;
        }

        $id = DB::table('tcontent')->insertGetId($data);

        return response()->json(['success' => true, 'data' => DB::table('tcontent')->find($id)], 201);
    }

    public function adminContentsUpdate(Request $request, $id)
    {
        $content = DB::table('tcontent')->find($id);
        if (!$content) return response()->json(['success' => false, 'message' => 'No encontrado.'], 404);

        $request->validate([
            'title'        => 'required|string|max:255',
            'category'     => 'required|string|max:100',
            'excerpt'      => 'nullable|string|max:500',
            'content'      => 'nullable|string',
            'content_file' => 'nullable|file|mimes:pdf,mp3,wav,doc,docx,txt|max:102400',
            'thumbnail'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data = [
            'title'        => trim($request->title),
            'category'     => trim($request->category),
            'excerpt'      => $request->excerpt,
            'content'      => $request->content,
            'status'       => $request->boolean('status') ? 1 : 0,
            'is_featured'  => $request->boolean('is_featured') ? 1 : 0,
            'sort_order'   => $request->get('sort_order', $content->sort_order ?? 0),
            'published_at' => $request->get('published_at', $content->published_at),
            'updated_at'   => now(),
        ];

        if ($request->hasFile('content_file')) {
            if ($content->content_file) Storage::disk('archivos')->delete('contenido/files/' . $content->content_file);
            $file     = $request->file('content_file');
            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('contenido/files', $filename, 'archivos');
            $data['content_file'] = $filename;
            $data['file_type']    = $file->getClientOriginalExtension();
            $data['mime_type']    = $file->getMimeType();
            $data['file_size']    = $file->getSize();
        }

        if ($request->hasFile('thumbnail')) {
            if ($content->thumbnail) Storage::disk('archivos')->delete('contenido/images/' . $content->thumbnail);
            $thumb     = $request->file('thumbnail');
            $thumbName = time() . '_thumb_' . Str::random(5) . '.' . $thumb->getClientOriginalExtension();
            $thumb->storeAs('contenido/images', $thumbName, 'archivos');
            $data['thumbnail'] = $thumbName;
        }

        DB::table('tcontent')->where('id', $id)->update($data);

        return response()->json(['success' => true, 'data' => DB::table('tcontent')->find($id)]);
    }

    public function adminContentsDelete($id)
    {
        $content = DB::table('tcontent')->find($id);
        if (!$content) return response()->json(['success' => false, 'message' => 'No encontrado.'], 404);

        if ($content->content_file) Storage::disk('archivos')->delete('contenido/files/' . $content->content_file);
        if ($content->thumbnail)    Storage::disk('archivos')->delete('contenido/images/' . $content->thumbnail);

        DB::table('tcontent')->where('id', $id)->delete();

        return response()->json(['success' => true, 'message' => 'Eliminado.']);
    }

    public function adminContentsToggleStatus($id)
    {
        $content = DB::table('tcontent')->find($id);
        if (!$content) return response()->json(['success' => false, 'message' => 'No encontrado.'], 404);

        $new = $content->status ? 0 : 1;
        DB::table('tcontent')->where('id', $id)->update(['status' => $new, 'updated_at' => now()]);

        return response()->json(['success' => true, 'data' => ['status' => $new]]);
    }

    // ─── ADMIN VIDEOS ────────────────────────────────────────────────────────

    public function adminVideosIndex(Request $request)
    {
        $perPage  = $request->get('per_page', 20);
        $search   = $request->get('search', '');
        $category = $request->get('category', '');

        $query = DB::table('tvideo')->orderBy('sort_order')->orderByDesc('id');

        if ($search)   $query->where('title', 'LIKE', "%{$search}%");
        if ($category) $query->where('category', $category);

        $videos = $query->paginate($perPage);

        return response()->json(['success' => true, 'data' => $videos]);
    }

    public function adminVideosStore(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|string|max:100',
            'description' => 'nullable|string',
            'youtube_url' => 'nullable|url|max:500',
            'video_file'  => 'nullable|file|mimes:mp4,webm,avi,mov|max:512000',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'sort_order'  => 'nullable|integer',
        ]);

        $data = [
            'title'       => trim($request->title),
            'category'    => trim($request->category),
            'description' => $request->description,
            'youtube_url' => $request->youtube_url ? trim($request->youtube_url) : null,
            'status'      => $request->boolean('status') ? 1 : 0,
            'sort_order'  => $request->get('sort_order', 0),
            'created_at'  => now(),
            'updated_at'  => now(),
        ];

        if ($request->hasFile('video_file')) {
            $file     = $request->file('video_file');
            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            Storage::disk('archivos')->makeDirectory('videos');
            $file->storeAs('videos', $filename, 'archivos');
            $data['video_file'] = $filename;
            $data['file_type']  = $file->getClientOriginalExtension();
            $data['mime_type']  = $file->getMimeType();
            $data['file_size']  = $file->getSize();
        }

        if ($request->hasFile('thumbnail')) {
            $thumb     = $request->file('thumbnail');
            $thumbName = time() . '_thumb_' . Str::random(5) . '.' . $thumb->getClientOriginalExtension();
            Storage::disk('archivos')->makeDirectory('videos/thumbnails');
            $thumb->storeAs('videos/thumbnails', $thumbName, 'archivos');
            $data['thumbnail'] = $thumbName;
        }

        $id = DB::table('tvideo')->insertGetId($data);

        return response()->json(['success' => true, 'data' => DB::table('tvideo')->find($id)], 201);
    }

    public function adminVideosUpdate(Request $request, $id)
    {
        $video = DB::table('tvideo')->find($id);
        if (!$video) return response()->json(['success' => false, 'message' => 'No encontrado.'], 404);

        $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|string|max:100',
            'description' => 'nullable|string',
            'youtube_url' => 'nullable|url|max:500',
            'video_file'  => 'nullable|file|mimes:mp4,webm,avi,mov|max:512000',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data = [
            'title'       => trim($request->title),
            'category'    => trim($request->category),
            'description' => $request->description,
            'youtube_url' => $request->youtube_url ? trim($request->youtube_url) : $video->youtube_url,
            'status'      => $request->boolean('status') ? 1 : 0,
            'sort_order'  => $request->get('sort_order', $video->sort_order ?? 0),
            'updated_at'  => now(),
        ];

        if ($request->hasFile('video_file')) {
            if ($video->video_file) Storage::disk('archivos')->delete('videos/' . $video->video_file);
            $file     = $request->file('video_file');
            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('videos', $filename, 'archivos');
            $data['video_file'] = $filename;
            $data['file_type']  = $file->getClientOriginalExtension();
            $data['mime_type']  = $file->getMimeType();
            $data['file_size']  = $file->getSize();
        }

        if ($request->hasFile('thumbnail')) {
            if ($video->thumbnail) Storage::disk('archivos')->delete('videos/thumbnails/' . $video->thumbnail);
            $thumb     = $request->file('thumbnail');
            $thumbName = time() . '_thumb_' . Str::random(5) . '.' . $thumb->getClientOriginalExtension();
            $thumb->storeAs('videos/thumbnails', $thumbName, 'archivos');
            $data['thumbnail'] = $thumbName;
        }

        DB::table('tvideo')->where('id', $id)->update($data);

        return response()->json(['success' => true, 'data' => DB::table('tvideo')->find($id)]);
    }

    public function adminVideosDelete($id)
    {
        $video = DB::table('tvideo')->find($id);
        if (!$video) return response()->json(['success' => false, 'message' => 'No encontrado.'], 404);

        if ($video->video_file) Storage::disk('archivos')->delete('videos/' . $video->video_file);
        if ($video->thumbnail)  Storage::disk('archivos')->delete('videos/thumbnails/' . $video->thumbnail);

        DB::table('tvideo')->where('id', $id)->delete();

        return response()->json(['success' => true, 'message' => 'Eliminado.']);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ContenidoController extends Controller
{
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
            ->get();

        $grouped = $contents->groupBy('category')->map(fn($items, $category) => [
            'category' => $category,
            'items'    => $items,
        ])->values();

        return response()->json(['success' => true, 'data' => $grouped]);
    }

    public function contentDetail($id)
    {
        $content = DB::table('tcontent')->where('id', $id)->first();

        if (!$content) {
            return response()->json(['success' => false, 'message' => 'No encontrado.'], 404);
        }

        return response()->json(['success' => true, 'data' => $content]);
    }

    public function videos(Request $request)
    {
        $videos = DB::table('tvideo')
            ->where('status', 1)
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->orderBy('sort_order')
            ->get();

        $grouped = $videos->groupBy('category')->map(fn($items, $category) => [
            'category' => $category,
            'items'    => $items,
        ])->values();

        return response()->json(['success' => true, 'data' => $grouped]);
    }

    public function adminContentsIndex(Request $request)
    {
        $perPage   = $request->get('per_page', 15);
        $search    = $request->get('search', '');
        $contents  = DB::table('tcontent')
            ->where('title', 'LIKE', '%' . $search . '%')
            ->orderByDesc('sort_order')
            ->paginate($perPage);

        return response()->json(['success' => true, 'data' => $contents]);
    }

    public function adminContentsStore(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'category' => 'required|string|max:100',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $file     = $request->file('file');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('archivos'), $filename);
            $filePath = 'archivos/' . $filename;
        }

        $id = DB::table('tcontent')->insertGetId([
            'title'        => trim($request->title),
            'category'     => trim($request->category),
            'description'  => $request->description ?? null,
            'file_path'    => $filePath,
            'status'       => $request->get('status', 1),
            'is_featured'  => $request->get('is_featured', 0),
            'sort_order'   => $request->get('sort_order', 0),
            'published_at' => $request->get('published_at', now()),
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return response()->json(['success' => true, 'data' => DB::table('tcontent')->find($id)], 201);
    }

    public function adminContentsUpdate(Request $request, $id)
    {
        $content = DB::table('tcontent')->find($id);

        if (!$content) {
            return response()->json(['success' => false, 'message' => 'No encontrado.'], 404);
        }

        $request->validate([
            'title'    => 'required|string|max:255',
            'category' => 'required|string|max:100',
        ]);

        $filePath = $content->file_path;
        if ($request->hasFile('file')) {
            $file     = $request->file('file');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('archivos'), $filename);
            $filePath = 'archivos/' . $filename;
        }

        DB::table('tcontent')->where('id', $id)->update([
            'title'        => trim($request->title),
            'category'     => trim($request->category),
            'description'  => $request->description ?? $content->description,
            'file_path'    => $filePath,
            'status'       => $request->get('status', $content->status),
            'is_featured'  => $request->get('is_featured', $content->is_featured),
            'sort_order'   => $request->get('sort_order', $content->sort_order),
            'published_at' => $request->get('published_at', $content->published_at),
            'updated_at'   => now(),
        ]);

        return response()->json(['success' => true, 'data' => DB::table('tcontent')->find($id)]);
    }

    public function adminContentsDelete($id)
    {
        $content = DB::table('tcontent')->find($id);

        if (!$content) {
            return response()->json(['success' => false, 'message' => 'No encontrado.'], 404);
        }

        DB::table('tcontent')->delete($id);

        return response()->json(['success' => true, 'message' => 'Eliminado.']);
    }

    public function adminContentsToggleStatus($id)
    {
        $content = DB::table('tcontent')->find($id);

        if (!$content) {
            return response()->json(['success' => false, 'message' => 'No encontrado.'], 404);
        }

        $newStatus = $content->status ? 0 : 1;
        DB::table('tcontent')->where('id', $id)->update(['status' => $newStatus, 'updated_at' => now()]);

        return response()->json(['success' => true, 'data' => ['status' => $newStatus]]);
    }

    public function adminVideosIndex(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $search  = $request->get('search', '');
        $videos  = DB::table('tvideo')
            ->where('title', 'LIKE', '%' . $search . '%')
            ->orderBy('sort_order')
            ->paginate($perPage);

        return response()->json(['success' => true, 'data' => $videos]);
    }

    public function adminVideosStore(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'url'      => 'required|string|max:500',
            'category' => 'required|string|max:100',
        ]);

        $id = DB::table('tvideo')->insertGetId([
            'title'      => trim($request->title),
            'url'        => trim($request->url),
            'category'   => trim($request->category),
            'status'     => $request->get('status', 1),
            'sort_order' => $request->get('sort_order', 0),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true, 'data' => DB::table('tvideo')->find($id)], 201);
    }

    public function adminVideosUpdate(Request $request, $id)
    {
        $video = DB::table('tvideo')->find($id);

        if (!$video) {
            return response()->json(['success' => false, 'message' => 'No encontrado.'], 404);
        }

        $request->validate([
            'title'    => 'required|string|max:255',
            'url'      => 'required|string|max:500',
            'category' => 'required|string|max:100',
        ]);

        DB::table('tvideo')->where('id', $id)->update([
            'title'      => trim($request->title),
            'url'        => trim($request->url),
            'category'   => trim($request->category),
            'status'     => $request->get('status', $video->status),
            'sort_order' => $request->get('sort_order', $video->sort_order),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true, 'data' => DB::table('tvideo')->find($id)]);
    }

    public function adminVideosDelete($id)
    {
        $video = DB::table('tvideo')->find($id);

        if (!$video) {
            return response()->json(['success' => false, 'message' => 'No encontrado.'], 404);
        }

        DB::table('tvideo')->delete($id);

        return response()->json(['success' => true, 'message' => 'Eliminado.']);
    }
}

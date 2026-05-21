<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TDistrict;
use App\Models\TProvince;
use App\Models\TUgel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UgelController extends Controller
{
    public function index(Request $request)
    {
        $search  = $request->get('search', '');
        $perPage = $request->get('per_page', 15);

        $ugels = TUgel::with(['tProvince', 'tDistrict'])
            ->withCount('tInstitution as institution_count')
            ->where('name', 'LIKE', '%' . $search . '%')
            ->orderByDesc('created_at')
            ->paginate($perPage);

        return response()->json(['success' => true, 'data' => $ugels]);
    }

    public function show($id)
    {
        $ugel = TUgel::with(['tProvince', 'tDistrict'])->find($id);

        if (!$ugel) {
            return response()->json(['success' => false, 'message' => 'UGEL no encontrada.'], 404);
        }

        return response()->json(['success' => true, 'data' => $ugel]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'idProvince' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $ugel             = new TUgel();
            $ugel->idUgel     = uniqid();
            $ugel->name       = trim($request->name);
            $ugel->code       = $request->code ?? null;
            $ugel->idProvince = $request->idProvince;
            $ugel->idDistrict = $request->idDistrict ?? null;
            $ugel->address    = $request->address ?? null;
            $ugel->phone      = $request->phone ?? null;
            $ugel->email      = $request->email ?? null;
            $ugel->director   = $request->director ?? null;
            $ugel->is_active  = true;
            $ugel->save();

            DB::commit();

            return response()->json(['success' => true, 'data' => $ugel], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $ugel = TUgel::find($id);

        if (!$ugel) {
            return response()->json(['success' => false, 'message' => 'UGEL no encontrada.'], 404);
        }

        $request->validate([
            'name'       => 'required|string|max:255',
            'idProvince' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $ugel->name       = trim($request->name);
            $ugel->code       = $request->code ?? $ugel->code;
            $ugel->idProvince = $request->idProvince;
            $ugel->idDistrict = $request->idDistrict ?? $ugel->idDistrict;
            $ugel->address    = $request->address ?? $ugel->address;
            $ugel->phone      = $request->phone ?? $ugel->phone;
            $ugel->email      = $request->email ?? $ugel->email;
            $ugel->director   = $request->director ?? $ugel->director;
            $ugel->save();

            DB::commit();

            return response()->json(['success' => true, 'data' => $ugel]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $ugel = TUgel::find($id);

        if (!$ugel) {
            return response()->json(['success' => false, 'message' => 'UGEL no encontrada.'], 404);
        }

        if ($ugel->tInstitution()->count() > 0) {
            return response()->json(['success' => false, 'message' => 'Tiene instituciones asociadas, no se puede eliminar.'], 409);
        }

        try {
            DB::beginTransaction();
            $ugel->delete();
            DB::commit();

            return response()->json(['success' => true, 'message' => 'UGEL eliminada.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function toggleStatus($id)
    {
        $ugel = TUgel::find($id);

        if (!$ugel) {
            return response()->json(['success' => false, 'message' => 'UGEL no encontrada.'], 404);
        }

        $ugel->is_active = !$ugel->is_active;
        $ugel->save();

        return response()->json(['success' => true, 'data' => ['is_active' => $ugel->is_active]]);
    }

    public function districts(Request $request, $idProvince)
    {
        $districts = TDistrict::where('idProvince', $idProvince)->orderBy('name')->get(['idDistrict', 'name']);

        return response()->json(['success' => true, 'data' => $districts]);
    }
}

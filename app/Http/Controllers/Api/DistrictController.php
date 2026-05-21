<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TDistrict;
use App\Models\TProvince;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index(Request $request)
    {
        $search  = $request->get('search', '');
        $perPage = $request->get('per_page', 200);

        $districts = TDistrict::with('tprovince')
            ->withCount('tInstitution as institution_count')
            ->where('name', 'LIKE', '%' . $search . '%')
            ->orderBy('name')
            ->paginate($perPage);

        return response()->json(['success' => true, 'data' => $districts]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'idProvince' => 'required|string',
        ]);

        try {
            $district             = new TDistrict();
            $district->idDistrict = uniqid();
            $district->name       = trim($request->name);
            $district->idProvince = $request->idProvince;
            $district->save();

            $district->load('tprovince');

            return response()->json(['success' => true, 'data' => $district], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $district = TDistrict::find($id);
        if (!$district) {
            return response()->json(['success' => false, 'message' => 'Distrito no encontrado.'], 404);
        }

        $request->validate([
            'name'       => 'required|string|max:255',
            'idProvince' => 'required|string',
        ]);

        try {
            $district->name       = trim($request->name);
            $district->idProvince = $request->idProvince;
            $district->save();

            return response()->json(['success' => true, 'data' => $district]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $district = TDistrict::find($id);
        if (!$district) {
            return response()->json(['success' => false, 'message' => 'Distrito no encontrado.'], 404);
        }

        if ($district->tInstitution()->count() > 0) {
            return response()->json(['success' => false, 'message' => 'Tiene instituciones asociadas, no se puede eliminar.'], 409);
        }

        try {
            $district->delete();
            return response()->json(['success' => true, 'message' => 'Distrito eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function byProvince($idProvince)
    {
        $districts = TDistrict::where('idProvince', $idProvince)
            ->orderBy('name')
            ->get(['idDistrict', 'name']);

        return response()->json(['success' => true, 'data' => $districts]);
    }

    public function provinces()
    {
        $provinces = TProvince::orderBy('name')->get(['idProvince', 'name']);

        return response()->json(['success' => true, 'data' => $provinces]);
    }
}

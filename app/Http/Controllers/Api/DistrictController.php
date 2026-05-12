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
        $perPage = $request->get('per_page', 15);

        $districts = TDistrict::with('tprovince')
            ->where('name', 'LIKE', '%' . $search . '%')
            ->orderBy('name')
            ->paginate($perPage);

        return response()->json(['success' => true, 'data' => $districts]);
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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TConfiguration;
use App\Models\TDistrict;
use App\Models\TInstitution;
use App\Models\TInstitutionTUser;
use App\Models\TProvince;
use App\Models\TUgel;
use App\Models\TWater;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstitutionController extends Controller
{
    private array $months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'];

    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $perPage = $request->get('per_page', 15);

        $institutions = TInstitution::with(['tdistrict.tprovince', 'tugel'])
            ->where('name', 'LIKE', '%' . $search . '%')
            ->orderByDesc('created_at')
            ->paginate($perPage);

        return response()->json(['success' => true, 'data' => $institutions]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'lender'     => 'required|string|max:255',
            'idDistrict' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $institution               = new TInstitution();
            $institution->idInstitution = uniqid();
            $institution->name         = trim($request->name);
            $institution->lender       = trim($request->lender);
            $institution->idDistrict   = $request->idDistrict;
            $institution->idUgel       = $request->idUgel ?: null;
            $institution->status       = 'Activo';
            $institution->save();

            DB::commit();

            return response()->json(['success' => true, 'data' => $institution], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $institution = TInstitution::with(['tdistrict.tprovince', 'tugel'])->find($id);

        if (!$institution) {
            return response()->json(['success' => false, 'message' => 'No encontrada.'], 404);
        }

        return response()->json(['success' => true, 'data' => $institution]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'lender'     => 'required|string|max:255',
            'idDistrict' => 'required|string',
        ]);

        $institution = TInstitution::find($id);

        if (!$institution) {
            return response()->json(['success' => false, 'message' => 'No encontrada.'], 404);
        }

        try {
            DB::beginTransaction();

            $institution->name       = trim($request->name);
            $institution->lender     = trim($request->lender);
            $institution->idDistrict = $request->idDistrict;
            $institution->idUgel     = $request->idUgel ?: null;
            $institution->latitude   = is_numeric($request->latitude) ? $request->latitude : null;
            $institution->longitude  = is_numeric($request->longitude) ? $request->longitude : null;
            $institution->save();

            DB::commit();

            return response()->json(['success' => true, 'data' => $institution]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $institution = TInstitution::find($id);

        if (!$institution) {
            return response()->json(['success' => false, 'message' => 'No encontrada.'], 404);
        }

        if ($institution->tinstitutiontuser()->count() > 0) {
            return response()->json(['success' => false, 'message' => 'Tiene usuarios asociados, no se puede eliminar.'], 409);
        }

        try {
            DB::beginTransaction();
            $institution->delete();
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Eliminada correctamente.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function toggleStatus($id)
    {
        $institution = TInstitution::find($id);

        if (!$institution) {
            return response()->json(['success' => false, 'message' => 'No encontrada.'], 404);
        }

        $institution->status = $institution->status === 'Activo' ? 'Inactivo' : 'Activo';
        $institution->save();

        return response()->json(['success' => true, 'data' => ['status' => $institution->status]]);
    }

    public function assignUsers(Request $request, $id)
    {
        $institution = TInstitution::find($id);

        if (!$institution) {
            return response()->json(['success' => false, 'message' => 'No encontrada.'], 404);
        }

        try {
            DB::beginTransaction();

            TInstitutionTUser::where('idInstitution', $id)->delete();

            if ($request->has('userIds') && is_array($request->userIds)) {
                foreach ($request->userIds as $idUser) {
                    if (empty(trim($idUser))) continue;

                    TInstitutionTUser::where('idUser', $idUser)->delete();

                    $rel                     = new TInstitutionTUser();
                    $rel->idInstitutionTUser = uniqid();
                    $rel->idUser             = $idUser;
                    $rel->idInstitution      = $id;
                    $rel->save();
                }
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Usuarios asignados correctamente.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function districts(Request $request)
    {
        $districts = TDistrict::where('idProvince', $request->idProvince)
            ->orderBy('name')
            ->get(['idDistrict', 'name']);

        return response()->json(['success' => true, 'data' => $districts]);
    }

    public function ugels()
    {
        $ugels = TUgel::where('is_active', true)->orderBy('name')->get(['idUgel', 'name']);

        return response()->json(['success' => true, 'data' => $ugels]);
    }

    public function provinces()
    {
        $provinces = TProvince::orderBy('name')->get(['idProvince', 'name']);

        return response()->json(['success' => true, 'data' => $provinces]);
    }

    public function publicStats()
    {
        $currentMonth = $this->months[intval(date('m')) - 1];
        $currentYear  = (int)date('Y');

        $totalInstitutions = TInstitution::where('status', 'Activo')->count();

        $institutionsThisMonth = TWater::whereYear('created_at', $currentYear)
            ->where('month', $currentMonth)
            ->count();

        $coveragePct = $totalInstitutions > 0
            ? round(($institutionsThisMonth / $totalInstitutions) * 100)
            : 0;

        $totalProvinces = DB::table('tinstitution')
            ->join('tdistrict', 'tinstitution.idDistrict', '=', 'tdistrict.idDistrict')
            ->where('tinstitution.status', 'Activo')
            ->distinct()
            ->count('tdistrict.idProvince');

        $totalUgels = DB::table('tugel')->where('is_active', true)->count();

        // Tendencia vs mes anterior
        $prevMonthIndex = intval(date('m')) - 2;
        $prevYear = $currentYear;
        if ($prevMonthIndex < 0) { $prevMonthIndex = 11; $prevYear--; }
        $prevMonth       = $this->months[$prevMonthIndex];
        $prevReported    = TWater::whereYear('created_at', $prevYear)->where('month', $prevMonth)->count();
        $prevCoveragePct = $totalInstitutions > 0 ? round(($prevReported / $totalInstitutions) * 100) : 0;
        $trendCoveragePct = $coveragePct - $prevCoveragePct;

        // Instituciones que nunca han reportado
        $reportedIds        = TWater::distinct()->pluck('idInstitution');
        $neverReportedCount = TInstitution::where('status', 'Activo')
            ->whereNotIn('idInstitution', $reportedIds)
            ->count();

        // UGEL con más registros este mes
        $topUgelRow = DB::table('twater')
            ->join('tinstitution', 'twater.idInstitution', '=', 'tinstitution.idInstitution')
            ->join('tugel', 'tinstitution.idUgel', '=', 'tugel.idUgel')
            ->whereYear('twater.created_at', $currentYear)
            ->where('twater.month', $currentMonth)
            ->select('tugel.name', DB::raw('COUNT(*) as total'))
            ->groupBy('tugel.idUgel', 'tugel.name')
            ->orderByDesc('total')
            ->first();
        $topUgel = $topUgelRow ? $topUgelRow->name : null;

        // Análisis de cloro por institución — 5 bandas DS 031-2010-SA
        $records = TWater::whereYear('created_at', $currentYear)
            ->where('month', $currentMonth)
            ->get(['resultW1', 'resultW2', 'resultW3', 'resultW4', 'resultW5']);

        $institutionAvgs = [];
        $criticalCount   = 0; // < 0.3
        $deficientCount  = 0; // 0.3 – 0.5
        $optimalCount    = 0; // 0.5 – 2.0
        $highCount       = 0; // 2.0 – 5.0
        $excessiveCount  = 0; // > 5.0

        foreach ($records as $r) {
            $vals = collect([$r->resultW1, $r->resultW2, $r->resultW3, $r->resultW4, $r->resultW5])
                ->filter(fn($v) => $v !== null && (float)$v >= 0)
                ->map(fn($v) => (float)$v);
            if ($vals->count() > 0) {
                $avg = $vals->average();
                $institutionAvgs[] = $avg;
                if ($avg < 0.3)      $criticalCount++;
                elseif ($avg < 0.5)  $deficientCount++;
                elseif ($avg <= 2.0) $optimalCount++;
                elseif ($avg <= 5.0) $highCount++;
                else                  $excessiveCount++;
            }
        }

        $totalWithData  = count($institutionAvgs);
        $avgChlorine    = $totalWithData > 0
            ? round(array_sum($institutionAvgs) / $totalWithData, 2)
            : null;
        $complianceRate = $totalWithData > 0
            ? round(($optimalCount / $totalWithData) * 100)
            : null;

        return response()->json([
            'success' => true,
            'data'    => [
                'total_institutions'      => $totalInstitutions,
                'institutions_this_month' => $institutionsThisMonth,
                'coverage_pct'            => $coveragePct,
                'total_provinces'         => $totalProvinces,
                'total_ugels'             => $totalUgels,
                'avg_chlorine'            => $avgChlorine,
                'critical_count'          => $criticalCount,
                'deficient_count'         => $deficientCount,
                'optimal_count'           => $optimalCount,
                'high_count'              => $highCount,
                'excessive_count'         => $excessiveCount,
                'compliance_rate'         => $complianceRate,
                'never_reported_count'    => $neverReportedCount,
                'trend_coverage_pct'      => $trendCoveragePct,
                'top_ugel'                => $topUgel,
            ],
        ]);
    }

    public function publicMapData(Request $request)
    {
        $mapData = $this->buildMapData(
            $request->get('month'),
            $request->get('year'),
            $request->get('week')
        );

        return response()->json(['success' => true, 'data' => $mapData]);
    }

    public function publicInstitutions(Request $request)
    {
        $groupBy = $request->get('group_by', 'ugel');

        if ($groupBy === 'district') {
            $result = TDistrict::with(['tInstitution' => fn($q) => $q->where('status', 'Activo')->with('tUgel'), 'tProvince'])
                ->whereHas('tInstitution', fn($q) => $q->where('status', 'Activo'))
                ->orderBy('name')
                ->get();
        } elseif ($groupBy === 'province') {
            $result = TProvince::with(['tDistrict.tInstitution' => fn($q) => $q->where('status', 'Activo')->with('tUgel')])
                ->whereHas('tDistrict.tInstitution', fn($q) => $q->where('status', 'Activo'))
                ->orderBy('name')
                ->get();
        } else {
            $result = TUgel::with(['tInstitution' => fn($q) => $q->where('status', 'Activo')->with('tDistrict.tProvince'), 'tProvince', 'tDistrict'])
                ->where('is_active', true)
                ->orderBy('name')
                ->get();
        }

        return response()->json([
            'success'           => true,
            'groupBy'           => $groupBy,
            'data'              => $result,
            'totalInstitutions' => TInstitution::where('status', 'Activo')->count(),
        ]);
    }

    private function buildMapData($monthParam = null, $yearParam = null, $weekParam = null): array
    {
        $monthName = $monthParam ? $this->months[(int)$monthParam - 1] : $this->months[(int)date('m') - 1];
        $year      = $yearParam ? (int)$yearParam : (int)date('Y');

        if (!$weekParam) {
            $today   = date('Y-m-d');
            $firstOM = date('Y-m-01', strtotime($today));
            $week    = max(1, min(5, (int)date('W', strtotime($today)) - (int)date('W', strtotime($firstOM)) + 1));
        } else {
            $week = (int)$weekParam;
        }

        $institutions = TInstitution::with(['tdistrict.tprovince', 'tugel'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where('status', 'Activo')
            ->get();

        $mapData = [];
        foreach ($institutions as $inst) {
            $waterData = TWater::where('idInstitution', $inst->idInstitution)
                ->where('month', $monthName)
                ->whereYear('created_at', $year)
                ->orderByDesc('updated_at')
                ->first();

            $weekValue = 0;
            $hasData   = false;

            if ($waterData) {
                $field = "resultW{$week}";
                if (isset($waterData->$field) && $waterData->$field != -1) {
                    $weekValue = (float)$waterData->$field;
                    $hasData   = true;
                }
            }

            [$color, $status, $description] = $this->chlorineStatus($weekValue, $hasData, $week);

            $mapData[] = [
                'name'        => $inst->name,
                'lat'         => (float)$inst->latitude,
                'lng'         => (float)$inst->longitude,
                'ugel'        => $inst->tugel->name ?? 'Sin UGEL',
                'lender'      => $inst->lender,
                'district'    => $inst->tdistrict->name ?? '',
                'province'    => $inst->tdistrict->tprovince->name ?? '',
                'week'        => $week,
                'weekValue'   => $weekValue,
                'color'       => $color,
                'status'      => $status,
                'description' => $description,
            ];
        }

        return $mapData;
    }

    private function chlorineStatus(float $value, bool $hasData, int $week): array
    {
        if (!$hasData || $value <= 0) {
            return ['#808080', 'Sin datos', "No hay registros de la semana {$week}"];
        }
        if ($value < 0.3)  return ['#FF0000', 'Crítico',    'Riesgo microbiológico muy alto'];
        if ($value < 0.5)  return ['#FF8C00', 'Deficiente', 'Requiere acciones correctivas'];
        if ($value <= 2.0) return ['#00FF00', 'Óptimo',     'Cumple normativa peruana'];
        if ($value <= 5.0) return ['#0000FF', 'Alto',       'Monitorear sabor/olor'];
        return ['#800080', 'Excesivo', 'Incumple DS 031-2010-SA'];
    }
}

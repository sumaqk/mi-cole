<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TInstitution;
use App\Models\TUgel;
use App\Models\TUser;
use App\Models\TWater;
use App\Export\NonReportingExport;
use App\Export\WithReportingExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    private array $months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'];

    public function index(Request $request)
    {
        $selectedMonth = $request->get('month', (int)date('m'));
        $selectedYear  = $request->get('year', (int)date('Y'));
        $selectedWeek  = $request->get('week');

        $monthName = $this->months[(int)$selectedMonth - 1];
        $year      = (int)$selectedYear;

        if (!$selectedWeek) {
            $today   = date('Y-m-d');
            $firstOM = date('Y-m-01', strtotime($today));
            $week    = max(1, min(5, (int)date('W', strtotime($today)) - (int)date('W', strtotime($firstOM)) + 1));
        } else {
            $week = (int)$selectedWeek;
        }

        $tUser        = $request->user();
        $userRole     = $tUser->role ?? null;
        $userLevel    = $tUser->level ?? null;
        $userProvince = $tUser->idProvince ?? null;
        $userDistrict = $tUser->idDistrict ?? null;

        $q = DB::table('twater')
            ->select([
                'tinstitution.idInstitution as id',
                'tinstitution.name as nombre',
                'tinstitution.lender as prestador',
                'tugel.name as ugel',
                'tdistrict.name as distrito',
                'tprovince.name as provincia',
                'twater.month as mes',
                'twater.resultW1', 'twater.resultW2', 'twater.resultW3', 'twater.resultW4', 'twater.resultW5',
                'twater.created_at', 'twater.updated_at',
                DB::raw('(SELECT MAX(s.updated_at) FROM twater s WHERE s.idInstitution = tinstitution.idInstitution AND (s.resultW1 > 0 OR s.resultW2 > 0 OR s.resultW3 > 0 OR s.resultW4 > 0 OR s.resultW5 > 0)) as last_reported_at'),
            ])
            ->join('tinstitution', 'twater.idInstitution', '=', 'tinstitution.idInstitution')
            ->leftJoin('tugel', 'tinstitution.idUgel', '=', 'tugel.idUgel')
            ->join('tdistrict', 'tinstitution.idDistrict', '=', 'tdistrict.idDistrict')
            ->join('tprovince', 'tdistrict.idProvince', '=', 'tprovince.idProvince')
            ->where('twater.month', $monthName)
            ->whereYear('twater.created_at', $year)
            ->whereRaw('twater.updated_at = (SELECT MAX(s.updated_at) FROM twater s WHERE s.idInstitution = twater.idInstitution)');

        $this->applyRoleFilters($q, $userRole, $userLevel, $userProvince, $userDistrict, $tUser->blockingReason ?? null);

        $listTWater = $q->orderByDesc('twater.updated_at')->get();

        if ($listTWater->isEmpty()) {
            $prev      = now()->subMonth();
            $prevMonth = $this->months[(int)$prev->format('m') - 1];
            $prevYear  = (int)$prev->format('Y');

            $q2 = DB::table('twater')
                ->select([
                    'tinstitution.idInstitution as id',
                    'tinstitution.name as nombre',
                    'tinstitution.lender as prestador',
                    'tugel.name as ugel',
                    'tdistrict.name as distrito',
                    'tprovince.name as provincia',
                    'twater.month as mes',
                    'twater.resultW1', 'twater.resultW2', 'twater.resultW3', 'twater.resultW4', 'twater.resultW5',
                    'twater.created_at', 'twater.updated_at',
                    DB::raw('(SELECT MAX(s.updated_at) FROM twater s WHERE s.idInstitution = tinstitution.idInstitution AND (s.resultW1 > 0 OR s.resultW2 > 0 OR s.resultW3 > 0 OR s.resultW4 > 0 OR s.resultW5 > 0)) as last_reported_at'),
                ])
                ->join('tinstitution', 'twater.idInstitution', '=', 'tinstitution.idInstitution')
                ->leftJoin('tugel', 'tinstitution.idUgel', '=', 'tugel.idUgel')
                ->join('tdistrict', 'tinstitution.idDistrict', '=', 'tdistrict.idDistrict')
                ->join('tprovince', 'tdistrict.idProvince', '=', 'tprovince.idProvince')
                ->where('twater.month', $prevMonth)
                ->whereYear('twater.created_at', $prevYear)
                ->whereRaw('twater.updated_at = (SELECT MAX(s.updated_at) FROM twater s WHERE s.idInstitution = twater.idInstitution)');

            $this->applyRoleFilters($q2, $userRole, $userLevel, $userProvince, $userDistrict, $tUser->blockingReason ?? null);

            $listTWater = $q2->orderByDesc('twater.updated_at')->get();
        }

        $mapData = $this->buildMapData($monthName, $year, $week, $userRole, $userLevel, $userProvince, $userDistrict, $tUser->blockingReason ?? null);

        return response()->json([
            'success' => true,
            'data'    => [
                'waterRecords' => $listTWater,
                'mapData'      => $mapData,
                'meta'         => [
                    'month' => $monthName,
                    'year'  => $year,
                    'week'  => $week,
                ],
            ],
        ]);
    }

    public function mapData(Request $request)
    {
        $tUser = $request->user();

        $month = $request->get('month', (int)date('m'));
        $year  = $request->get('year', (int)date('Y'));
        $week  = $request->get('week');

        $monthName = $this->months[(int)$month - 1];

        if (!$week) {
            $today   = date('Y-m-d');
            $firstOM = date('Y-m-01', strtotime($today));
            $week    = max(1, min(5, (int)date('W', strtotime($today)) - (int)date('W', strtotime($firstOM)) + 1));
        }

        $mapData = $this->buildMapData(
            $monthName,
            (int)$year,
            (int)$week,
            $tUser->role ?? null,
            $tUser->level ?? null,
            $tUser->idProvince ?? null,
            $tUser->idDistrict ?? null,
            $tUser->blockingReason ?? null
        );

        return response()->json(['success' => true, 'data' => $mapData]);
    }

    public function exportNonReporting(Request $request)
    {
        $scope     = $request->get('scope', 'month');
        $monthsEs  = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'];
        $monthName = $monthsEs[(int)$request->get('month', date('m')) - 1];
        $year      = (int)$request->get('year', date('Y'));
        $week      = (int)$request->get('week', max(1, min(5, (int)date('W') - (int)date('W', strtotime(date('Y-m-01'))) + 1)));

        $tUser        = $request->user();
        $userRole     = $tUser->role ?? null;
        $userLevel    = $tUser->level ?? null;
        $userProvince = $tUser->idProvince ?? null;
        $userDistrict = $tUser->idDistrict ?? null;

        $qInst = TInstitution::with(['tdistrict.tprovince', 'tugel']);
        if ($userRole === 'Supervisor' && $userLevel === 'levelProvince' && $userProvince) {
            $qInst->whereHas('tdistrict.tprovince', fn($q) => $q->where('idProvince', $userProvince));
        }
        if ($userRole === 'Supervisor' && in_array($userLevel, ['levelDistrict','levelDistrit']) && $userDistrict) {
            $qInst->whereHas('tdistrict', fn($q) => $q->where('idDistrict', $userDistrict));
        }
        $instituciones = $qInst->get();
        $ids    = $instituciones->pluck('idInstitution')->all();
        $waters = TWater::whereIn('idInstitution', $ids)
            ->where('month', $monthName)->whereYear('created_at', $year)
            ->orderBy('updated_at', 'desc')->get()
            ->unique('idInstitution')->keyBy('idInstitution');

        $rows = [];
        foreach ($instituciones as $inst) {
            $w         = $waters->get($inst->idInstitution);
            $sinMes    = true;
            $sinSemana = true;
            if ($w) {
                $reportadas = 0;
                for ($i = 1; $i <= 5; $i++) { $f = "resultW{$i}"; if (isset($w->$f) && $w->$f != -1) $reportadas++; }
                $sinMes    = ($reportadas === 0);
                $fw        = "resultW{$week}";
                $sinSemana = !isset($w->$fw) || $w->$fw == -1;
            }
            if (($scope === 'week') ? $sinSemana : $sinMes) {
                $rows[] = [
                    $inst->tugel->name ?? 'Sin UGEL', $inst->name, $inst->lender,
                    $inst->tdistrict->tprovince->name ?? '', $inst->tdistrict->name ?? '',
                    $year, $monthName,
                    $scope === 'week' ? $week : '-',
                    $scope === 'week' ? 'Sin reporte en semana actual' : 'Sin reportes en el mes',
                ];
            }
        }

        $title    = $scope === 'week' ? "Semana {$week} — {$monthName} {$year}" : "Mes actual — {$monthName} {$year}";
        $filename = $scope === 'week' ? "no_reportantes_semana_{$week}_{$monthName}_{$year}.xlsx" : "no_reportantes_mes_{$monthName}_{$year}.xlsx";

        return Excel::download(new NonReportingExport($rows, $title), $filename);
    }

    public function exportWithReporting(Request $request)
    {
        $scope     = $request->get('scope', 'month');
        $monthsEs  = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'];
        $monthName = $monthsEs[(int)$request->get('month', date('m')) - 1];
        $year      = (int)$request->get('year', date('Y'));
        $week      = (int)$request->get('week', max(1, min(5, (int)date('W') - (int)date('W', strtotime(date('Y-m-01'))) + 1)));

        $tUser        = $request->user();
        $userRole     = $tUser->role ?? null;
        $userLevel    = $tUser->level ?? null;
        $userProvince = $tUser->idProvince ?? null;
        $userDistrict = $tUser->idDistrict ?? null;

        $qInst = TInstitution::with(['tdistrict.tprovince', 'tugel']);
        if ($userRole === 'Supervisor' && $userLevel === 'levelProvince' && $userProvince) {
            $qInst->whereHas('tdistrict.tprovince', fn($q) => $q->where('idProvince', $userProvince));
        }
        if ($userRole === 'Supervisor' && in_array($userLevel, ['levelDistrict','levelDistrit']) && $userDistrict) {
            $qInst->whereHas('tdistrict', fn($q) => $q->where('idDistrict', $userDistrict));
        }
        $instituciones = $qInst->get();
        $ids    = $instituciones->pluck('idInstitution')->all();
        $waters = TWater::whereIn('idInstitution', $ids)
            ->where('month', $monthName)->whereYear('created_at', $year)
            ->orderBy('updated_at', 'desc')->get()
            ->unique('idInstitution')->keyBy('idInstitution');

        $rows = [];
        foreach ($instituciones as $inst) {
            $w = $waters->get($inst->idInstitution);
            if (!$w) continue;
            $reportadas = 0; $sumAll = 0; $countAll = 0;
            for ($i = 1; $i <= 5; $i++) { $f = "resultW{$i}"; if (isset($w->$f) && $w->$f != -1) { $reportadas++; $sumAll += $w->$f; $countAll++; } }
            $conMes    = ($reportadas > 0);
            $fw        = "resultW{$week}";
            $conSemana = isset($w->$fw) && $w->$fw != -1;
            if (!(($scope === 'week') ? $conSemana : $conMes)) continue;
            $promedio = $countAll > 0 ? round($sumAll / $countAll, 2) : 0;
            $estado   = ($promedio < 0.5 || $promedio > 5) ? 'Inadecuado' : 'Bueno';
            $rows[] = [
                $inst->tugel->name ?? 'Sin UGEL', $inst->name, $inst->lender,
                $inst->tdistrict->tprovince->name ?? '', $inst->tdistrict->name ?? '',
                $year, $monthName,
                $w->resultW1 != -1 ? number_format($w->resultW1, 1, '.') : '-',
                $w->resultW2 != -1 ? number_format($w->resultW2, 1, '.') : '-',
                $w->resultW3 != -1 ? number_format($w->resultW3, 1, '.') : '-',
                $w->resultW4 != -1 ? number_format($w->resultW4, 1, '.') : '-',
                $w->resultW5 != -1 ? number_format($w->resultW5, 1, '.') : '-',
                number_format($promedio, 2, '.'), $estado,
            ];
        }

        $title    = $scope === 'week' ? "Semana {$week} — {$monthName} {$year}" : "Mes actual — {$monthName} {$year}";
        $filename = $scope === 'week' ? "con_reportes_semana_{$week}_{$monthName}_{$year}.xlsx" : "con_reportes_mes_{$monthName}_{$year}.xlsx";

        return Excel::download(new WithReportingExport($rows, $title), $filename);
    }

    private function applyRoleFilters($query, $role, $level, $province, $district, $ugelFilter): void
    {
        if (!empty($ugelFilter)) {
            $ugel = TUgel::find($ugelFilter);
            if ($ugel) {
                $query->where('tinstitution.idUgel', $ugelFilter);
            }
            return;
        }

        if ($role === 'Supervisor' && $level === 'levelProvince' && $province) {
            $query->where('tprovince.idProvince', $province);
        }

        if ($role === 'Supervisor' && in_array($level, ['levelDistrict', 'levelDistrit']) && $district) {
            $query->where('tdistrict.idDistrict', $district);
        }
    }

    private function buildMapData(string $monthName, int $year, int $week, $role, $level, $province, $district, $ugelFilter): array
    {
        $q = TInstitution::with(['tdistrict.tprovince', 'tugel'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude');

        if (!empty($ugelFilter)) {
            $q->where('idUgel', $ugelFilter);
        } elseif ($role === 'Supervisor' && $level === 'levelProvince' && $province) {
            $q->whereHas('tdistrict.tprovince', fn($sq) => $sq->where('idProvince', $province));
        } elseif ($role === 'Supervisor' && in_array($level, ['levelDistrict', 'levelDistrit']) && $district) {
            $q->whereHas('tdistrict', fn($sq) => $sq->where('idDistrict', $district));
        }

        $institutions = $q->get();

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
                'id'          => $inst->idInstitution,
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
        if ($value < 0.3)  return ['#FF0000', 'CRÍTICO',    'Riesgo microbiológico muy alto'];
        if ($value < 0.5)  return ['#FF8C00', 'DEFICIENTE', 'Requiere acciones correctivas'];
        if ($value <= 2.0) return ['#00FF00', 'ÓPTIMO',     'Cumple normativa peruana (DS 031-2010-SA)'];
        if ($value <= 5.0) return ['#0000FF', 'ALTO',       'Monitorear sabor/olor'];
        return ['#800080', 'EXCESIVO', 'Excede límite máximo — incumple DS 031-2010-SA'];
    }
}

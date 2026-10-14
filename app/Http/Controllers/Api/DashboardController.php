<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TInstitution;
use App\Models\TUgel;
use App\Models\TUser;
use App\Models\TWater;
use App\Export\NonReportingExport;
use App\Export\WithReportingExport;
use App\Export\GeneralReportSheet;
use App\Export\InstitutionFullExport;
use App\Export\DataExport;
use App\Export\WaterDetailedExport;
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
                DB::raw('(SELECT MAX(s.updated_at) FROM twater s WHERE s.idInstitution = tinstitution.idInstitution AND (s.resultW1 >= 0 OR s.resultW2 >= 0 OR s.resultW3 >= 0 OR s.resultW4 >= 0 OR s.resultW5 >= 0)) as last_reported_at'),
            ])
            ->join('tinstitution', 'twater.idInstitution', '=', 'tinstitution.idInstitution')
            ->leftJoin('tugel', 'tinstitution.idUgel', '=', 'tugel.idUgel')
            ->join('tdistrict', 'tinstitution.idDistrict', '=', 'tdistrict.idDistrict')
            ->join('tprovince', 'tdistrict.idProvince', '=', 'tprovince.idProvince')
            ->where('twater.month', $monthName)
            ->whereYear('twater.created_at', $year)
            ->whereRaw('twater.updated_at = (SELECT MAX(s.updated_at) FROM twater s WHERE s.idInstitution = twater.idInstitution AND s.month = twater.month AND YEAR(s.created_at) = YEAR(twater.created_at))');

        $this->applyRoleFilters($q, $userRole, $userLevel, $userProvince, $userDistrict, $tUser->blockingReason ?? null);

        $listTWater = $q->orderByDesc('twater.updated_at')->get();

        // Denominador del "% que reportó": todos los colegios activos del alcance del usuario,
        // no solo los que tienen fila en twater este mes
        $instQ = DB::table('tinstitution')
            ->select(['tinstitution.idInstitution as id', 'tugel.name as ugel', 'tdistrict.name as distrito', 'tprovince.name as provincia'])
            ->leftJoin('tugel', 'tinstitution.idUgel', '=', 'tugel.idUgel')
            ->join('tdistrict', 'tinstitution.idDistrict', '=', 'tdistrict.idDistrict')
            ->join('tprovince', 'tdistrict.idProvince', '=', 'tprovince.idProvince')
            ->where('tinstitution.status', 'Activo');
        $this->applyRoleFilters($instQ, $userRole, $userLevel, $userProvince, $userDistrict, $tUser->blockingReason ?? null);
        $activeInstitutions = $instQ->get();

        $mapData = $this->buildMapData($monthName, $year, $week, $userRole, $userLevel, $userProvince, $userDistrict, $tUser->blockingReason ?? null);

        return response()->json([
            'success' => true,
            'data'    => [
                'waterRecords' => $listTWater,
                'institutions' => $activeInstitutions,
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
                $estado,
            ];
        }

        $title    = $scope === 'week' ? "Semana {$week} — {$monthName} {$year}" : "Mes actual — {$monthName} {$year}";
        $filename = $scope === 'week' ? "con_reportes_semana_{$week}_{$monthName}_{$year}.xlsx" : "con_reportes_mes_{$monthName}_{$year}.xlsx";

        return Excel::download(new WithReportingExport($rows, $title), $filename);
    }

    /**
     * Todas las instituciones (con y sin reporte). scope=month -> una hoja del mes elegido;
     * scope=year -> una hoja por cada mes del año (hasta el mes actual si es el año en curso).
     */
    public function exportGeneral(Request $request)
    {
        // El histórico completo no cabe en hojas por mes: va en una sola hoja con todos los registros
        if ($request->get('scope') === 'all') return $this->exportGeneralHistorico($request);

        $scope = $request->get('scope', 'month');
        $month = (int)$request->get('month', date('m'));
        $year  = (int)$request->get('year', date('Y'));
        $week  = (int)$request->get('week', 0);

        $tUser = $request->user();
        $q = TInstitution::with(['tdistrict.tprovince', 'tugel']);
        if (!empty($tUser->blockingReason)) {
            $q->where('idUgel', $tUser->blockingReason);
        } elseif (($tUser->role ?? null) === 'Supervisor' && $tUser->level === 'levelProvince' && $tUser->idProvince) {
            $q->whereHas('tdistrict.tprovince', fn($sq) => $sq->where('idProvince', $tUser->idProvince));
        } elseif (($tUser->role ?? null) === 'Supervisor' && in_array($tUser->level, ['levelDistrict', 'levelDistrit']) && $tUser->idDistrict) {
            $q->whereHas('tdistrict', fn($sq) => $sq->where('idDistrict', $tUser->idDistrict));
        }
        $instituciones = $q->get()->sortBy(fn($i) => [($i->tugel->name ?? 'zzz'), $i->name])->values();

        $monthNums = $scope === 'year'
            ? range(1, $year === (int)date('Y') ? (int)date('m') : 12)
            : [$month];
        $monthNames = array_map(fn($m) => $this->months[$m - 1], $monthNums);

        $waters = TWater::whereIn('idInstitution', $instituciones->pluck('idInstitution'))
            ->whereIn('month', $monthNames)->whereYear('created_at', $year)
            ->orderByDesc('updated_at')->get()
            ->unique(fn($w) => $w->idInstitution . '|' . $w->month)
            ->keyBy(fn($w) => $w->idInstitution . '|' . $w->month);

        $sheets = [];
        foreach ($monthNames as $monthName) {
            // En el año completo no hay semana de referencia: el estado es el último reporte del mes
            $refWeek = $scope === 'month' && $week >= 1 && $week <= 5 ? $week : null;
            $rows = [];
            foreach ($instituciones as $inst) {
                $w = $waters->get($inst->idInstitution . '|' . $monthName);
                $weeks = [];
                for ($i = 1; $i <= 5; $i++) {
                    $v = $w?->{"resultW{$i}"};
                    $weeks[] = ($v === null || (float)$v < 0) ? null : (float)$v;
                }
                $reported = array_values(array_filter($weeks, fn($v) => $v !== null));
                $rows[] = [
                    'ugel'      => $inst->tugel->name ?? 'Sin UGEL',
                    'nombre'    => $inst->name,
                    'prestador' => $inst->lender,
                    'provincia' => $inst->tdistrict->tprovince->name ?? '',
                    'distrito'  => $inst->tdistrict->name ?? '',
                    'mes'       => $monthName,
                    'weeks'     => $weeks,
                    'estado'    => $refWeek ? $weeks[$refWeek - 1] : (end($reported) === false ? null : end($reported)),
                ];
            }
            $sheets[] = new GeneralReportSheet(
                $rows,
                "{$monthName} {$year}",
                "Reporte general de cloro residual — {$monthName} {$year}",
                $refWeek
            );
        }

        $filename = $scope === 'year'
            ? "reporte_general_{$year}.xlsx"
            : "reporte_general_{$this->months[$month - 1]}_{$year}.xlsx";

        return Excel::download(new InstitutionFullExport($sheets), $filename);
    }

    private function exportGeneralHistorico(Request $request)
    {
        $scope     = $request->get('scope', 'month');
        $monthName = $this->months[(int)$request->get('month', date('m')) - 1];
        $year      = (int)$request->get('year', date('Y'));

        $q = TWater::with(['tinstitution.tdistrict.tprovince', 'tinstitution.tugel']);
        $this->scopeByUser($q, $request->user(), 'tinstitution.');
        if ($scope !== 'all') $q->whereYear('created_at', $year);
        if ($scope === 'month') $q->where('month', $monthName);

        $data = [[
            'UGEL', 'Institución', 'Prestador', 'Provincia', 'Distrito', 'Periodo año', 'Periodo mes',
            'MCR S. 1', 'MCR S. 2', 'MCR S. 3', 'MCR S. 4', 'MCR S. 5', 'Promedio', 'Última medición', 'Estado',
        ]];

        foreach ($q->orderByDesc('created_at')->get() as $w) {
            $inst = $w->tinstitution;
            if (!$inst) continue;
            $values = [];
            for ($i = 1; $i <= 5; $i++) { $f = "resultW{$i}"; if ($w->$f > -1) $values[] = (float)$w->$f; }
            $promedio = $values ? round(array_sum($values) / count($values), 2) : null;
            $ultima   = $values ? end($values) : null;
            $data[] = [
                $inst->tugel->name ?? 'Sin UGEL', $inst->name, $inst->lender,
                $inst->tdistrict->tprovince->name ?? '', $inst->tdistrict->name ?? '',
                substr($w->created_at, 0, 4), $w->month,
                $w->resultW1 != -1 ? number_format($w->resultW1, 1, '.') : '-',
                $w->resultW2 != -1 ? number_format($w->resultW2, 1, '.') : '-',
                $w->resultW3 != -1 ? number_format($w->resultW3, 1, '.') : '-',
                $w->resultW4 != -1 ? number_format($w->resultW4, 1, '.') : '-',
                $w->resultW5 != -1 ? number_format($w->resultW5, 1, '.') : '-',
                $promedio ?? '-',
                $ultima ?? '-',
                $promedio === null ? 'Sin reportes' : (($promedio < 0.5 || $promedio > 5) ? 'Inadecuado' : 'Bueno'),
            ];
        }

        $filename = match ($scope) {
            'all'   => 'reporte_general_historico.xlsx',
            'year'  => "reporte_general_{$year}.xlsx",
            default => "reporte_general_{$monthName}_{$year}.xlsx",
        };

        return Excel::download(new DataExport($data), $filename);
    }

    public function exportDetailed(Request $request)
    {
        $trimestre = (string)$request->get('trimestre', (string)ceil((int)date('m') / 3));
        $year      = (int)$request->get('year', date('Y'));

        $trimestresMeses = [
            '1' => ['Enero', 'Febrero', 'Marzo'],
            '2' => ['Abril', 'Mayo', 'Junio'],
            '3' => ['Julio', 'Agosto', 'Setiembre'],
            '4' => ['Octubre', 'Noviembre', 'Diciembre'],
        ];
        $mesesTrimestre = $trimestresMeses[$trimestre] ?? $trimestresMeses['1'];

        $qInst = TInstitution::with(['tdistrict.tprovince', 'tugel']);
        $this->scopeByUser($qInst, $request->user());
        $instituciones = $qInst->get();

        // Si hay varios registros del mismo mes, nos quedamos con el más reciente
        $porInstitucion = [];
        $waters = TWater::whereIn('idInstitution', $instituciones->pluck('idInstitution')->all())
            ->whereIn('month', $mesesTrimestre)
            ->whereYear('created_at', $year)
            ->orderBy('updated_at')
            ->get();
        foreach ($waters as $w) {
            $porInstitucion[$w->idInstitution][$w->month] = $w;
        }

        $con = [];
        $sin = [];
        foreach ($instituciones as $inst) {
            if (!empty($porInstitucion[$inst->idInstitution])) $con[] = $inst;
            else $sin[] = $inst;
        }

        $headers = ['N°', 'UGEL', 'Institución', 'Prestador', 'Provincia', 'Distrito'];
        $headers = array_merge($headers, array_fill(0, 15, ''), ['Observaciones', 'Situación Final']);
        // WaterDetailedExport escribe la fila 2 con S.1..S.5; si no se reserva, pisa la primera institución
        $data    = [$headers, array_fill(0, count($headers), '')];

        $n = 1;
        foreach (array_merge($con, $sin) as $inst) {
            $fila = [
                $n++, $inst->tugel->name ?? 'Sin UGEL', $inst->name, $inst->lender,
                $inst->tdistrict->tprovince->name ?? '', $inst->tdistrict->name ?? '',
            ];
            $reportadas = 0;
            $suma       = 0;
            foreach ($mesesTrimestre as $mes) {
                $w = $porInstitucion[$inst->idInstitution][$mes] ?? null;
                for ($s = 1; $s <= 5; $s++) {
                    $f = "resultW{$s}";
                    if ($w && $w->$f != -1) {
                        $fila[] = number_format($w->$f, 1, '.');
                        $reportadas++;
                        $suma += $w->$f;
                    } else {
                        $fila[] = '-';
                    }
                }
            }
            $porcentaje = $reportadas / 15 * 100;
            $promedio   = $reportadas > 0 ? $suma / $reportadas : 0;
            $fila[] = $this->observacionReporte($porcentaje, $reportadas);
            $fila[] = $this->situacionFinal($promedio, $porcentaje);
            $data[] = $fila;
        }

        return Excel::download(
            new WaterDetailedExport($data, $mesesTrimestre),
            "reporte_detallado_trimestre_{$trimestre}_{$year}.xlsx"
        );
    }

    private function scopeByUser($query, $user, string $relPrefix = ''): void
    {
        $role = $user->role ?? null;
        if ($role !== 'Supervisor') return;
        $level = $user->level ?? null;
        if ($level === 'levelProvince' && $user->idProvince) {
            $query->whereHas($relPrefix . 'tdistrict', fn($q) => $q->where('idProvince', $user->idProvince));
        } elseif (in_array($level, ['levelDistrict', 'levelDistrit']) && $user->idDistrict) {
            $query->whereHas($relPrefix . 'tdistrict', fn($q) => $q->where('idDistrict', $user->idDistrict));
        }
    }

    private function observacionReporte(float $porcentaje, int $reportadas): string
    {
        if ($reportadas === 0)  return 'Nunca subió sus reportes';
        if ($porcentaje < 30)   return 'Muy pocas semanas reportó';
        if ($porcentaje < 50)   return 'Pocas semanas reportó';
        if ($porcentaje < 80)   return 'Algunas semanas no reportó';
        if ($porcentaje < 100)  return 'Varias semanas no reportó';
        return 'Reportó todas las semanas';
    }

    private function situacionFinal(float $promedio, float $porcentaje): string
    {
        if ($porcentaje == 0) return 'No se conoce la calidad del agua - Sin reportes';
        if ($promedio == 0)   return 'Su reporte de cloro residual quedó en inadecuado';
        if ($promedio < 0.5)  return 'Su reporte de cloro residual quedó en inadecuado - Insuficiente desinfección';
        if ($promedio <= 5.0) return 'Su reporte muestra nivel adecuado de cloro residual';
        return 'Su reporte de cloro residual excede niveles aceptables';
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

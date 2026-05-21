<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


use App\Models\TInstitution;
use App\Models\TInstitutionTUser;
use App\Models\TUser;
use App\Models\TConfiguration;
use App\Models\TProvince;
use App\Models\TDistrict;
use App\Models\TUgel;
use App\Models\TWater;
use App\Export\InstitutionDataExport;

class InstitutionController extends Controller
{
	public function actionGetAll(Request $request, $currentPage)
	{
		$searchParameter = $request->has('searchParameter') ? $request->input('searchParameter') : '';

		$paginate = PlatformHelper::preparePaginate(
			TInstitution::with(['tdistrict.tprovince', 'tugel'])
				->where('name', 'LIKE', '%' . $searchParameter . '%')
				->orderByRaw('created_at desc'),
			7,
			$currentPage
		);

		$tConfigurationFmMdl = TConfiguration::first();

		return view('institution/getall', [
			'listTInstitution' => $paginate['listRow'],
			'currentPage' => $paginate['currentPage'],
			'quantityPage' => $paginate['quantityPage'],
			'searchParameter' => $searchParameter,
			'tConfigurationFmMdl' => $tConfigurationFmMdl
		]);
	}

	public function actionInsert(Request $request)
	{
		if ($request->isMethod('post')) {
			try {
				DB::beginTransaction();

				if (!$request->has('name') || trim($request->input('name')) == '') {
					return PlatformHelper::redirectError('El nombre es requerido.', 'institution/insert');
				}

				if (!$request->has('lender') || trim($request->input('lender')) == '') {
					return PlatformHelper::redirectError('El tipo de entidad es requerido.', 'institution/insert');
				}

				if (!$request->has('idDistrict') || trim($request->input('idDistrict')) == '') {
					return PlatformHelper::redirectError('El distrito es requerido.', 'institution/insert');
				}

				$tInstitution = new TInstitution();
				$tInstitution->idInstitution = uniqid();
				$tInstitution->name = trim($request->input('name'));
				$tInstitution->lender = trim($request->input('lender'));
				$tInstitution->idDistrict = $request->input('idDistrict');
				$tInstitution->idUgel = $request->input('idUgel') ?: null;
				$tInstitution->status = 'Activo';
				$tInstitution->save();

				DB::commit();

				return PlatformHelper::redirectCorrect('Institución creada correctamente.', 'institution/getall/1');
			} catch (\Exception $e) {
				DB::rollback();
				return PlatformHelper::redirectError('Error: ' . $e->getMessage(), 'institution/insert');
			}
		}

		$listTDistrict = TDistrict::with('tprovince')->orderBy('name', 'asc')->get();
		$listTUgel = TUgel::where('is_active', 1)->orderBy('name', 'asc')->get();
		$tConfigurationFmMdl = TConfiguration::first();

		return view('institution/insert', [
			'listTDistrict' => $listTDistrict,
			'listTUgel' => $listTUgel,
			'tConfigurationFmMdl' => $tConfigurationFmMdl
		]);
	}

	public function actionGetDistricts(Request $request)
	{
		try {
			$listTDistrict = TDistrict::where('idProvince', $request->input('idProvince'))
				->orderBy('name', 'asc')
				->get(['idDistrict', 'name']);

			return response()->json([
				'success' => true,
				'districts' => $listTDistrict
			]);
		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => 'Error al obtener distritos'
			]);
		}
	}

	public function getugels(Request $request)
	{
		try {
			$ugels = TUgel::where('is_active', 1)
				->orderBy('name', 'asc')
				->get(['idUgel', 'name']);

			return response()->json([
				'success' => true,
				'ugels' => $ugels
			]);
		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => 'Error al obtener UGELs'
			]);
		}
	}

	public function actionEdit(Request $request, $idInstitution)
	{
		try {
			$institution = TInstitution::with(['tDistrict.tProvince', 'tUgel'])->findOrFail($idInstitution);
			$listTDistrict = TDistrict::with('tProvince')->orderBy('name', 'asc')->get();
			$listTUgel = TUgel::where('is_active', 1)->orderBy('name', 'asc')->get();
			$tConfigurationFmMdl = TConfiguration::first();

			return view('institution/edit', [
				'institution' => $institution,
				'listTDistrict' => $listTDistrict,
				'listTUgel' => $listTUgel,
				'tConfigurationFmMdl' => $tConfigurationFmMdl
			]);
		} catch (\Exception $e) {
			return PlatformHelper::redirectError('Institución no encontrada.', 'institution/getall/1');
		}
	}

	public function actionUpdate(Request $request, $idInstitution)
	{
		try {
			DB::beginTransaction();

			$institution = TInstitution::findOrFail($idInstitution);

			if (!$request->has('name') || trim($request->input('name')) == '') {
				return PlatformHelper::redirectError('El nombre es requerido.', 'institution/edit/' . $idInstitution);
			}

			if (!$request->has('lender') || trim($request->input('lender')) == '') {
				return PlatformHelper::redirectError('El tipo de entidad es requerido.', 'institution/edit/' . $idInstitution);
			}

			$institution->name = trim($request->input('name'));
			$institution->lender = trim($request->input('lender'));
			$institution->idDistrict = $request->input('idDistrict');
			$institution->idUgel = $request->input('idUgel') ?: null;
			
			// Agregar coordenadas para el mapa (opcionales)
			$latitude = $request->input('latitude');
			$longitude = $request->input('longitude');
			
			$institution->latitude = (!empty($latitude) && is_numeric($latitude)) ? $latitude : null;
			$institution->longitude = (!empty($longitude) && is_numeric($longitude)) ? $longitude : null;
			
			$institution->save();

			DB::commit();

			return PlatformHelper::redirectCorrect('Institución actualizada correctamente.', 'institution/getall/1');
		} catch (\Exception $e) {
			DB::rollback();
			return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'institution/edit/' . $idInstitution);
		}
	}

	public function actionDelete(Request $request, $idInstitution)
	{
		try {
			DB::beginTransaction();

			$institution = TInstitution::findOrFail($idInstitution);

			if ($institution->tinstitutiontuser()->count() > 0) {
				return PlatformHelper::redirectError('No se puede eliminar la institución porque tiene usuarios asociados.', 'institution/getall/1');
			}

			$institution->delete();

			DB::commit();

			return PlatformHelper::redirectCorrect('Institución eliminada correctamente.', 'institution/getall/1');
		} catch (\Exception $e) {
			DB::rollback();
			return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'institution/getall/1');
		}
	}

	public function actionToggleStatus(Request $request, $idInstitution)
	{
		try {
			DB::beginTransaction();

			$institution = TInstitution::findOrFail($idInstitution);
			$institution->status = ($institution->status == 'Activo') ? 'Inactivo' : 'Activo';
			$institution->save();

			$status = ($institution->status == 'Activo') ? 'activada' : 'desactivada';

			DB::commit();

			return PlatformHelper::redirectCorrect('Institución ' . $status . ' correctamente.', 'institution/getall/1');
		} catch (\Exception $e) {
			DB::rollback();
			return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'institution/getall/1');
		}
	}

	public function actionUserManagement(Request $request, SessionManager $sessionManager)
	{
		if ($request->has('hdIdInstitution')) {
			try {
				DB::beginTransaction();

				$tInstitution = TInstitution::find($request->input('hdIdInstitution'));

				TInstitutionTUser::whereRaw('idInstitution=?', [$tInstitution->idInstitution])->delete();

				if ($request->input('selectIdUser') != null && count($request->input('selectIdUser')) > 0) {
					foreach ($request->input('selectIdUser') as $value) {
						TInstitutionTUser::whereRaw('idUser=?', [$value])->delete();

						$tInstitutionTUser = new TInstitutionTUser();

						$tInstitutionTUser->idInstitutionTUser = uniqid();
						$tInstitutionTUser->idUser = $value;
						$tInstitutionTUser->idInstitution = $tInstitution->idInstitution;

						$tInstitutionTUser->save();
					}
				}

				DB::commit();

				return PlatformHelper::redirectCorrect('Operación realizada correctamente.', 'institution/getall/1');
			} catch (\Exception $e) {
				DB::rollback();
				return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'institution/getall/1');
			}
		}

		$tInstitution = TInstitution::with(['tinstitutiontuser'])->whereRaw('idInstitution=?', [$request->input('idInstitution')])->first();
		$listTUser = TUser::whereRaw('role!=? and role!=?', ['Super usuario', 'Administrador'])->orderBy('email', 'asc')->get();
		$tConfigurationFmMdl = TConfiguration::first();

		return view('institution/usermanagement', [
			'tInstitution' => $tInstitution,
			'listTUser' => $listTUser,
			'tConfigurationFmMdl' => $tConfigurationFmMdl
		]);
	}

	public function actionChgToInsertWater(Request $request)
	{
		try {
			$listTInstitution = TInstitution::whereHas('tdistrict', function ($sq1) use ($request) {
				$sq1->whereRaw('idDistrict=?', [$request->input('idDistrict')]);
			})->get(['idInstitution', 'name']);

			return response()->json([
				'success' => true,
				'institutions' => $listTInstitution
			]);
		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => 'Error al obtener instituciones'
			]);
		}
	}

	public function actionExport(Request $request)
	{
		$searchParameter = $request->has('searchParameter') ? $request->input('searchParameter') : '';

		$query = TInstitution::with(['tdistrict.tprovince', 'tugel'])
			->where('name', 'LIKE', '%' . $searchParameter . '%')
			->orderByRaw('created_at desc');

		$listTInstitution = $query->get();

		$data = [];

		$data[] = [
			'ID',
			'UGEL',
			'INSTITUCIÓN',
			'PRESTADOR',
			'PROVINCIA',
			'DISTRITO',
			'ESTADO',
			'FECHA CREACIÓN'
		];

		foreach ($listTInstitution as $value) {
			$data[] = [
				$value->idInstitution,
				$value->tugel->name ?? 'Sin UGEL',
				$value->name,
				$value->lender,
				$value->tdistrict->tprovince->name ?? 'Sin Provincia',
				$value->tdistrict->name ?? 'Sin Distrito',
				$value->status,
				$value->created_at ? $value->created_at->format('d/m/Y H:i') : '-'
			];
		}
		return Excel::download(new InstitutionDataExport($data), 'instituciones_' . date('d-m-Y') . '.xlsx');
	}


	public function actionGetInstitutionsByUgel(Request $request)
	{
		try {
			$groupBy = $request->get('group_by', 'ugel');

			// Obtener datos del mapa para el público
			$mapData = $this->getMapData(
				$request->get('month'),
				$request->get('year'),
				$request->get('week')
			);

			if ($groupBy === 'district') {
				$districts = TDistrict::with([
					'tInstitution' => function($query) {
						$query->where('status', 'Activo')
							->with(['tUgel']);
					},
					'tProvince'
				])
				->whereHas('tInstitution', function($query) {
					$query->where('status', 'Activo');
				})
				->orderBy('name', 'asc')
				->get();

				$institutionsSinDistrito = collect([]);

				return view('home/institution', [
					'groupBy' => 'district',
					'districts' => $districts,
					'ugels' => collect([]),
					'provinces' => collect([]),
					'institutionsSinUgel' => $institutionsSinDistrito,
					'totalInstitutions' => TInstitution::where('status', 'Activo')->count(),
					'mapData' => $mapData,
					'tConfigurationFmMdl' => TConfiguration::first()
				]);

			} elseif ($groupBy === 'province') {
				$provinces = TProvince::with([
					'tDistrict.tInstitution' => function($query) {
						$query->where('status', 'Activo')
						->with(['tUgel']);
					}
				])
				->whereHas('tDistrict.tInstitution', function($query) {
					$query->where('status', 'Activo');
				})
				->orderBy('name', 'asc')
				->get();

				return view('home/institution', [
					'groupBy' => 'province',
					'provinces' => $provinces,
					'ugels' => collect([]),
					'districts' => collect([]),
					'institutionsSinUgel' => collect([]),
					'totalInstitutions' => TInstitution::where('status', 'Activo')->count(),
					'mapData' => $mapData,
					'tConfigurationFmMdl' => TConfiguration::first()
				]);

			} else {
				$ugels = TUgel::with([
					'tInstitution' => function($query) {
						$query->where('status', 'Activo')
						->with(['tDistrict.tProvince']);
					},
					'tProvince',
					'tDistrict'
				])
				->where('is_active', true)
				->orderBy('name', 'asc')
				->get();

				$institutionsSinUgel = TInstitution::with(['tDistrict.tProvince'])
					->where('status', 'Activo')
					->whereNull('idUgel')
					->orderBy('name', 'asc')
					->get();

				return view('home/institution', [
					'groupBy' => 'ugel',
					'ugels' => $ugels,
					'districts' => collect([]),
					'provinces' => collect([]),
					'institutionsSinUgel' => $institutionsSinUgel,
					'totalInstitutions' => TInstitution::where('status', 'Activo')->count(),
					'mapData' => $mapData,
					'tConfigurationFmMdl' => TConfiguration::first()
				]);
			}

		} catch (\Exception $e) {
			return view('home/institution', [
				'groupBy' => 'ugel',
				'ugels' => collect([]),
				'districts' => collect([]),
				'provinces' => collect([]),
				'institutionsSinUgel' => collect([]),
				'totalInstitutions' => 0,
				'mapData' => [],
				'tConfigurationFmMdl' => null
			]);
		}
	}

	/**
	 * Generar datos para el mapa de calor público
	 */
	private function getMapData($monthParam = null, $yearParam = null, $weekParam = null)
	{
		// Si no se proporcionan parámetros, usar mes, año y semana actual
		$monthsEs = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'];

		$monthName = $monthParam ? $monthsEs[(int)$monthParam - 1] : $monthsEs[(int)date('m') - 1];
		$year = $yearParam ? (int)$yearParam : (int)date('Y');

		$week = $weekParam ? (int)$weekParam : null;
		if (!$week) {
			$today = date('Y-m-d');
			$firstOfMonth = date('Y-m-01', strtotime($today));
			$week = (int)date('W', strtotime($today)) - (int)date('W', strtotime($firstOfMonth)) + 1;
			if ($week < 1) $week = 1;
			if ($week > 5) $week = 5;
		}

		// Obtener solo instituciones que tienen coordenadas (no NULL)
		$institutions = TInstitution::with(['tdistrict.tprovince', 'tugel'])
			->whereNotNull('latitude')
			->whereNotNull('longitude')
			->where('status', 'Activo')
			->get();

		$mapData = [];
		foreach ($institutions as $institution) {
			// Buscar el último registro de agua para esta institución del mes/año especificado
			$waterData = TWater::where('idInstitution', $institution->idInstitution)
							  ->where('month', $monthName)
							  ->whereYear('created_at', $year)
							  ->orderBy('updated_at', 'desc')
							  ->first();

			$weekValue = 0;
			$hasData = false;

			if ($waterData) {
				// Obtener el valor específico de la semana seleccionada
				$field = "resultW{$week}";
				if (isset($waterData->$field) && $waterData->$field != -1) {
					$weekValue = (float) $waterData->$field;
					$hasData = true;
				}
			}

			// Determinar color según rangos específicos de MCR
			$color = '#808080'; // Gris por defecto (sin datos)
			$status = 'Sin datos';
			$description = "No hay registros de la semana {$week}";

			if ($hasData && $weekValue > 0) {
				if ($weekValue < 0.3) {
					$color = '#FF0000'; // Rojo: crítico
					$status = 'Crítico';
					$description = 'Riesgo microbiológico muy alto';
				} elseif ($weekValue >= 0.3 && $weekValue < 0.5) {
					$color = '#FF8C00'; // Naranja: deficiente
					$status = 'Deficiente';
					$description = 'Requiere acciones correctivas';
				} elseif ($weekValue >= 0.5 && $weekValue <= 2.0) {
					$color = '#00FF00'; // Verde: óptimo
					$status = 'Óptimo';
					$description = 'Cumple normativa peruana';
				} elseif ($weekValue > 2.0 && $weekValue <= 5.0) {
					$color = '#0000FF'; // Azul: alto
					$status = 'Alto';
					$description = 'Monitorear sabor/olor';
				} else {
					$color = '#800080'; // Púrpura: excesivo
					$status = 'Excesivo';
					$description = 'Incumple DS 031-2010-SA';
				}
			}

			$mapData[] = [
				'name' => $institution->name,
				'lat' => (float) $institution->latitude,
				'lng' => (float) $institution->longitude,
				'ugel' => $institution->tugel->name ?? 'Sin UGEL',
				'lender' => $institution->lender,
				'district' => $institution->tdistrict->name ?? 'Sin distrito',
				'province' => $institution->tdistrict->tprovince->name ?? 'Sin provincia',
				'week' => $week,
				'weekValue' => $weekValue,
				'color' => $color,
				'status' => $status,
				'description' => $description
			];
		}

		return $mapData;
	}

	/**
	 * Endpoint público para obtener datos del mapa sin restricciones
	 */
	public function getPublicMapData(Request $request)
	{
		$mapData = $this->getMapData(
			$request->get('month'),
			$request->get('year'),
			$request->get('week')
		);

		return response()->json($mapData);
	}

	public function getPublicStats(Request $request)
	{
		$months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'];
		$monthNum     = $request->has('month') ? max(1, min(12, (int)$request->get('month'))) : (int)date('m');
		$currentMonth = $months[$monthNum - 1];
		$currentYear  = $request->has('year') ? (int)$request->get('year') : (int)date('Y');
		$weekParam    = $request->has('week') ? (int)$request->get('week') : 0;

		$totalInstitutions = TInstitution::where('status', 'Activo')->count();

		if ($weekParam > 0) {
			$wField = "resultW{$weekParam}";
			$institutionsReported = TWater::whereYear('created_at', $currentYear)
				->where('month', $currentMonth)
				->where($wField, '>', 0)
				->distinct('idInstitution')
				->count('idInstitution');
		} else {
			$institutionsReported = TWater::whereYear('created_at', $currentYear)
				->where('month', $currentMonth)
				->distinct('idInstitution')
				->count('idInstitution');
		}

		$coveragePct = $totalInstitutions > 0
			? (int)round(($institutionsReported / $totalInstitutions) * 100)
			: 0;

		$totalProvinces = DB::table('tinstitution')
			->join('tdistrict', 'tinstitution.idDistrict', '=', 'tdistrict.idDistrict')
			->where('tinstitution.status', 'Activo')
			->distinct()
			->count('tdistrict.idProvince');

		$totalUgels = DB::table('tugel')->where('is_active', true)->count();

		// Tendencia vs mes anterior
		$prevMonthIndex = $monthNum - 2;
		$prevYear = $currentYear;
		if ($prevMonthIndex < 0) { $prevMonthIndex = 11; $prevYear--; }
		$prevMonth = $months[$prevMonthIndex];
		$prevReported = TWater::whereYear('created_at', $prevYear)->where('month', $prevMonth)->distinct('idInstitution')->count('idInstitution');
		$prevCoveragePct = $totalInstitutions > 0 ? (int)round(($prevReported / $totalInstitutions) * 100) : 0;
		$trendCoveragePct = $coveragePct - $prevCoveragePct;

		// Instituciones que nunca han reportado
		$reportedIds = TWater::distinct()->pluck('idInstitution');
		$neverReportedCount = TInstitution::where('status', 'Activo')
			->whereNotIn('idInstitution', $reportedIds)
			->count();

		// UGEL más activa este mes
		$topUgelRow = DB::table('twater')
			->join('tinstitution', 'twater.idInstitution', '=', 'tinstitution.idInstitution')
			->join('tugel', 'tinstitution.idUgel', '=', 'tugel.idUgel')
			->whereYear('twater.created_at', $currentYear)
			->where('twater.month', $currentMonth)
			->select('tugel.name', DB::raw('COUNT(DISTINCT twater.idInstitution) as total'))
			->groupBy('tugel.idUgel', 'tugel.name')
			->orderByDesc('total')
			->first();
		$topUgel = $topUgelRow ? $topUgelRow->name : null;

		// Análisis de cloro — filtrado por semana si se especifica
		$records = TWater::whereYear('created_at', $currentYear)
			->where('month', $currentMonth)
			->get(['resultW1', 'resultW2', 'resultW3', 'resultW4', 'resultW5']);

		$institutionAvgs = [];
		$criticalCount = 0; $deficientCount = 0; $optimalCount = 0; $highCount = 0; $excessiveCount = 0;

		foreach ($records as $r) {
			if ($weekParam > 0) {
				$field = "resultW{$weekParam}";
				$val   = isset($r->$field) && (float)$r->$field > 0 ? (float)$r->$field : null;
				if ($val === null) continue;
				$avg = $val;
			} else {
				$vals = collect([$r->resultW1, $r->resultW2, $r->resultW3, $r->resultW4, $r->resultW5])
					->filter(fn($v) => $v !== null && (float)$v > 0)
					->map(fn($v) => (float)$v);
				if ($vals->count() === 0) continue;
				$avg = $vals->average();
			}
			$institutionAvgs[] = $avg;
			if ($avg < 0.3)      $criticalCount++;
			elseif ($avg < 0.5)  $deficientCount++;
			elseif ($avg <= 2.0) $optimalCount++;
			elseif ($avg <= 5.0) $highCount++;
			else                 $excessiveCount++;
		}

		$totalWithData = count($institutionAvgs);
		$avgChlorine   = $totalWithData > 0 ? round(array_sum($institutionAvgs) / $totalWithData, 2) : null;
		$complianceRate = $totalWithData > 0 ? (int)round(($optimalCount / $totalWithData) * 100) : null;

		return response()->json([
			'total_institutions'      => $totalInstitutions,
			'institutions_this_month' => $institutionsReported,
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
		]);
	}

	public function getPublicUgelChart(Request $request)
	{
		$months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'];
		$monthNum     = $request->has('month') ? max(1, min(12, (int)$request->get('month'))) : (int)date('m');
		$currentMonth = $months[$monthNum - 1];
		$currentYear  = $request->has('year') ? (int)$request->get('year') : (int)date('Y');

		$ugels = TUgel::where('is_active', true)->orderBy('name')->get(['idUgel', 'name']);

		$data = [];
		foreach ($ugels as $ugel) {
			$rows = DB::table('twater')
				->join('tinstitution', 'twater.idInstitution', '=', 'tinstitution.idInstitution')
				->whereYear('twater.created_at', $currentYear)
				->where('twater.month', $currentMonth)
				->where('tinstitution.idUgel', $ugel->idUgel)
				->select('twater.resultW1','twater.resultW2','twater.resultW3','twater.resultW4','twater.resultW5')
				->get();

			$weeks = [];
			for ($w = 1; $w <= 5; $w++) {
				$field = "resultW{$w}";
				$vals  = $rows->pluck($field)->filter(fn($v) => $v !== null && (float)$v >= 0)->map(fn($v) => (float)$v);
				$weeks[] = [
					'week'  => $w,
					'avg'   => $vals->count() > 0 ? round($vals->average(), 2) : null,
					'count' => $vals->count(),
				];
			}

			$hasData = collect($weeks)->contains(fn($wk) => $wk['avg'] !== null);
			if ($hasData) {
				$data[] = ['name' => $ugel->name, 'weeks' => $weeks];
			}
		}

		return response()->json([
			'month' => $currentMonth,
			'year'  => $currentYear,
			'ugels' => $data,
		]);
	}

	public function getPublicDistrictChart(Request $request)
	{
		$months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'];
		$monthNum     = $request->has('month') ? max(1, min(12, (int)$request->get('month'))) : (int)date('m');
		$currentMonth = $months[$monthNum - 1];
		$currentYear  = $request->has('year') ? (int)$request->get('year') : (int)date('Y');
		$ugelName     = trim($request->get('ugel', ''));

		$ugel = TUgel::where('name', $ugelName)->first();
		if (!$ugel) {
			return response()->json([
				'month'     => $currentMonth,
				'year'      => $currentYear,
				'ugel'      => $ugelName,
				'districts' => [],
			]);
		}

		$districts = TDistrict::whereHas('tInstitution', fn($q) => $q->where('idUgel', $ugel->idUgel))
			->orderBy('name')
			->get(['idDistrict', 'name']);

		$data = [];
		foreach ($districts as $district) {
			$rows = DB::table('twater')
				->join('tinstitution', 'twater.idInstitution', '=', 'tinstitution.idInstitution')
				->whereYear('twater.created_at', $currentYear)
				->where('twater.month', $currentMonth)
				->where('tinstitution.idUgel', $ugel->idUgel)
				->where('tinstitution.idDistrict', $district->idDistrict)
				->select('twater.resultW1','twater.resultW2','twater.resultW3','twater.resultW4','twater.resultW5')
				->get();

			$weeks = [];
			for ($w = 1; $w <= 5; $w++) {
				$field = "resultW{$w}";
				$vals  = $rows->pluck($field)->filter(fn($v) => $v !== null && (float)$v >= 0)->map(fn($v) => (float)$v);
				$weeks[] = [
					'week'  => $w,
					'avg'   => $vals->count() > 0 ? round($vals->average(), 2) : null,
					'count' => $vals->count(),
				];
			}

			$hasData = collect($weeks)->contains(fn($wk) => $wk['avg'] !== null);
			if ($hasData) {
				$data[] = ['name' => $district->name, 'weeks' => $weeks];
			}
		}

		return response()->json([
			'month'     => $currentMonth,
			'year'      => $currentYear,
			'ugel'      => $ugelName,
			'districts' => $data,
		]);
	}

	public function getPublicInstitutionChart(Request $request)
	{
		$months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'];
		$monthNum     = $request->has('month') ? max(1, min(12, (int)$request->get('month'))) : (int)date('m');
		$currentMonth = $months[$monthNum - 1];
		$currentYear  = $request->has('year') ? (int)$request->get('year') : (int)date('Y');
		$ugelName     = trim($request->get('ugel', ''));
		$districtName = trim($request->get('district', ''));

		$ugel     = TUgel::where('name', $ugelName)->first();
		$district = TDistrict::where('name', $districtName)->first();

		if (!$ugel || !$district) {
			return response()->json([
				'month'        => $currentMonth,
				'year'         => $currentYear,
				'ugel'         => $ugelName,
				'district'     => $districtName,
				'institutions' => [],
			]);
		}

		$institutions = TInstitution::where('idUgel', $ugel->idUgel)
			->where('idDistrict', $district->idDistrict)
			->where('status', 'Activo')
			->orderBy('name')
			->get(['idInstitution', 'name']);

		$data = [];
		foreach ($institutions as $inst) {
			$rows = DB::table('twater')
				->whereYear('created_at', $currentYear)
				->where('month', $currentMonth)
				->where('idInstitution', $inst->idInstitution)
				->select('resultW1','resultW2','resultW3','resultW4','resultW5')
				->get();

			$weeks = [];
			for ($w = 1; $w <= 5; $w++) {
				$field = "resultW{$w}";
				$vals  = $rows->pluck($field)->filter(fn($v) => $v !== null && (float)$v >= 0)->map(fn($v) => (float)$v);
				$weeks[] = [
					'week'  => $w,
					'avg'   => $vals->count() > 0 ? round($vals->average(), 2) : null,
					'count' => $vals->count(),
				];
			}

			$hasData = collect($weeks)->contains(fn($wk) => $wk['avg'] !== null);
			if ($hasData) {
				$data[] = ['name' => $inst->name, 'weeks' => $weeks];
			}
		}

		return response()->json([
			'month'        => $currentMonth,
			'year'         => $currentYear,
			'ugel'         => $ugelName,
			'district'     => $districtName,
			'institutions' => $data,
		]);
	}

	public function getPublicTrend()
	{
		$months      = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'];
		$monthLabels = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Set','Oct','Nov','Dic'];

		$total = TInstitution::where('status', 'Activo')->count();

		$monthly     = [];
		$now         = new \DateTime();
		for ($i = 23; $i >= 0; $i--) {
			$dt       = (clone $now)->modify("-{$i} months");
			$year     = (int)$dt->format('Y');
			$monthNum = (int)$dt->format('m');
			$monthName = $months[$monthNum - 1];
			$label     = $monthLabels[$monthNum - 1] . ' ' . substr((string)$year, 2);

			$reported = TWater::whereYear('created_at', $year)
				->where('month', $monthName)
				->distinct('idInstitution')
				->count('idInstitution');

			$monthly[] = [
				'year'      => $year,
				'month'     => $monthName,
				'month_num' => $monthNum,
				'reported'  => $reported,
				'label'     => $label,
			];
		}

		$yearly      = [];
		$currentYear = (int)$now->format('Y');
		for ($y = $currentYear - 4; $y <= $currentYear; $y++) {
			$reported = TWater::whereYear('created_at', $y)
				->distinct('idInstitution')
				->count('idInstitution');
			$yearly[] = ['year' => $y, 'reported' => $reported, 'total' => $total];
		}

		return response()->json([
			'total'   => $total,
			'monthly' => $monthly,
			'yearly'  => $yearly,
		]);
	}
}

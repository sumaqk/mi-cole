<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TVideo;
use App\Models\TContent;
use App\Models\TGallery;
use App\Models\TUser;
use App\Models\TProvince;
use Illuminate\Support\Carbon;
use App\Models\ModalSetting;
use Illuminate\Support\Facades\Cache;
use App\Models\TImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Export\NonReportingExport;
use App\Export\WithReportingExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\TInstitution;
use App\Models\TUgel;
use App\Models\TWater;
use Illuminate\Http\Request;

class IndexController extends Controller
{
	public function actionIndex()
	{
		if (file_exists(public_path('index.html'))) {
			return redirect()->route('home');
		}

		$modal = Cache::remember('active_modal', 60, function () {
			return ModalSetting::where('is_active', true)
				->where('start_date', '<=', now())
				->where('end_date', '>=', now())
				->first();
		});

		return view('home.index', compact('modal'));
	}

	public function actionIndexBlade()
	{
		$modal = Cache::remember('active_modal', 60, function () {
			return ModalSetting::where('is_active', true)
				->where('start_date', '<=', now())
				->where('end_date', '>=', now())
				->first();
		});

		return view('home.index', compact('modal'));
	}

	public function actionGallery()
	{
		$imagesByInstitution = TImage::with([
			'tWater.tInstitution.tDistrict.tProvince',
			'tWater.tInstitution.tUgel'
		])
			->whereNotNull('urlImage1')
			->orderBy('created_at', 'desc')
			->get()
			->groupBy('tWater.tInstitution.name');

		$videos = TVideo::all();

		return view('home/gallery', [
			'imagesByInstitution' => $imagesByInstitution,
			'videos' => $videos
		]);
	}

	public function actionRutaAguaAbancay()
	{
		return view('home/ruta_agua_abancay');
	}

	// public function actioncontent()
	// {
	// 	$contents = TContent::all();
	// 	return view('home/content', ['contents' => $contents]);
	// }
	public function actionContent()
	{
		$categoryIcons = [
			'Canciones' => '<i class="fas fa-music" style="color: #e91e63; font-size: 2rem;"></i>',
			'Cuentos y Relatos' => '<i class="fas fa-book-open" style="color: #ff9800; font-size: 2rem;"></i>',
			'Artículos Educativos' => '<i class="fas fa-graduation-cap" style="color: #2196f3; font-size: 2rem;"></i>',
			'Guías y Manuales' => '<i class="fas fa-clipboard-list" style="color: #4caf50; font-size: 2rem;"></i>',
			'Infografías y Carteles' => '<i class="fas fa-palette" style="color: #9c27b0; font-size: 2rem;"></i>',
			'Juegos y Actividades' => '<i class="fas fa-gamepad" style="color: #f44336; font-size: 2rem;"></i>',
			'Experimentos Caseros' => '<i class="fas fa-flask" style="color: #ffeb3b; font-size: 2rem;"></i>',
			'Noticias' => '<i class="fas fa-newspaper" style="color: #607d8b; font-size: 2rem;"></i>',
			'Importancia del Agua' => '<i class="fas fa-tint" style="color: #00bcd4; font-size: 2rem;"></i>',
			'El Agua para Consumo Humano' => '<i class="fas fa-glass-whiskey" style="color: #03a9f4; font-size: 2rem;"></i>',
			'Otros Usos del Agua' => '<i class="fas fa-water" style="color: #009688; font-size: 2rem;"></i>',
			'Garantizando la Calidad del Agua' => '<i class="fas fa-shield-alt" style="color: #8bc34a; font-size: 2rem;"></i>',
			'Tensiones en Torno al Agua' => '<i class="fas fa-balance-scale" style="color: #ff5722; font-size: 2rem;"></i>',
			'El Uso Responsable del Agua' => '<i class="fas fa-recycle" style="color: #4caf50; font-size: 2rem;"></i>',
			'Fascículos 1' => '<i class="fas fa-file-alt" style="color: #795548; font-size: 2rem;"></i>',
			'Fascículos 2' => '<i class="fas fa-file-pdf" style="color: #9e9e9e; font-size: 2rem;"></i>',
			'Fascículos 3' => '<i class="fas fa-scroll" style="color: #607d8b; font-size: 2rem;"></i>',
			'Fascículos 4' => '<i class="fas fa-file-contract" style="color: #795548; font-size: 2rem;"></i>',
			'Fascículos 5' => '<i class="fas fa-bookmark" style="color: #9e9e9e; font-size: 2rem;"></i>',
			'Fascículos 6' => '<i class="fas fa-file-invoice" style="color: #607d8b; font-size: 2rem;"></i>'
		];
		$contents = DB::table('tcontent')
			->where('status', 1)
			->whereNotNull('published_at')
			->where('published_at', '<=', now())
			->whereNotNull('category')
			->where('category', '!=', '')
			->orderBy('is_featured', 'desc')
			->orderBy('sort_order', 'asc')
			->get()
			->groupBy('category');

		$videos = DB::table('tvideo')
			->where('status', 1)
			->whereNotNull('category')
			->where('category', '!=', '')
			->orderBy('sort_order', 'asc')
			->get()
			->groupBy('category');

		$categoriesWithContent = [];
		foreach ($contents as $category => $categoryContents) {
			$categoriesWithContent[$category] = [
				'icon' => $categoryIcons[$category] ?? '<i class="fas fa-folder" style="color: #9e9e9e; font-size: 2rem;"></i>',
				'contents' => $categoryContents,
				'videos' => $videos[$category] ?? collect()
			];
		}
		foreach ($videos as $category => $categoryVideos) {
			if (!isset($categoriesWithContent[$category])) {
				$categoriesWithContent[$category] = [
					'icon' => $categoryIcons[$category] ?? '<i class="fas fa-folder" style="color: #9e9e9e; font-size: 2rem;"></i>',
					'contents' => collect(),
					'videos' => $categoryVideos
				];
			}
		}

		return view('home.content', compact('categoriesWithContent'));
	}

	public function actioncontentDetail($id)
	{
		$content = TContent::where('id', $id)->first();
		$video = TVideo::where('id', $id)->first();
		return view('home/content_detail', ['content' => $content, 'video' => $video]);
	}

	public function actionInstitution()
	{
		$provinces = TProvince::with(['tDistrict.tInstitution'])->get();

		$totalInstitutions = $provinces->sum(function ($province) {
			return $province->tDistrict->sum(function ($district) {
				return $district->tInstitution->count();
			});
		});

		return view('home.institution', compact('provinces', 'totalInstitutions'));
	}

	public function actionIndexAdmin(Request $request)
	{
		// Permitir cambiar mes, año y semana via parámetros GET
		$selectedMonth = $request->get('month', date('m'));
		$selectedYear = $request->get('year', date('Y'));
		$selectedWeek = $request->get('week', null);
		
		// Mes en texto (como lo guardas en BD) + año
		$monthsEs = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'];
		$monthName = $monthsEs[(int)$selectedMonth - 1];
		$year = $selectedYear;
		
		// Calcular semana actual del mes si no se especifica
		if (!$selectedWeek) {
			$today = date('Y-m-d');
			$firstOfMonth = date('Y-m-01', strtotime($today));
			$currentWeek = (int)date('W', strtotime($today)) - (int)date('W', strtotime($firstOfMonth)) + 1;
			if ($currentWeek < 1) $currentWeek = 1;
			if ($currentWeek > 5) $currentWeek = 5;
		} else {
			$currentWeek = (int) $selectedWeek;
		}

		// Usuario logueado (para filtros de Supervisor)
		$tUser = \App\Models\TUser::find(\Illuminate\Support\Facades\Session::get('idUser'));
		$userRole     = $tUser->role ?? null;
		$userLevel    = $tUser->level ?? null;
		$userProvince = $tUser->idProvince ?? null;
		$userDistrict = $tUser->idDistrict ?? null;

		// Query (misma estructura que tu getall, pero SOLO mes actual)
		$q = \Illuminate\Support\Facades\DB::table('twater')
			->select([
				'tinstitution.idInstitution as id',
				'tinstitution.name as nombre',
				'tinstitution.lender as prestador',
				'tugel.name as ugel',
				'tdistrict.name as distrito',
				'tprovince.name as provincia',
				'twater.month as mes',
				'twater.resultW1',
				'twater.resultW2',
				'twater.resultW3',
				'twater.resultW4',
				'twater.resultW5',
				'twater.created_at',
				'twater.updated_at',
			])
			->join('tinstitution', 'twater.idInstitution', '=', 'tinstitution.idInstitution')
			->leftJoin('tugel', 'tinstitution.idUgel', '=', 'tugel.idUgel')
			->join('tdistrict', 'tinstitution.idDistrict', '=', 'tdistrict.idDistrict')
			->join('tprovince', 'tdistrict.idProvince', '=', 'tprovince.idProvince')
			->where('twater.month', $monthName)               // mes en texto
			->whereYear('twater.created_at', $year)           // año del registro
			// último registro por institución
			->whereRaw('twater.updated_at = (
            SELECT MAX(sub_w.updated_at)
            FROM twater as sub_w
            WHERE sub_w.idInstitution = twater.idInstitution
        )');

		// Filtros por rol/nivel (soporto tu typo 'levelDistrit' por si acaso)
		if ($userRole === 'Supervisor' && $userLevel === 'levelProvince' && $userProvince) {
			$q->where('tprovince.idProvince', $userProvince);
		}
		if ($userRole === 'Supervisor' && ($userLevel === 'levelDistrict' || $userLevel === 'levelDistrit') && $userDistrict) {
			$q->where('tdistrict.idDistrict', $userDistrict);
		}
		// HACK: Filtro por UGEL usando blockingReason
		if (!empty($tUser->blockingReason)) {
			$ugel = \App\Models\TUgel::find($tUser->blockingReason);
			if ($ugel) {
				$q->where('tinstitution.idUgel', $tUser->blockingReason);
			}
		}

		$listTWater = $q->orderBy('twater.updated_at', 'desc')->get();

		// (Opcional) Fallback: si no hay datos del mes actual, mostrar mes anterior
		if ($listTWater->isEmpty()) {
			$prev = now()->subMonth();
			$prevMonthName = $monthsEs[(int)$prev->format('m') - 1];
			$prevYear      = (int)$prev->format('Y');

			$q2 = \Illuminate\Support\Facades\DB::table('twater')
				->select([
					'tinstitution.idInstitution as id',
					'tinstitution.name as nombre',
					'tinstitution.lender as prestador',
					'tugel.name as ugel',
					'tdistrict.name as distrito',
					'tprovince.name as provincia',
					'twater.month as mes',
					'twater.resultW1',
					'twater.resultW2',
					'twater.resultW3',
					'twater.resultW4',
					'twater.resultW5',
					'twater.created_at',
					'twater.updated_at',
				])
				->join('tinstitution', 'twater.idInstitution', '=', 'tinstitution.idInstitution')
				->leftJoin('tugel', 'tinstitution.idUgel', '=', 'tugel.idUgel')
				->join('tdistrict', 'tinstitution.idDistrict', '=', 'tdistrict.idDistrict')
				->join('tprovince', 'tdistrict.idProvince', '=', 'tprovince.idProvince')
				->where('twater.month', $prevMonthName)
				->whereYear('twater.created_at', $prevYear)
				->whereRaw('twater.updated_at = (
                SELECT MAX(sub_w.updated_at)
                FROM twater as sub_w
                WHERE sub_w.idInstitution = twater.idInstitution
            )');

			if ($userRole === 'Supervisor' && $userLevel === 'levelProvince' && $userProvince) {
				$q2->where('tprovince.idProvince', $userProvince);
			}
			if ($userRole === 'Supervisor' && ($userLevel === 'levelDistrict' || $userLevel === 'levelDistrit') && $userDistrict) {
				$q2->where('tdistrict.idDistrict', $userDistrict);
			}
			// HACK: Filtro por UGEL usando blockingReason (fallback)
			if (!empty($tUser->blockingReason)) {
				$ugel = \App\Models\TUgel::find($tUser->blockingReason);
				if ($ugel) {
					$q2->where('tinstitution.idUgel', $tUser->blockingReason);
				}
			}

			$listTWater = $q2->orderBy('twater.updated_at', 'desc')->get();
		}

		// Datos para el mapa de calor (usando el mes/año/semana seleccionados)
		$mapData = $this->getMapData($monthName, $year, $currentWeek);

		return view('index/indexadmin', compact('listTWater', 'mapData', 'tUser'));
	}



	public function actionIndexAdminCurrentMonth()
	{

		$monthsEs = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'];
		$monthName = $monthsEs[(int)date('m') - 1];
		$year      = date('Y');

		$tUser = TUser::find(Session::get('idUser'));
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
				'twater.resultW1',
				'twater.resultW2',
				'twater.resultW3',
				'twater.resultW4',
				'twater.resultW5',
				'twater.created_at',
				'twater.updated_at',
			])
			->join('tinstitution', 'twater.idInstitution', '=', 'tinstitution.idInstitution')
			->leftJoin('tugel', 'tinstitution.idUgel', '=', 'tugel.idUgel')
			->join('tdistrict', 'tinstitution.idDistrict', '=', 'tdistrict.idDistrict')
			->join('tprovince', 'tdistrict.idProvince', '=', 'tprovince.idProvince')
			// SOLO mes actual (por texto + año de created_at)
			->where('twater.month', $monthName)
			->whereYear('twater.created_at', $year)
			// último registro por institución
			->whereRaw('twater.updated_at = (
                SELECT MAX(sub_w.updated_at)
                FROM twater as sub_w
                WHERE sub_w.idInstitution = twater.idInstitution
            )');

		if ($userRole === 'Supervisor' && ($userLevel === 'levelProvince')) {
			if ($userProvince) $q->where('tprovince.idProvince', $userProvince);
		}
		if ($userRole === 'Supervisor' && ($userLevel === 'levelDistrict' || $userLevel === 'levelDistrit')) {
			if ($userDistrict) $q->where('tdistrict.idDistrict', $userDistrict);
		}

		$listTWater = $q->orderBy('twater.updated_at', 'desc')->get();

		if ($listTWater->isEmpty()) {
			$prev = now()->subMonth();
			$prevMonthName = $monthsEs[(int)$prev->format('m') - 1];
			$prevYear      = $prev->format('Y');

			$q2 = DB::table('twater')
				->select([
					'tinstitution.idInstitution as id',
					'tinstitution.name as nombre',
					'tinstitution.lender as prestador',
					'tugel.name as ugel',
					'tdistrict.name as distrito',
					'tprovince.name as provincia',
					'twater.month as mes',
					'twater.resultW1',
					'twater.resultW2',
					'twater.resultW3',
					'twater.resultW4',
					'twater.resultW5',
					'twater.created_at',
					'twater.updated_at',
				])
				->join('tinstitution', 'twater.idInstitution', '=', 'tinstitution.idInstitution')
				->leftJoin('tugel', 'tinstitution.idUgel', '=', 'tugel.idUgel')
				->join('tdistrict', 'tinstitution.idDistrict', '=', 'tdistrict.idDistrict')
				->join('tprovince', 'tdistrict.idProvince', '=', 'tprovince.idProvince')
				->where('twater.month', $prevMonthName)
				->whereYear('twater.created_at', $prevYear)
				->whereRaw('twater.updated_at = (
                    SELECT MAX(sub_w.updated_at)
                    FROM twater as sub_w
                    WHERE sub_w.idInstitution = twater.idInstitution
                )');

			if ($userRole === 'Supervisor' && ($userLevel === 'levelProvince')) {
				if ($userProvince) $q2->where('tprovince.idProvince', $userProvince);
			}
			if ($userRole === 'Supervisor' && ($userLevel === 'levelDistrict' || $userLevel === 'levelDistrit')) {
				if ($userDistrict) $q2->where('tdistrict.idDistrict', $userDistrict);
			}

			$listTWater = $q2->orderBy('twater.updated_at', 'desc')->get();
		}

		return view('index/indexadmin', compact('listTWater'));
	}


	public function actionExportNonReporting(Request $request)
    {
        $scope = $request->get('scope', 'month'); // 'month' | 'week'

        $monthsEs  = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'];
        $monthName = $monthsEs[(int)date('m') - 1];
        $year      = (int)date('Y');

        // Semana "del mes" como en tu WaterController
        $today          = date('Y-m-d');
        $firstOfMonth   = date('Y-m-01', strtotime($today));
        $currentWeek    = (int)date('W', strtotime($today)) - (int)date('W', strtotime($firstOfMonth)) + 1;
        if ($currentWeek < 1) $currentWeek = 1;
        if ($currentWeek > 5) $currentWeek = 5;

        // Alcance por usuario
        $tUser        = TUser::find(Session::get('idUser'));
        $userRole     = $tUser->role ?? null;
        $userLevel    = $tUser->level ?? null;
        $userProvince = $tUser->idProvince ?? null;
        $userDistrict = $tUser->idDistrict ?? null;

        // Todas las instituciones del alcance
        $qInst = TInstitution::with(['tdistrict.tprovince','tugel']);
        if ($userRole === 'Supervisor' && $userLevel === 'levelProvince' && $userProvince) {
            $qInst->whereHas('tdistrict.tprovince', fn($q)=>$q->where('idProvince',$userProvince));
        }
        if ($userRole === 'Supervisor' && ($userLevel === 'levelDistrict' || $userLevel === 'levelDistrit') && $userDistrict) {
            $qInst->whereHas('tdistrict', fn($q)=>$q->where('idDistrict',$userDistrict));
        }
        $instituciones = $qInst->get();
        $ids = $instituciones->pluck('idInstitution')->all();

        // Último registro por institución del MES ACTUAL
        $waters = TWater::whereIn('idInstitution', $ids)
            ->where('month', $monthName)
            ->whereYear('created_at', $year)
            ->orderBy('updated_at','desc')
            ->get()
            ->unique('idInstitution')                 // nos quedamos con el más reciente
            ->keyBy('idInstitution');

        $rows = [];
        foreach ($instituciones as $inst) {
            $w = $waters->get($inst->idInstitution);

            $sinMes = false;
            $sinSemana = false;

            if (!$w) {
                $sinMes = true;
                $sinSemana = true;
            } else {
                // Mes sin reportes = todas las semanas -1
                $reportadas = 0;
                for ($i=1; $i<=5; $i++) {
                    $f = "resultW{$i}";
                    if (isset($w->$f) && $w->$f != -1) $reportadas++;
                }
                $sinMes = ($reportadas === 0);

                // Semana actual sin reporte
                $fw = "resultW{$currentWeek}";
                $sinSemana = !isset($w->$fw) || $w->$fw == -1;
            }

            $agregar = ($scope === 'week') ? $sinSemana : $sinMes;

            if ($agregar) {
                $rows[] = [
                    $inst->tugel->name ?? 'Sin UGEL',
                    $inst->name,
                    $inst->lender,
                    $inst->tdistrict->tprovince->name ?? '',
                    $inst->tdistrict->name ?? '',
                    $year,
                    $monthName,
                    $scope === 'week' ? $currentWeek : '-',
                    $scope === 'week' ? 'Sin reporte en semana actual' : 'Sin reportes en el mes',
                ];
            }
        }

        $title = $scope === 'week'
            ? "Semana {$currentWeek} — {$monthName} {$year}"
            : "Mes actual — {$monthName} {$year}";

        $filename = $scope === 'week'
            ? "no_reportantes_semana_{$currentWeek}_{$monthName}_{$year}.xlsx"
            : "no_reportantes_mes_{$monthName}_{$year}.xlsx";

        return Excel::download(new NonReportingExport($rows, $title), $filename);
    }

    public function actionExportWithReporting(Request $request)
    {
        $scope = $request->get('scope', 'month'); // 'month' | 'week'

        $monthsEs  = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'];
        $monthName = $monthsEs[(int)date('m') - 1];
        $year      = (int)date('Y');

        // Semana "del mes" como en tu WaterController
        $today          = date('Y-m-d');
        $firstOfMonth   = date('Y-m-01', strtotime($today));
        $currentWeek    = (int)date('W', strtotime($today)) - (int)date('W', strtotime($firstOfMonth)) + 1;
        if ($currentWeek < 1) $currentWeek = 1;
        if ($currentWeek > 5) $currentWeek = 5;

        // Alcance por usuario
        $tUser        = TUser::find(Session::get('idUser'));
        $userRole     = $tUser->role ?? null;
        $userLevel    = $tUser->level ?? null;
        $userProvince = $tUser->idProvince ?? null;
        $userDistrict = $tUser->idDistrict ?? null;

        // Todas las instituciones del alcance
        $qInst = TInstitution::with(['tdistrict.tprovince','tugel']);
        if ($userRole === 'Supervisor' && $userLevel === 'levelProvince' && $userProvince) {
            $qInst->whereHas('tdistrict.tprovince', fn($q)=>$q->where('idProvince',$userProvince));
        }
        if ($userRole === 'Supervisor' && ($userLevel === 'levelDistrict' || $userLevel === 'levelDistrit') && $userDistrict) {
            $qInst->whereHas('tdistrict', fn($q)=>$q->where('idDistrict',$userDistrict));
        }
        $instituciones = $qInst->get();
        $ids = $instituciones->pluck('idInstitution')->all();

        // Último registro por institución del MES ACTUAL
        $waters = TWater::whereIn('idInstitution', $ids)
            ->where('month', $monthName)
            ->whereYear('created_at', $year)
            ->orderBy('updated_at','desc')
            ->get()
            ->unique('idInstitution')                 // nos quedamos con el más reciente
            ->keyBy('idInstitution');

        $rows = [];
        foreach ($instituciones as $inst) {
            $w = $waters->get($inst->idInstitution);

            $conMes = false;
            $conSemana = false;

            if ($w) {
                // Mes con reportes = al menos una semana reportada
                $reportadas = 0;
                $sumAll = 0;
                $countAll = 0;
                for ($i=1; $i<=5; $i++) {
                    $f = "resultW{$i}";
                    if (isset($w->$f) && $w->$f != -1) {
                        $reportadas++;
                        $sumAll += $w->$f;
                        $countAll++;
                    }
                }
                $conMes = ($reportadas > 0);

                // Semana actual con reporte
                $fw = "resultW{$currentWeek}";
                $conSemana = isset($w->$fw) && $w->$fw != -1;

                $promedio = $countAll > 0 ? round($sumAll / $countAll, 2) : 0;
                $estado = ($promedio < 0.5 || $promedio > 5) ? 'Inadecuado' : 'Bueno';

                $incluir = ($scope === 'week') ? $conSemana : $conMes;

                if ($incluir) {
                    $rows[] = [
                        $inst->tugel->name ?? 'Sin UGEL',
                        $inst->name,
                        $inst->lender,
                        $inst->tdistrict->tprovince->name ?? '',
                        $inst->tdistrict->name ?? '',
                        $year,
                        $monthName,
                        $w->resultW1 != -1 ? number_format($w->resultW1, 1, '.') : '-',
                        $w->resultW2 != -1 ? number_format($w->resultW2, 1, '.') : '-',
                        $w->resultW3 != -1 ? number_format($w->resultW3, 1, '.') : '-',
                        $w->resultW4 != -1 ? number_format($w->resultW4, 1, '.') : '-',
                        $w->resultW5 != -1 ? number_format($w->resultW5, 1, '.') : '-',
                        number_format($promedio, 2, '.'),
                        $estado,
                    ];
                }
            }
        }

        $title = $scope === 'week'
            ? "Semana {$currentWeek} — {$monthName} {$year}"
            : "Mes actual — {$monthName} {$year}";

        $filename = $scope === 'week'
            ? "con_reportes_semana_{$currentWeek}_{$monthName}_{$year}.xlsx"
            : "con_reportes_mes_{$monthName}_{$year}.xlsx";

        return Excel::download(new WithReportingExport($rows, $title), $filename);
    }

    private function getMapData($monthName = null, $year = null, $week = null)
    {
        // Si no se proporcionan parámetros, usar mes, año y semana actual
        if (!$monthName || !$year) {
            $monthsEs = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'];
            $monthName = $monthsEs[(int)date('m') - 1];
            $year = (int)date('Y');
        }
        
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
            ->get();

        $mapData = [];
        foreach ($institutions as $institution) {
            // Buscar el último registro de agua para esta institución del mes actual
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
                    $color = '#FF0000'; // 🔴 Rojo - CRÍTICO
                    $status = 'CRÍTICO';
                    $description = 'Por debajo del mínimo absoluto - Riesgo microbiológico muy alto';
                } elseif ($weekValue >= 0.3 && $weekValue < 0.5) {
                    $color = '#FF8C00'; // 🟠 Naranja - DEFICIENTE
                    $status = 'DEFICIENTE';
                    $description = 'Entre mínimo absoluto y obligatorio - Requiere acciones correctivas';
                } elseif ($weekValue >= 0.5 && $weekValue <= 2.0) {
                    $color = '#00FF00'; // 🟢 Verde - ÓPTIMO
                    $status = 'ÓPTIMO';
                    $description = 'Rango operacional ideal - Cumple normativa peruana';
                } elseif ($weekValue > 2.0 && $weekValue <= 5.0) {
                    $color = '#0000FF'; // 🔵 Azul - ALTO
                    $status = 'ALTO';
                    $description = 'Nivel alto pero dentro de norma - Monitorear sabor/olor';
                } else { // > 5.0
                    $color = '#800080'; // 🟣 Morado - EXCESIVO
                    $status = 'EXCESIVO';
                    $description = 'Excede límite máximo - Incumple DS 031-2010-SA';
                }
            }

            $mapData[] = [
                'name' => $institution->name,
                'lat' => (float)$institution->latitude,
                'lng' => (float)$institution->longitude,
                'weekValue' => $weekValue,
                'week' => $week,
                'status' => $status,
                'color' => $color,
                'description' => $description,
                'district' => $institution->tdistrict->name ?? '',
                'province' => $institution->tdistrict->tprovince->name ?? '',
                'lender' => $institution->lender ?? '',
                'ugel' => $institution->tugel->name ?? 'Sin UGEL'
            ];
        }

        return $mapData;
    }

}

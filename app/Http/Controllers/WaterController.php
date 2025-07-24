<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Export\DataExport;
use App\Models\TInstitution;
use App\Validation\WaterValidation;
use App\Export\WaterDetailedExport;

use Illuminate\Support\Facades\DB;

use App\Models\TImage;
use App\Models\TWater;
use App\Models\TUser;
use DateTime;

class WaterController extends Controller
{
	public function actionInsert(Request $request, SessionManager $sessionManager)
	{
		$listMonth = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'];

		$currentMonth = $listMonth[intval(date('m')) - 1];
		$currentWeek = date('W', strtotime(date('Y-m-d'))) - date('W', strtotime(date('Y-m-01', strtotime(date('Y-m-d'))))) + 1;
		$currentDate = date('d-m-Y');

		if ($_POST) {
			try {
				DB::beginTransaction();

				$this->_so->mo->listMessage = (new WaterValidation())->validationInsert($request);

				if ($this->_so->mo->existsMessage()) {
					DB::rollBack();

					return PlatformHelper::redirectError($this->_so->mo->listMessage, 'water/insert');
				}

				$tUser = TUser::with(['tinstitutiontuser.tinstitution.tdistrict.tprovince'])->whereRaw('idUser=?', [$sessionManager->get('idUser')])->first();

				if (count($tUser->tinstitutiontuser) == 0) {
					return PlatformHelper::redirectError([], 'user/logout');
				}

				$tWater = TWater::whereRaw('year(created_at)=? and idInstitution=? and month=?', [date('Y'), $tUser->tinstitutiontuser[0]->tinstitution->idInstitution, $currentMonth])->first();

				if ($tWater == null) {
					$tWater = new TWater();

					$tWater->idWater = uniqid();
					$tWater->idUser = $sessionManager->get('idUser');
					$tWater->idInstitution = $tUser->tinstitutiontuser[0]->tinstitution->idInstitution;
					$tWater->month = $currentMonth;
					$tWater->resultW1 = -1;
					$tWater->resultW2 = -1;
					$tWater->resultW3 = -1;
					$tWater->resultW4 = -1;
					$tWater->resultW5 = -1;
					$tWater->status = 'Activo';
				}

				switch ($currentWeek) {
					case 1:
						if ($tWater->resultW1 != -1) {
							DB::rollBack();

							return PlatformHelper::redirectError(['Ya existe registro para la semana de este mes en el año actual.'], 'water/insert');
						}

						$tWater->resultW1 = trim($request->input('txtResult'));

						break;

					case 2:
						if ($tWater->resultW2 != -1) {
							DB::rollBack();

							return PlatformHelper::redirectError(['Ya existe registro para la semana de este mes en el año actual.'], 'water/insert');
						}

						$tWater->resultW2 = trim($request->input('txtResult'));

						break;

					case 3:
						if ($tWater->resultW3 != -1) {
							DB::rollBack();

							return PlatformHelper::redirectError(['Ya existe registro para la semana de este mes en el año actual.'], 'water/insert');
						}

						$tWater->resultW3 = trim($request->input('txtResult'));

						break;

					case 4:
						if ($tWater->resultW4 != -1) {
							DB::rollBack();

							return PlatformHelper::redirectError(['Ya existe registro para la semana de este mes en el año actual.'], 'water/insert');
						}

						$tWater->resultW4 = trim($request->input('txtResult'));

						break;

					case 5:
						if ($tWater->resultW5 != -1) {
							DB::rollBack();

							return PlatformHelper::redirectError(['Ya existe registro para la semana de este mes en el año actual.'], 'water/insert');
						}

						$tWater->resultW5 = trim($request->input('txtResult'));

						break;
				}

				$tWater->save();

				$images = $request->file('images');
				$imagePaths = [];

				if ($images) {
					foreach ($images as $key => $image) {
						if ($key < 3) { // Máximo 3 imágenes
							// Genera un nombre único para la imagen
							$filename = uniqid() . '.' . $image->getClientOriginalExtension();

							// Define la ruta completa para guardar la imagen
							$path = public_path('img/water/' . $filename);

							// Mueve la imagen a la carpeta especificada
							$image->move(public_path('img/water'), $filename);

							// Almacena la ruta relativa de la imagen
							$imagePaths[] = 'img/water/' . $filename;
						}
					}
				}

				// Guardar en tImages
				$tImage = new TImage();
				$tImage->idImage = uniqid();
				$tImage->idWater = $tWater->idWater;
				$tImage->type = 'medicion';
				$tImage->urlImage1 = $imagePaths[0] ?? null;
				$tImage->urlImage2 = $imagePaths[1] ?? null;
				$tImage->urlImage3 = $imagePaths[2] ?? null;
				$tImage->created_at = now();
				$tImage->updated_at = now();
				$tImage->save();

				DB::commit();

				return PlatformHelper::redirectCorrect(['Operación ralizada correctamente.'], 'water/insert');
			} catch (\Exception $e) {
				DB::rollBack();

				return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		$tUser = TUser::with(['tinstitutiontuser.tinstitution.tdistrict.tprovince'])->whereRaw('idUser=?', [$sessionManager->get('idUser')])->first();

		if (count($tUser->tinstitutiontuser) == 0) {
			return PlatformHelper::redirectError([], 'user/logout');
		}

		$listTWater = TWater::whereHas('tinstitution', function ($sq1) use ($tUser) {
			$sq1->whereRaw('idInstitution=?', [$tUser->tinstitutiontuser[0]->tinstitution->idInstitution]);
		})->orderByRaw('created_at desc')->take(12)->get();

		foreach ($listTWater as $value) {
			$sumForAverage = 0;
			$divForAverage = 0;

			if ($value->resultW1 != -1) {
				$sumForAverage += $value->resultW1;
				$divForAverage++;
			}

			if ($value->resultW2 != -1) {
				$sumForAverage += $value->resultW2;
				$divForAverage++;
			}

			if ($value->resultW3 != -1) {
				$sumForAverage += $value->resultW3;
				$divForAverage++;
			}

			if ($value->resultW4 != -1) {
				$sumForAverage += $value->resultW4;
				$divForAverage++;
			}

			if ($value->resultW5 != -1) {
				$sumForAverage += $value->resultW5;
				$divForAverage++;
			}

			$value->average = $divForAverage = 0 ? 0 : number_format($sumForAverage / $divForAverage, 4, '.');
		}

		$currentNumberMonth = intval(date('m')) - 1;
		$listMonthToGraphic = [];

		for ($i = 11; $i >= 0; $i--) {
			$listMonthToGraphic[] = $listMonth[$currentNumberMonth >= 0 ? $currentNumberMonth : ($currentNumberMonth + 12)];

			$currentNumberMonth--;
		}

		$listMonthToGraphic = array_reverse($listMonthToGraphic);

		$listDataToGraphic = [];

		foreach ($listMonthToGraphic as $value) {
			$tempData = null;

			foreach ($listTWater as $item) {
				if ($value == $item->month) {
					$tempData = $item;

					break 1;
				}
			}

			if ($tempData != null) {
				$listDataToGraphic[] = $tempData->average;
			} else {
				$listDataToGraphic[] = 0;
			}
		}

		return view(
			'water/insert',
			[
				'tUser' => $tUser,
				'currentMonth' => $currentMonth,
				'currentWeek' => $currentWeek,
				'currentDate' => $currentDate,
				'listMonthToGraphic' => $listMonthToGraphic,
				'listDataToGraphic' => $listDataToGraphic
			]
		);
	}

	public function actionGetAll(Request $request)
	{
		// Obtener el rol y la provincia del usuario
		$tUser = TUser::find(Session::get('idUser'));
		$userRole = $tUser->role;
		$userLevel = $tUser->level;
		$userProvince = $tUser->idProvince;
		$userDistrict = $tUser->idDistrict;

		$query = TWater::select([
			'tinstitution.idInstitution as id',
			'tinstitution.name as nombre',
			'tinstitution.lender as prestador',
			'tugel.name as ugel',  // AGREGAR ESTA LÍNEA
			'tdistrict.name as distrito',
			'tprovince.name as provincia',
			'twater.month as mes',
			'twater.resultW1',
			'twater.resultW2',
			'twater.resultW3',
			'twater.resultW4',
			'twater.resultW5',
			'twater.created_at'
		])
			->join('tinstitution', 'twater.idInstitution', '=', 'tinstitution.idInstitution')
			->leftJoin('tugel', DB::raw('tinstitution.idUgel COLLATE utf8mb4_unicode_ci'), '=', DB::raw('tugel.idUgel COLLATE utf8mb4_unicode_ci'))  // CORREGIR COLLATION
			->join('tdistrict', 'tinstitution.idDistrict', '=', 'tdistrict.idDistrict')
			->join('tprovince', 'tdistrict.idProvince', '=', 'tprovince.idProvince')
			->whereRaw('twater.updated_at = (
			SELECT MAX(sub_w.updated_at)
			FROM twater as sub_w
			WHERE sub_w.idInstitution = twater.idInstitution
		)')
			->get();

		// Si el usuario es Supervisor, filtrar por su provincia
		if ($userRole === 'Supervisor' && $userLevel === 'levelProvince') {
			$query = TWater::select([
				'tinstitution.idInstitution as id',
				'tinstitution.name as nombre',
				'tinstitution.lender as prestador',
				'tugel.name as ugel',  // AGREGAR ESTA LÍNEA
				'tdistrict.name as distrito',
				'tprovince.name as provincia',
				'twater.month as mes',
				'twater.resultW1',
				'twater.resultW2',
				'twater.resultW3',
				'twater.resultW4',
				'twater.resultW5',
				'twater.created_at'
			])
				->join('tinstitution', 'twater.idInstitution', '=', 'tinstitution.idInstitution')
				->leftJoin('tugel', 'tinstitution.idUgel', '=', 'tugel.idUgel')  // AGREGAR ESTA LÍNEA
				->join('tdistrict', 'tinstitution.idDistrict', '=', 'tdistrict.idDistrict')
				->join('tprovince', 'tdistrict.idProvince', '=', 'tprovince.idProvince')
				->where('tprovince.idProvince', '=', $userProvince)
				->whereRaw('twater.updated_at = (
				SELECT MAX(sub_w.updated_at)
				FROM twater as sub_w
				WHERE sub_w.idInstitution = twater.idInstitution
			)')
				->get();
		}

		// Si el usuario es Supervisor, filtrar por su distrito
		if ($userRole === 'Supervisor' && $userLevel === 'levelDistrit') {
			$query = TWater::select([
				'tinstitution.idInstitution as id',
				'tinstitution.name as nombre',
				'tinstitution.lender as prestador',
				'tugel.name as ugel',  // AGREGAR ESTA LÍNEA
				'tdistrict.name as distrito',
				'tprovince.name as provincia',
				'twater.month as mes',
				'twater.resultW1',
				'twater.resultW2',
				'twater.resultW3',
				'twater.resultW4',
				'twater.resultW5',
				'twater.created_at'
			])
				->join('tinstitution', 'twater.idInstitution', '=', 'tinstitution.idInstitution')
				->leftJoin('tugel', 'tinstitution.idUgel', '=', 'tugel.idUgel')  // AGREGAR ESTA LÍNEA
				->join('tdistrict', 'tinstitution.idDistrict', '=', 'tdistrict.idDistrict')
				->join('tprovince', 'tdistrict.idProvince', '=', 'tprovince.idProvince')
				->where('tdistrict.idDistrict', '=', $userDistrict)
				->whereRaw('twater.updated_at = (
				SELECT MAX(sub_w.updated_at)
				FROM twater as sub_w
				WHERE sub_w.idInstitution = twater.idInstitution
			)')
				->get();
		}

		return view('water/getall', [
			'listTWater' => $query
		]);
	}


	public function actionExport(Request $request)
	{
		$searchParameter = $request->has('searchParameter') ? $request->input('searchParameter') : '';

		// Obtener el rol y la provincia del usuario
		$tUser = TUser::find(Session::get('idUser'));
		$userRole = $tUser->role;
		$userLevel = $tUser->level;
		$userProvince = $tUser->idProvince;
		$userDistrict = $tUser->idDistrict;

		// Inicializar la consulta con UGEL incluida
		$query = TWater::with(['tinstitution.tdistrict.tprovince', 'tinstitution.tugel'])  // MODIFICAR ESTA LÍNEA
			->where(function ($q) use ($searchParameter) {
				$q->whereHas('tinstitution', function ($sq1) use ($searchParameter) {
					$sq1->whereRaw('compareFind(name, ?, 77)=1', [$searchParameter]);
				})->orWhereRaw('compareFind(month, ?, 77)=1', [$searchParameter]);
			});

		// Si el usuario es Supervisor, filtrar por su provincia
		if ($userRole === 'Supervisor' && $userLevel === 'levelProvince') {
			$query->whereHas('tinstitution.tdistrict.tprovince', function ($sq2) use ($userProvince) {
				$sq2->where('idProvince', $userProvince);
			});
		}

		// Si el usuario es Supervisor, filtrar por su Distrito
		if ($userRole === 'Supervisor' && $userLevel === 'levelDistrit') {
			$query->whereHas('tinstitution.tdistrict.tprovince', function ($sq2) use ($userDistrict) {
				$sq2->where('idDistrict', $userDistrict);
			});
		}

		$listTWater = $query->orderByRaw('created_at desc')->get();

		foreach ($listTWater as $value) {
			$sumForAverage = 0;
			$divForAverage = 0;

			// Calcular el promedio
			for ($i = 1; $i <= 5; $i++) {
				$result = "resultW$i";
				if ($value->$result > -1) {
					$sumForAverage = $value->$result;
					$divForAverage++;
				}
			}

			// Calcular el promedio correctamente
			$value->average = $sumForAverage;
		}

		// Preparar los datos para la exportación - MODIFICAR ESTA SECCIÓN
		$data = [];
		$data[] = [
			'UGEL',              // NUEVA COLUMNA PRIMERA
			'Institución',
			'Prestador',
			'Provincia',
			'Distrito',
			'Periodo año',
			'Periodo mes',
			'MCR S. 1',
			'MCR S. 2',
			'MCR S. 3',
			'MCR S. 4',
			'MCR S. 5',
			'Ultima Medicion',
			'Estado'
		];

		foreach ($listTWater as $value) {
			$data[] = [
				$value->tinstitution->tugel->name ?? 'Sin UGEL',  // NUEVA COLUMNA CON DATOS
				$value->tinstitution->name,
				$value->tinstitution->lender,
				$value->tinstitution->tdistrict->tprovince->name,
				$value->tinstitution->tdistrict->name,
				substr($value->created_at, 0, 4),
				$value->month,
				($value->resultW1 != -1 ? number_format($value->resultW1, 1, '.') : '-'),
				($value->resultW2 != -1 ? number_format($value->resultW2, 1, '.') : '-'),
				($value->resultW3 != -1 ? number_format($value->resultW3, 1, '.') : '-'),
				($value->resultW4 != -1 ? number_format($value->resultW4, 1, '.') : '-'),
				($value->resultW5 != -1 ? number_format($value->resultW5, 1, '.') : '-'),
				$value->average,
				($value->average < 0.5 || $value->average > 1) ? 'Inadecuado' : 'Bueno'
			];
		}

		// Devolver el archivo de Excel
		return Excel::download(new DataExport($data), 'waterExport.xlsx');
	}



	public function getWaterDetail($id)
	{
		// Obtener el mes y año actual
		$currentMonth = now()->format('m'); // Mes actual en formato 01-12
		$currentYear = now()->format('Y'); // Año actual

		// Filtrar los registros de los últimos 6 meses
		$data = TWater::select([
			'twater.month',
			'twater.resultW1',
			'twater.resultW2',
			'twater.resultW3',
			'twater.resultW4',
			'twater.resultW5',
			'twater.updated_at' // Asegurarse de incluir updated_at para el filtrado
		])
			->join('tinstitution', 'twater.idInstitution', '=', 'tinstitution.idInstitution')
			->where('twater.idInstitution', '=', $id)
			->whereBetween('twater.updated_at', [now()->subMonths(5)->startOfMonth(), now()->endOfMonth()])
			->orderBy('twater.updated_at', 'ASC')
			->get();

		// Formatear los datos para Chart.js
		$formattedData = [];
		$months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'];

		// Inicializar todos los meses con valores predeterminados
		foreach ($months as $month) {
			$formattedData[$month] = [
				'resultW1' => 0,
				'resultW2' => 0,
				'resultW3' => 0,
				'resultW4' => 0,
				'resultW5' => 0,
			];
		}

		// Reemplazar los datos con los valores reales
		$sixMonthsAgo = now()->subMonths(5)->startOfMonth();
		foreach ($data as $record) {
			$recordDate = \Carbon\Carbon::parse($record->updated_at);
			if ($recordDate->gte($sixMonthsAgo)) {
				$month = $months[(int)$recordDate->format('m') - 1];

				$formattedData[$month] = [
					'resultW1' => max(0, $record->resultW1),
					'resultW2' => max(0, $record->resultW2),
					'resultW3' => max(0, $record->resultW3),
					'resultW4' => max(0, $record->resultW4),
					'resultW5' => max(0, $record->resultW5),
				];
			}
		}

		// Filtrar solo los últimos 6 meses en chartLabels y chartData
		$last6Months = [];
		$chartLabels = [];
		for ($i = 5; $i >= 0; $i--) {
			$date = now()->subMonths($i);
			$monthLabelSpanish = $this->getSpanishMonth($date->format('F'));
			$formattedLabel = "{$monthLabelSpanish} {$date->format('Y')}";

			$last6Months[$formattedLabel] = $formattedData[$monthLabelSpanish] ?? [
				'resultW1' => 0,
				'resultW2' => 0,
				'resultW3' => 0,
				'resultW4' => 0,
				'resultW5' => 0,
			];

			$chartLabels[] = $formattedLabel;
		}

		$chartData = [
			'resultW1' => array_column($last6Months, 'resultW1'),
			'resultW2' => array_column($last6Months, 'resultW2'),
			'resultW3' => array_column($last6Months, 'resultW3'),
			'resultW4' => array_column($last6Months, 'resultW4'),
			'resultW5' => array_column($last6Months, 'resultW5'),
		];

		$institution = TInstitution::select(['idInstitution', 'name', 'lender'])
			->where('idInstitution', $id)
			->first();

		$images = TImage::select([
			'timage.urlImage1',
			'timage.urlImage2',
			'timage.urlImage3',
			'timage.created_at'
		])
			->join('twater', 'timage.idWater', '=', 'twater.idWater')
			->where('twater.idInstitution', '=', $id)
			->orderBy('timage.created_at', 'DESC')
			->get();

		$formattedImages = $images->map(function ($image) {
			$formattedDate = (new DateTime($image->created_at))->format('d F Y');
			$spanishMonth = $this->getSpanishMonth(date('F', strtotime($image->created_at)));
			$image->formatted_date = str_replace(date('F', strtotime($image->created_at)), $spanishMonth, $formattedDate);
			return $image;
		});
		//dd($formattedImages);
		return view('water.detail', compact('chartLabels', 'chartData', 'institution', 'formattedImages'));
	}

	// Función para convertir el mes en inglés a español
	private function getSpanishMonth($month)
	{
		$monthTranslations = [
			'January' => 'Enero',
			'February' => 'Febrero',
			'March' => 'Marzo',
			'April' => 'Abril',
			'May' => 'Mayo',
			'June' => 'Junio',
			'July' => 'Julio',
			'August' => 'Agosto',
			'September' => 'Setiembre',
			'October' => 'Octubre',
			'November' => 'Noviembre',
			'December' => 'Diciembre',
		];

		return $monthTranslations[$month] ?? $month; // Devolver el mes en español
	}

	public function actionExportDetailed(Request $request)
	{
		try {
			$trimestre = $request->input('trimestre', '1');
			$year = $request->input('year', date('Y'));

			$trimestresMeses = [
				'1' => ['Enero', 'Febrero', 'Marzo'],
				'2' => ['Abril', 'Mayo', 'Junio'],
				'3' => ['Julio', 'Agosto', 'Setiembre'],
				'4' => ['Octubre', 'Noviembre', 'Diciembre']
			];

			$mesesTrimestre = $trimestresMeses[$trimestre];
			$tUser = TUser::find(Session::get('idUser'));
			$userRole = $tUser->role;
			$userLevel = $tUser->level;
			$userProvince = $tUser->idProvince;
			$userDistrict = $tUser->idDistrict;

			$queryInstituciones = TInstitution::with(['tdistrict.tprovince', 'tugel']);
			if ($userRole === 'Supervisor' && $userLevel === 'levelProvince') {
				$queryInstituciones->whereHas('tdistrict.tprovince', function ($sq) use ($userProvince) {
					$sq->where('idProvince', $userProvince);
				});
			} elseif ($userRole === 'Supervisor' && $userLevel === 'levelDistrit') {
				$queryInstituciones->whereHas('tdistrict', function ($sq) use ($userDistrict) {
					$sq->where('idDistrict', $userDistrict);
				});
			}

			$todasLasInstituciones = $queryInstituciones->get();
			$queryWater = TWater::whereIn('month', $mesesTrimestre)
				->whereYear('created_at', $year);
			if ($userRole === 'Supervisor' && $userLevel === 'levelProvince') {
				$queryWater->whereHas('tinstitution.tdistrict.tprovince', function ($sq) use ($userProvince) {
					$sq->where('idProvince', $userProvince);
				});
			} elseif ($userRole === 'Supervisor' && $userLevel === 'levelDistrit') {
				$queryWater->whereHas('tinstitution.tdistrict', function ($sq) use ($userDistrict) {
					$sq->where('idDistrict', $userDistrict);
				});
			}

			$datosWater = $queryWater->get();
			$datosWaterPorInstitucion = [];
			foreach ($datosWater as $water) {
				$idInst = $water->idInstitution;
				if (!isset($datosWaterPorInstitucion[$idInst])) {
					$datosWaterPorInstitucion[$idInst] = [];
				}
				$datosWaterPorInstitucion[$idInst][$water->month] = $water;
			}
			$institucionesConReportes = [];
			$institucionesSinReportes = [];

			foreach ($todasLasInstituciones as $institucion) {
				$idInst = $institucion->idInstitution;
				$tieneReportes = isset($datosWaterPorInstitucion[$idInst]) && count($datosWaterPorInstitucion[$idInst]) > 0;

				$datosInst = [
					'institucion' => $institucion,
					'datos' => $datosWaterPorInstitucion[$idInst] ?? []
				];

				if ($tieneReportes) {
					$institucionesConReportes[] = $datosInst;
				} else {
					$institucionesSinReportes[] = $datosInst;
				}
			}

			$instituciones = array_merge($institucionesConReportes, $institucionesSinReportes);

			$data = [];
			$headers = ['N°', 'UGEL', 'Institución', 'Prestador', 'Provincia', 'Distrito'];
			for ($i = 0; $i < 15; $i++) {
				$headers[] = '';
			}

			$headers = array_merge($headers, ['Observaciones', 'Situación Final']);
			$data[] = $headers;
			$contador = 1;
			foreach ($instituciones as $instData) {
				$inst = $instData['institucion'];
				$datosInst = $instData['datos'];

				$fila = [
					$contador++,
					$inst->tugel->name ?? 'Sin UGEL',
					$inst->name,
					$inst->lender,
					$inst->tdistrict->tprovince->name,
					$inst->tdistrict->name
				];
				$totalSemanas = 0;
				$semanasReportadas = 0;
				$sumaTotalValores = 0;
				$totalValores = 0;

				foreach ($mesesTrimestre as $mes) {
					$water = isset($datosInst[$mes]) ? $datosInst[$mes] : null;

					for ($semana = 1; $semana <= 5; $semana++) {
						$totalSemanas++;
						$campo = "resultW$semana";

						if ($water && $water->$campo != -1) {
							$fila[] = number_format($water->$campo, 1, '.');
							$semanasReportadas++;
							$sumaTotalValores += $water->$campo;
							$totalValores++;
						} else {
							$fila[] = '-';
						}
					}
				}
				$porcentajeReporte = ($semanasReportadas / $totalSemanas) * 100;
				$promedioValores = $totalValores > 0 ? $sumaTotalValores / $totalValores : 0;

				$observaciones = $this->calcularObservaciones($porcentajeReporte, $semanasReportadas);
				$situacionFinal = $this->calcularSituacionFinal($promedioValores, $porcentajeReporte);

				$fila[] = $observaciones;
				$fila[] = $situacionFinal;

				$data[] = $fila;
			}
			return Excel::download(
				new WaterDetailedExport($data, $mesesTrimestre),
				"reporte_detallado_trimestre_{$trimestre}_{$year}.xlsx"
			);
		} catch (\Exception $e) {
			return PlatformHelper::redirectError('Error al exportar: ' . $e->getMessage(), 'water/getall');
		}
	}

	private function calcularObservaciones($porcentajeReporte, $semanasReportadas)
	{
		if ($semanasReportadas == 0) {
			return 'Nunca subió sus reportes';
		} elseif ($porcentajeReporte < 30) {
			return 'Muy pocas semanas reportó';
		} elseif ($porcentajeReporte < 50) {
			return 'Pocas semanas reportó';
		} elseif ($porcentajeReporte < 80) {
			return 'Algunas semanas no reportó';
		} elseif ($porcentajeReporte < 100) {
			return 'Varias semanas no reportó';
		} else {
			return 'Reportó todas las semanas';
		}
	}

	private function calcularSituacionFinal($promedio, $porcentajeReporte)
	{
		if ($porcentajeReporte == 0) {
			return 'No se conoce la calidad del agua - Sin reportes';
		} elseif ($promedio == 0) {
			return 'Su reporte de cloro residual quedó en inadecuado';
		} elseif ($promedio < 0.5) {
			return 'Su reporte de cloro residual quedó en inadecuado';
		} elseif ($promedio >= 0.5 && $promedio <= 1.0) {
			return 'Su reporte muestra avances positivos en cloro residual';
		} else {
			return 'Su reporte de cloro residual presenta inconsistencias';
		}
	}
}

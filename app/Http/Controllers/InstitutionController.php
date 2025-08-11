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
use App\Export\InstitutionDataExport;

class InstitutionController extends Controller
{
	public function actionGetAll(Request $request, $currentPage)
	{
		$searchParameter = $request->has('searchParameter') ? $request->input('searchParameter') : '';

		$paginate = PlatformHelper::preparePaginate(
			TInstitution::with(['tdistrict.tprovince', 'tugel'])
				->whereRaw('compareFind(name, ?, 77)=1', [$searchParameter])
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
			$institution = TInstitution::with(['tdistrict.tprovince', 'tugel'])->findOrFail($idInstitution);
			$listTDistrict = TDistrict::with('tprovince')->orderBy('name', 'asc')->get();
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
			->whereRaw('compareFind(name, ?, 77)=1', [$searchParameter])
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
				'tConfigurationFmMdl' => null
			]);
		}
	}
}

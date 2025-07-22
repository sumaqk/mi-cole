<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use Illuminate\Http\Request;
use App\Models\TUgel;
use App\Models\TProvince;
use App\Models\TDistrict;
use App\Models\TConfiguration;
use Illuminate\Support\Facades\DB;

class UgelController extends Controller
{
    public function actionGetAll(Request $request, $currentPage)
    {
        $searchParameter = $request->has('searchParameter') ? $request->input('searchParameter') : '';

        $paginate = PlatformHelper::preparePaginate(
            TUgel::with(['tProvince', 'tDistrict'])
                ->whereRaw('compareFind(name, ?, 77)=1', [$searchParameter])
                ->orderByRaw('created_at desc'), 
            7, 
            $currentPage
        );


        $tConfigurationFmMdl = TConfiguration::first();

        return view('ugel/getall', [
            'listTUgel' => $paginate['listRow'],
            'currentPage' => $paginate['currentPage'],
            'quantityPage' => $paginate['quantityPage'],
            'searchParameter' => $searchParameter,
            'tConfigurationFmMdl' => $tConfigurationFmMdl
        ]);
    }


    public function actionInsert(Request $request)
    {
        if($request->isMethod('post'))
        {
            try
            {
                DB::beginTransaction();
                
                if(!$request->has('name') || trim($request->input('name')) == '')
                {
                    return PlatformHelper::redirectError('El nombre es requerido.', 'ugel/insert');
                }
                
                if(!$request->has('code') || trim($request->input('code')) == '')
                {
                    return PlatformHelper::redirectError('El código es requerido.', 'ugel/insert');
                }

                $existingUgel = TUgel::where('code', strtoupper(trim($request->input('code'))))->first();
                if($existingUgel)
                {
                    return PlatformHelper::redirectError('El código ya existe.', 'ugel/insert');
                }
                
                $tUgel = new TUgel();
                $tUgel->idUgel = uniqid();
                $tUgel->name = trim($request->input('name'));
                $tUgel->code = strtoupper(trim($request->input('code')));
                $tUgel->idProvince = $request->input('idProvince');
                $tUgel->idDistrict = $request->input('idDistrict');
                $tUgel->address = trim($request->input('address')) ?: null;
                $tUgel->phone = trim($request->input('phone')) ?: null;
                $tUgel->email = trim($request->input('email')) ?: null;
                $tUgel->director = trim($request->input('director')) ?: null;
                $tUgel->is_active = true;
                $tUgel->save();
                
                DB::commit();
                
                return PlatformHelper::redirectCorrect('UGEL creada correctamente.', 'ugel/getall/1');
            }
            catch(\Exception $e)
            {
                DB::rollback();
                return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'ugel/insert');
            }
        }
        
        try {
            $listTProvince = TProvince::orderBy('name', 'asc')->get();
            $tConfigurationFmMdl = TConfiguration::first();
            
            return view('ugel/insert', [
                'listTProvince' => $listTProvince,
                'tConfigurationFmMdl' => $tConfigurationFmMdl
            ]);
            
        } catch (\Exception $e) {
            return view('ugel/insert', [
                'listTProvince' => collect([]),
                'tConfigurationFmMdl' => null
            ]);
        }
    }


    public function actionGetDistricts(Request $request)
    {
        try {
            $districts = TDistrict::where('idProvince', $request->input('idProvince'))
                                ->orderBy('name', 'asc')
                                ->get(['idDistrict', 'name']);

            return response()->json([
                'success' => true,
                'districts' => $districts
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener distritos'
            ]);
        }
    }


    public function actionDelete(Request $request, $idUgel)
    {
        try {
            DB::beginTransaction();
            
            $ugel = TUgel::findOrFail($idUgel);
            

            if ($ugel->tInstitution()->count() > 0) {
                return PlatformHelper::redirectError('No se puede eliminar la UGEL porque tiene instituciones asociadas.', 'ugel/getall/1');
            }

            $ugel->delete();
            
            DB::commit();
            
            return PlatformHelper::redirectCorrect('UGEL eliminada correctamente.', 'ugel/getall/1');

        } catch (\Exception $e) {
            DB::rollback();
            return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'ugel/getall/1');
        }
    }


    public function actionToggleStatus(Request $request, $idUgel)
    {
        try {
            DB::beginTransaction();
            
            $ugel = TUgel::findOrFail($idUgel);
            $ugel->is_active = !$ugel->is_active;
            $ugel->save();

            $status = $ugel->is_active ? 'activada' : 'desactivada';
            
            DB::commit();
            
            return PlatformHelper::redirectCorrect('UGEL ' . $status . ' correctamente.', 'ugel/getall/1');

        } catch (\Exception $e) {
            DB::rollback();
            return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'ugel/getall/1');
        }
    }


    public function actionEdit(Request $request, $idUgel)
    {
        try {
            $ugel = TUgel::findOrFail($idUgel);
            $listTProvince = TProvince::orderBy('name', 'asc')->get();
            $listTDistrict = TDistrict::where('idProvince', $ugel->idProvince)->orderBy('name', 'asc')->get();
            $tConfigurationFmMdl = TConfiguration::first();
            
            return view('ugel/edit', [
                'ugel' => $ugel,
                'listTProvince' => $listTProvince,
                'listTDistrict' => $listTDistrict,
                'tConfigurationFmMdl' => $tConfigurationFmMdl
            ]);
            
        } catch (\Exception $e) {
            return PlatformHelper::redirectError('UGEL no encontrada.', 'ugel/getall/1');
        }
    }


    public function actionUpdate(Request $request, $idUgel)
    {
        try {
            DB::beginTransaction();
            
            $ugel = TUgel::findOrFail($idUgel);
            
            if(!$request->has('name') || trim($request->input('name')) == '') {
                return PlatformHelper::redirectError('El nombre es requerido.', 'ugel/edit/' . $idUgel);
            }
            
            if(!$request->has('code') || trim($request->input('code')) == '') {
                return PlatformHelper::redirectError('El código es requerido.', 'ugel/edit/' . $idUgel);
            }


            $existingUgel = TUgel::where('code', strtoupper(trim($request->input('code'))))
                                 ->where('idUgel', '!=', $idUgel)
                                 ->first();
            if($existingUgel) {
                return PlatformHelper::redirectError('El código ya existe.', 'ugel/edit/' . $idUgel);
            }
            
            $ugel->name = trim($request->input('name'));
            $ugel->code = strtoupper(trim($request->input('code')));
            $ugel->idProvince = $request->input('idProvince');
            $ugel->idDistrict = $request->input('idDistrict');
            $ugel->address = trim($request->input('address')) ?: null;
            $ugel->phone = trim($request->input('phone')) ?: null;
            $ugel->email = trim($request->input('email')) ?: null;
            $ugel->director = trim($request->input('director')) ?: null;
            $ugel->save();
            
            DB::commit();
            
            return PlatformHelper::redirectCorrect('UGEL actualizada correctamente.', 'ugel/getall/1');
            
        } catch (\Exception $e) {
            DB::rollback();
            return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'ugel/edit/' . $idUgel);
        }
    }
}
?>
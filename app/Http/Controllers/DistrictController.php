<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\TDistrict;
use App\Models\TProvince;
use App\Models\TConfiguration;

class DistrictController extends Controller
{
    public function actionGetAll(Request $request, $currentPage)
    {
        $searchParameter = $request->has('searchParameter') ? $request->input('searchParameter') : '';

        $paginate = PlatformHelper::preparePaginate(
            TDistrict::with(['tprovince'])
                ->whereRaw('compareFind(name, ?, 77)=1', [$searchParameter])
                ->orderByRaw('created_at desc'), 
            7, 
            $currentPage
        );

        $tConfigurationFmMdl = TConfiguration::first();

        return view('district/getall', [
            'listTDistrict' => $paginate['listRow'],
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
                    return PlatformHelper::redirectError('El nombre del distrito es requerido.', 'district/insert');
                }
                
                if(!$request->has('idProvince') || trim($request->input('idProvince')) == '')
                {
                    return PlatformHelper::redirectError('La provincia es requerida.', 'district/insert');
                }


                $existingDistrict = TDistrict::where('name', trim($request->input('name')))
                                           ->where('idProvince', $request->input('idProvince'))
                                           ->first();
                if($existingDistrict)
                {
                    return PlatformHelper::redirectError('Ya existe un distrito con este nombre en esta provincia.', 'district/insert');
                }
                
                $tDistrict = new TDistrict();
                $tDistrict->idDistrict = uniqid();
                $tDistrict->idProvince = $request->input('idProvince');
                $tDistrict->code = trim($request->input('code')) ?: '';
                $tDistrict->name = trim($request->input('name'));
                $tDistrict->save();
                
                DB::commit();
                
                return PlatformHelper::redirectCorrect('Distrito creado correctamente.', 'district/getall/1');
            }
            catch(\Exception $e)
            {
                DB::rollback();
                return PlatformHelper::redirectError('Error: ' . $e->getMessage(), 'district/insert');
            }
        }
        
        $listTProvince = TProvince::orderBy('name', 'asc')->get();
        $tConfigurationFmMdl = TConfiguration::first();
        
        return view('district/insert', [
            'listTProvince' => $listTProvince,
            'tConfigurationFmMdl' => $tConfigurationFmMdl
        ]);
    }

    public function actionEdit(Request $request, $idDistrict)
    {
        try {
            $district = TDistrict::with(['tprovince'])->findOrFail($idDistrict);
            $listTProvince = TProvince::orderBy('name', 'asc')->get();
            $tConfigurationFmMdl = TConfiguration::first();
            
            return view('district/edit', [
                'district' => $district,
                'listTProvince' => $listTProvince,
                'tConfigurationFmMdl' => $tConfigurationFmMdl
            ]);
            
        } catch (\Exception $e) {
            return PlatformHelper::redirectError('Distrito no encontrado.', 'district/getall/1');
        }
    }

    public function actionUpdate(Request $request, $idDistrict)
    {
        try {
            DB::beginTransaction();
            
            $district = TDistrict::findOrFail($idDistrict);
            
            if(!$request->has('name') || trim($request->input('name')) == '') {
                return PlatformHelper::redirectError('El nombre del distrito es requerido.', 'district/edit/' . $idDistrict);
            }
            
            if(!$request->has('idProvince') || trim($request->input('idProvince')) == '') {
                return PlatformHelper::redirectError('La provincia es requerida.', 'district/edit/' . $idDistrict);
            }


            $existingDistrict = TDistrict::where('name', trim($request->input('name')))
                                       ->where('idProvince', $request->input('idProvince'))
                                       ->where('idDistrict', '!=', $idDistrict)
                                       ->first();
            if($existingDistrict) {
                return PlatformHelper::redirectError('Ya existe otro distrito con este nombre en esta provincia.', 'district/edit/' . $idDistrict);
            }
            
            $district->name = trim($request->input('name'));
            $district->idProvince = $request->input('idProvince');
            $district->code = trim($request->input('code')) ?: '';
            $district->save();
            
            DB::commit();
            
            return PlatformHelper::redirectCorrect('Distrito actualizado correctamente.', 'district/getall/1');
            
        } catch (\Exception $e) {
            DB::rollback();
            return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'district/edit/' . $idDistrict);
        }
    }

    public function actionDelete(Request $request, $idDistrict)
    {
        try {
            DB::beginTransaction();
            
            $district = TDistrict::findOrFail($idDistrict);
            

            if ($district->tinstitution()->count() > 0) {
                return PlatformHelper::redirectError('No se puede eliminar el distrito porque tiene instituciones asociadas.', 'district/getall/1');
            }

            $district->delete();
            
            DB::commit();
            
            return PlatformHelper::redirectCorrect('Distrito eliminado correctamente.', 'district/getall/1');

        } catch (\Exception $e) {
            DB::rollback();
            return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'district/getall/1');
        }
    }

    public function actionChgToInsertWater(Request $request)
    {
        $listTDistrict = TDistrict::whereHas('tprovince', function($sq1) use($request) {
            $sq1->whereRaw('idProvince=?', [$request->input('idProvince')]);
        })->get();

        $this->_so->dto->listTDistrict = $listTDistrict;
        $this->_so->mo->success();

        return response()->json($this->_so);
    }
}
?>
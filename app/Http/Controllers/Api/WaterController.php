<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TImage;
use App\Models\TInstitution;
use App\Models\TUser;
use App\Models\TWater;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WaterController extends Controller
{
    private array $months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'];

    private function currentWeek(): int
    {
        $week = (int)date('W', strtotime(date('Y-m-d')))
              - (int)date('W', strtotime(date('Y-m-01', strtotime(date('Y-m-d'))))) + 1;

        return max(1, min(5, $week));
    }

    public function store(Request $request)
    {
        $request->validate(['result' => 'required|numeric|min:0']);

        $tUser = TUser::with(['tinstitutiontuser.tinstitution'])->find($request->user()->idUser);

        if (!$tUser || $tUser->tinstitutiontuser->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Sin institución asignada.'], 403);
        }

        $currentMonth = $this->months[intval(date('m')) - 1];
        $currentWeek  = $this->currentWeek();
        $idInstitution = $tUser->tinstitutiontuser[0]->idInstitution;

        try {
            DB::beginTransaction();

            $tWater = TWater::whereYear('created_at', date('Y'))
                ->where('idInstitution', $idInstitution)
                ->where('month', $currentMonth)
                ->first();

            if (!$tWater) {
                $tWater = new TWater();
                $tWater->idWater      = uniqid();
                $tWater->idUser       = $tUser->idUser;
                $tWater->idInstitution = $idInstitution;
                $tWater->month        = $currentMonth;
                $tWater->resultW1     = -1;
                $tWater->resultW2     = -1;
                $tWater->resultW3     = -1;
                $tWater->resultW4     = -1;
                $tWater->resultW5     = -1;
                $tWater->status       = 'Activo';
            }

            $field = "resultW{$currentWeek}";

            if ($tWater->$field != -1) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Ya existe registro para esta semana.'], 409);
            }

            $tWater->$field = $request->result;
            $tWater->save();

            $imagePaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $key => $image) {
                    if ($key >= 3) break;
                    $filename     = uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('img/water'), $filename);
                    $imagePaths[] = 'img/water/' . $filename;
                }
            }

            $tImage             = new TImage();
            $tImage->idImage    = uniqid();
            $tImage->idWater    = $tWater->idWater;
            $tImage->type       = 'medicion';
            $tImage->urlImage1  = $imagePaths[0] ?? null;
            $tImage->urlImage2  = $imagePaths[1] ?? null;
            $tImage->urlImage3  = $imagePaths[2] ?? null;
            $tImage->created_at = now();
            $tImage->updated_at = now();
            $tImage->save();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Registro guardado correctamente.', 'data' => $tWater]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function index(Request $request)
    {
        $tUser = $request->user();

        if (!empty($tUser->blockingReason)) {
            $query = TInstitution::select([
                'tinstitution.idInstitution as id',
                'tinstitution.name as nombre',
                'tinstitution.lender as prestador',
                'tugel.name as ugel',
                'tdistrict.name as distrito',
                'tprovince.name as provincia',
                'twater.month as mes',
                DB::raw('COALESCE(twater.resultW1, -1) as resultW1'),
                DB::raw('COALESCE(twater.resultW2, -1) as resultW2'),
                DB::raw('COALESCE(twater.resultW3, -1) as resultW3'),
                DB::raw('COALESCE(twater.resultW4, -1) as resultW4'),
                DB::raw('COALESCE(twater.resultW5, -1) as resultW5'),
                'twater.created_at',
            ])
                ->leftJoin('twater', function ($join) {
                    $join->on('tinstitution.idInstitution', '=', 'twater.idInstitution')
                         ->whereRaw('twater.updated_at = (SELECT MAX(s.updated_at) FROM twater s WHERE s.idInstitution = tinstitution.idInstitution)');
                })
                ->leftJoin('tugel', 'tinstitution.idUgel', '=', 'tugel.idUgel')
                ->join('tdistrict', 'tinstitution.idDistrict', '=', 'tdistrict.idDistrict')
                ->join('tprovince', 'tdistrict.idProvince', '=', 'tprovince.idProvince')
                ->where('tinstitution.idUgel', $tUser->blockingReason)
                ->get();
        } else {
            $query = TWater::select([
                'tinstitution.idInstitution as id',
                'tinstitution.name as nombre',
                'tinstitution.lender as prestador',
                'tugel.name as ugel',
                'tdistrict.name as distrito',
                'tprovince.name as provincia',
                'twater.month as mes',
                'twater.resultW1', 'twater.resultW2', 'twater.resultW3', 'twater.resultW4', 'twater.resultW5',
                'twater.created_at',
            ])
                ->join('tinstitution', 'twater.idInstitution', '=', 'tinstitution.idInstitution')
                ->leftJoin('tugel', 'tinstitution.idUgel', '=', 'tugel.idUgel')
                ->join('tdistrict', 'tinstitution.idDistrict', '=', 'tdistrict.idDistrict')
                ->join('tprovince', 'tdistrict.idProvince', '=', 'tprovince.idProvince')
                ->whereRaw('twater.updated_at = (SELECT MAX(s.updated_at) FROM twater s WHERE s.idInstitution = twater.idInstitution)');

            if ($tUser->role === 'Supervisor' && $tUser->level === 'levelProvince') {
                $query->where('tprovince.idProvince', $tUser->idProvince);
            }
            if ($tUser->role === 'Supervisor' && in_array($tUser->level, ['levelDistrict', 'levelDistrit'])) {
                $query->where('tdistrict.idDistrict', $tUser->idDistrict);
            }

            $query = $query->get();
        }

        return response()->json(['success' => true, 'data' => $query]);
    }

    public function show($id)
    {
        $sixMonthsAgo = now()->subMonths(5)->startOfMonth();

        $data = TWater::select(['twater.month', 'twater.resultW1', 'twater.resultW2', 'twater.resultW3', 'twater.resultW4', 'twater.resultW5', 'twater.updated_at'])
            ->join('tinstitution', 'twater.idInstitution', '=', 'tinstitution.idInstitution')
            ->where('twater.idInstitution', $id)
            ->whereBetween('twater.updated_at', [$sixMonthsAgo, now()->endOfMonth()])
            ->orderBy('twater.updated_at', 'ASC')
            ->get();

        $formattedData = [];
        foreach ($this->months as $month) {
            $formattedData[$month] = ['resultW1' => 0, 'resultW2' => 0, 'resultW3' => 0, 'resultW4' => 0, 'resultW5' => 0];
        }

        foreach ($data as $record) {
            $recordDate = \Carbon\Carbon::parse($record->updated_at);
            if ($recordDate->gte($sixMonthsAgo)) {
                $month = $this->months[(int)$recordDate->format('m') - 1];
                $formattedData[$month] = [
                    'resultW1' => max(0, $record->resultW1),
                    'resultW2' => max(0, $record->resultW2),
                    'resultW3' => max(0, $record->resultW3),
                    'resultW4' => max(0, $record->resultW4),
                    'resultW5' => max(0, $record->resultW5),
                ];
            }
        }

        $last6Months  = [];
        $chartLabels  = [];
        for ($i = 5; $i >= 0; $i--) {
            $date       = now()->subMonths($i);
            $monthLabel = $this->months[(int)$date->format('m') - 1];
            $label      = "{$monthLabel} {$date->format('Y')}";
            $last6Months[$label] = $formattedData[$monthLabel] ?? ['resultW1' => 0, 'resultW2' => 0, 'resultW3' => 0, 'resultW4' => 0, 'resultW5' => 0];
            $chartLabels[] = $label;
        }

        $chartData = [
            'resultW1' => array_column($last6Months, 'resultW1'),
            'resultW2' => array_column($last6Months, 'resultW2'),
            'resultW3' => array_column($last6Months, 'resultW3'),
            'resultW4' => array_column($last6Months, 'resultW4'),
            'resultW5' => array_column($last6Months, 'resultW5'),
        ];

        $institution = TInstitution::select(['idInstitution', 'name', 'lender'])->find($id);

        if (!$institution) {
            return response()->json(['success' => false, 'message' => 'Institución no encontrada.'], 404);
        }

        $images = TImage::select(['timage.urlImage1', 'timage.urlImage2', 'timage.urlImage3', 'timage.created_at'])
            ->join('twater', 'timage.idWater', '=', 'twater.idWater')
            ->where('twater.idInstitution', $id)
            ->orderBy('timage.created_at', 'DESC')
            ->get();

        return response()->json([
            'success'     => true,
            'data'        => [
                'institution' => $institution,
                'chartLabels' => $chartLabels,
                'chartData'   => $chartData,
                'images'      => $images,
            ],
        ]);
    }

    public function currentStatus(Request $request)
    {
        $tUser = $request->user();

        if ($tUser->tinstitutiontuser()->exists()) {
            $institution = $tUser->tinstitutiontuser()->first();
            $currentMonth = $this->months[intval(date('m')) - 1];
            $currentWeek  = $this->currentWeek();

            $tWater = TWater::whereYear('created_at', date('Y'))
                ->where('idInstitution', $institution->idInstitution)
                ->where('month', $currentMonth)
                ->first();

            return response()->json([
                'success' => true,
                'data'    => [
                    'currentMonth' => $currentMonth,
                    'currentWeek'  => $currentWeek,
                    'currentDate'  => date('d-m-Y'),
                    'water'        => $tWater,
                ],
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Sin institución asignada.'], 403);
    }
}

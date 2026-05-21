<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Export\InstitutionFullExport;
use App\Export\UserSheetExport;
use App\Models\TDistrict;
use App\Models\TInstitutionTUser;
use App\Models\TProvince;
use App\Models\TUgel;
use App\Models\TUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search  = $request->get('search', '');
        $perPage = $request->get('per_page', 200);

        $query = TUser::with(['tInstitutionTUser.tInstitution'])
            ->selectRaw('*, (SELECT COUNT(*) FROM twater WHERE twater.idUser = tuser.idUser) as water_count')
            ->whereRaw("CONCAT(firstName, ' ', surName, ' ', email) LIKE ?", ['%' . $search . '%'])
            ->orderBy('firstName');

        $users = $query->paginate($perPage);

        return response()->json(['success' => true, 'data' => $users]);
    }

    public function show($id)
    {
        $user = TUser::with(['tInstitutionTUser.tInstitution'])->find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Usuario no encontrado.'], 404);
        }

        return response()->json(['success' => true, 'data' => $user]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstName' => 'required|string|max:100',
            'surName'   => 'required|string|max:100',
            'email'     => 'required|email|unique:tuser,email',
            'password'  => 'required|string|min:6',
            'role'      => 'required|array',
        ]);

        try {
            DB::beginTransaction();

            $tUser                          = new TUser();
            $tUser->idUser                  = uniqid();
            $tUser->firstName               = trim($request->firstName);
            $tUser->surName                 = trim($request->surName);
            $tUser->email                   = trim($request->email);
            $tUser->password                = Hash::make($request->password);
            $tUser->avatarExtension         = 'png';
            $tUser->confirmCode             = '';
            $tUser->recoveryCode            = '';
            $tUser->recoveryExpirationDate  = '1991-01-01';
            $tUser->emailChangeCode         = '';
            $tUser->emailChangeExpirationDate = '1991-01-01';
            $tUser->registerType            = 'Plataforma';
            $tUser->blockingReason          = $request->ugelFilter ?? '';
            $tUser->lastAccess              = '1991-01-01';
            $tUser->role                    = implode(',', $request->role);
            $tUser->status                  = 'Activo';
            $tUser->level                   = $request->level ?? null;
            $tUser->idProvince              = $request->idProvince ?? null;
            $tUser->idDistrict              = $request->idDistrict ?? null;
            $tUser->save();

            copy(public_path('img/avatar/user.png'), public_path('img/avatar/' . $tUser->idUser . '.png'));

            if ($request->has('institutionIds') && is_array($request->institutionIds)) {
                foreach ($request->institutionIds as $idInstitution) {
                    if (empty(trim($idInstitution))) continue;
                    $rel                     = new TInstitutionTUser();
                    $rel->idInstitutionTUser = uniqid();
                    $rel->idInstitution      = $idInstitution;
                    $rel->idUser             = $tUser->idUser;
                    $rel->save();
                }
            }

            DB::commit();

            return response()->json(['success' => true, 'data' => $tUser], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $tUser = TUser::find($id);

        if (!$tUser) {
            return response()->json(['success' => false, 'message' => 'Usuario no encontrado.'], 404);
        }

        $request->validate([
            'firstName' => 'required|string|max:100',
            'surName'   => 'required|string|max:100',
            'email'     => 'required|email|unique:tuser,email,' . $id . ',idUser',
            'status'    => 'required|in:Activo,Pendiente,Bloqueado',
        ]);

        try {
            $oldRole      = $tUser->role;
            $tUser->firstName = trim($request->firstName);
            $tUser->surName   = trim($request->surName);
            $tUser->email     = trim($request->email);
            $tUser->status    = $request->status;

            if ($request->filled('password')) {
                $tUser->password = Hash::make($request->password);
            }

            if ($request->has('role')) {
                $newRole  = implode(',', (array)$request->role);
                $combined = str_contains($oldRole, 'Súper usuario')
                    ? ('Súper usuario' . ($newRole ? ',' . $newRole : ''))
                    : $newRole;
                $unique = implode(',', array_unique(array_filter(array_map('trim', explode(',', $combined)))));
                $tUser->role = $unique;
            }

            $tUser->save();

            return response()->json(['success' => true, 'data' => $tUser]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $tUser = TUser::find($id);

        if (!$tUser) {
            return response()->json(['success' => false, 'message' => 'Usuario no encontrado.'], 404);
        }

        if (str_contains($tUser->role, 'Súper usuario')) {
            return response()->json(['success' => false, 'message' => 'No se puede eliminar un súper usuario.'], 403);
        }

        $waterCount = DB::table('twater')->where('idUser', $id)->count();
        if ($waterCount > 0) {
            return response()->json(['success' => false, 'message' => "Tiene {$waterCount} registro(s) de agua, no se puede eliminar."], 409);
        }

        try {
            DB::beginTransaction();

            TInstitutionTUser::where('idUser', $id)->delete();

            $avatarPath = public_path('img/avatar/' . $tUser->idUser . '.' . $tUser->avatarExtension);
            if (file_exists($avatarPath)) {
                unlink($avatarPath);
            }

            $tUser->delete();
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Usuario eliminado.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|string|min:6|confirmed',
        ]);

        $tUser = $request->user();

        if (!Hash::check($request->current_password, $tUser->password)) {
            return response()->json(['success' => false, 'message' => 'Contraseña actual incorrecta.'], 422);
        }

        $tUser->password = Hash::make($request->new_password);
        $tUser->save();

        return response()->json(['success' => true, 'message' => 'Contraseña actualizada.']);
    }

    public function uploadAvatar(Request $request)
    {
        $request->validate(['avatar' => 'required|image|mimes:png,jpg,jpeg|max:700']);

        $tUser = $request->user();

        try {
            DB::beginTransaction();

            $oldAvatar = public_path('img/avatar/' . $tUser->idUser . '.' . $tUser->avatarExtension);
            if (file_exists($oldAvatar)) {
                unlink($oldAvatar);
            }

            $request->file('avatar')->move(public_path('img/avatar'), $tUser->idUser . '.png');

            $tUser->avatarExtension = 'png';
            $tUser->updated_at      = now();
            $tUser->save();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Avatar actualizado.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function toggleStatus($id)
    {
        $user = TUser::find($id);
        if (!$user) return response()->json(['success' => false, 'message' => 'Usuario no encontrado.'], 404);
        // El rol Súper usuario no se puede cambiar, pero su estado sí puede ser gestionado por un admin

        $user->status = $user->status === 'Activo' ? 'Bloqueado' : 'Activo';
        $user->save();

        return response()->json(['success' => true, 'data' => ['status' => $user->status]]);
    }

    public function adminResetPassword(Request $request, $id)
    {
        $request->validate(['password' => 'required|string|min:6']);

        $user = TUser::find($id);
        if (!$user) return response()->json(['success' => false, 'message' => 'Usuario no encontrado.'], 404);

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['success' => true, 'message' => 'Contraseña actualizada.']);
    }

    public function search(Request $request)
    {
        $q = $request->get('q', '');

        $users = TUser::whereRaw("CONCAT(firstName, surName, email) LIKE ? AND status = ?", ['%' . $q . '%', 'Activo'])
            ->orderBy('firstName')
            ->orderBy('surName')
            ->take(10)
            ->get(['idUser', 'firstName', 'surName', 'email', 'avatarExtension']);

        $result = $users->map(fn($u) => [
            'id'              => $u->idUser,
            'text'            => $u->firstName . ' ' . $u->surName . ' (' . explode('@', $u->email)[0] . ')',
            'idUser'          => $u->idUser,
            'email'           => $u->email,
            'fullName'        => $u->firstName . ' ' . $u->surName,
            'avatarExtension' => $u->avatarExtension,
        ]);

        return response()->json(['success' => true, 'data' => $result]);
    }

    public function exportAll()
    {
        $users = TUser::with(['tInstitutionTUser.tInstitution'])
            ->selectRaw('*, (SELECT COUNT(*) FROM twater WHERE twater.idUser = tuser.idUser) as water_count')
            ->whereRaw("role NOT LIKE '%Súper usuario%'")
            ->orderBy('firstName')
            ->get();

        $buildRow = function ($u, $n) {
            $institution = $u->tInstitutionTUser->first()?->tInstitution?->name ?? '—';
            $lastAccess  = (!$u->lastAccess || str_starts_with((string) $u->lastAccess, '1991'))
                ? '—'
                : \Carbon\Carbon::parse($u->lastAccess)->format('d/m/Y');
            return [
                $n,
                trim($u->firstName . ' ' . $u->surName),
                $u->email,
                $u->role,
                $institution,
                (int) $u->water_count,
                $lastAccess,
                $u->status,
            ];
        };

        $toRows = function ($collection) use ($buildRow) {
            return $collection->values()->map(fn ($u, $i) => $buildRow($u, $i + 1))->toArray();
        };

        $activos    = $users->filter(fn ($u) => $u->status === 'Activo');
        $bloqueados = $users->filter(fn ($u) => $u->status === 'Bloqueado');
        $pendientes = $users->filter(fn ($u) => $u->status === 'Pendiente');
        $sinReg     = $users->filter(fn ($u) => $u->water_count == 0);
        $sinInst    = $users->filter(fn ($u) => $u->tInstitutionTUser->isEmpty());

        $sheets = [
            new UserSheetExport($toRows($users),      'Todos',            '1570ef'),
            new UserSheetExport($toRows($activos),    'Activos',          '15803d'),
            new UserSheetExport($toRows($bloqueados), 'Bloqueados',       'b91c1c'),
            new UserSheetExport($toRows($pendientes), 'Pendientes',       'b45309'),
            new UserSheetExport($toRows($sinReg),     'Sin registros',    'ea580c'),
            new UserSheetExport($toRows($sinInst),    'Sin institución',  '7c3aed'),
        ];

        $filename = 'usuarios_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new InstitutionFullExport($sheets), $filename);
    }

    public function formOptions()
    {
        return response()->json([
            'success' => true,
            'data'    => [
                'provinces' => TProvince::orderBy('name')->get(['idProvince', 'name']),
                'ugels'     => TUgel::where('is_active', true)->orderBy('name')->get(['idUgel', 'name']),
            ],
        ]);
    }
}

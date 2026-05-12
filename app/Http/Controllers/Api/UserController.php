<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TDistrict;
use App\Models\TInstitutionTUser;
use App\Models\TProvince;
use App\Models\TUgel;
use App\Models\TUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search  = $request->get('search', '');
        $perPage = $request->get('per_page', 9);

        $users = TUser::whereRaw("CONCAT(firstName, surName, email, registerType) LIKE ?", ['%' . $search . '%'])
            ->orderByDesc('idUser')
            ->paginate($perPage);

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
                    $rel->status             = 'Activo';
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
                $newRole = implode(',', (array)$request->role);
                $tUser->role = str_contains($oldRole, 'Súper usuario')
                    ? ('Súper usuario' . ($newRole ? ',' . $newRole : ''))
                    : $newRole;
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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $tUser = TUser::where('email', trim($request->email))->first();

        if (!$tUser || !Hash::check($request->password, $tUser->password)) {
            return response()->json(['success' => false, 'message' => 'Credenciales incorrectas.'], 401);
        }

        if ($tUser->status === 'Bloqueado') {
            return response()->json(['success' => false, 'message' => 'Su usuario fue bloqueado.'], 403);
        }

        if ($tUser->status !== 'Activo') {
            return response()->json(['success' => false, 'message' => 'Su usuario no está activo o no confirmó su registro.'], 403);
        }

        $token = $tUser->createToken('api-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'token'   => $token,
            'user'    => $this->formatUser($tUser),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['success' => true, 'message' => 'Sesión cerrada.']);
    }

    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'data'    => $this->formatUser($request->user()),
        ]);
    }

    private function formatUser(TUser $tUser): array
    {
        return [
            'idUser'           => $tUser->idUser,
            'firstName'        => $tUser->firstName,
            'surName'          => $tUser->surName,
            'fullName'         => $tUser->firstName . ' ' . $tUser->surName,
            'email'            => $tUser->email,
            'role'             => $tUser->role,
            'level'            => $tUser->level,
            'idProvince'       => $tUser->idProvince,
            'idDistrict'       => $tUser->idDistrict,
            'avatarExtension'  => $tUser->avatarExtension,
            'status'           => $tUser->status,
            'ugelFilter'       => $tUser->blockingReason ?: null,
        ];
    }
}

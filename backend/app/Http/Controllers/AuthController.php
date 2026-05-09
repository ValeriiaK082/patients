<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Patient;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        $patient = Patient::whereRaw(
            "CONCAT(name, surname) = ?", [$request->login]
        )->first();

        if (!$patient || $patient->birth_date !== $request->password) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = JWTAuth::fromUser($patient);
        return response()->json(['token' => $token]);
    }
}
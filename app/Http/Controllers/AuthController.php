<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validasi = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required'
            ]);

            if ($validasi->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => $validasi->errors()->all(),
                    'data' => []
                ], 422);
            }

            $user = User::where('name', $request->name)->where('password', $request->password)->first();

            if ($user != null) {
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'status' => 200,
                    'message' => 'Berhasil login',
                    'data' => [
                        'user' => $user,
                        'toke' => $token
                    ]
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Gagal login, pastikan username dan password benar',
                    'data' => []
                ], 500);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th,
                'data' => []
            ], 500);
        }
    }
}
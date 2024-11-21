<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Role;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use HttpResponses;

    public function register(Request $request): JsonResponse
    {
        try {
            $validatedData = $this->validateUserData($request);
            $validatedData['role'] = Role::Agent->value;
            $user = User::create($validatedData);
            return $this->success([
                'user' => $user,
                'token' => $user->createToken('API Token of '. $user->name)->plainTextToken,
            ],'', 201);
        } catch (\Exception $exception) {
            return $this->error(500, $exception->getMessage());
        }
    }

    public function login(Request $request): JsonResponse
    {
        try {
            $request->validate([$request->all()]);
            if (!Auth::attempt($request->only('email', 'password'))) {
                return $this->error( 401, 'wrong credentials');
            }
            $user = User::where('email', $request->email)->first();
            return $this->success([
                'user' => $user,
                'token' => $user->createToken('API Token of '. $user->name)->plainTextToken,
            ]);
        } catch (\Exception $exception) {
            return $this->error(500, $exception->getMessage());
        }
    }

    public function logout(): JsonResponse
    {
        try {
//            Auth::user()->tokens()->delete();
            Auth::user()->currentAccessToken()->delete();
            return $this->success('', '', 204);
        } catch (\Exception $exception) {
            return $this->error(500, $exception->getMessage());
        }
    }

    private function validateUserData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required' , 'string' , 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

}

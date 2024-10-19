<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\VaccineCenter\VaccineCenterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected $vaccineCenterService;

    public function __construct(VaccineCenterService $vaccineCenterService)
    {
        $this->vaccineCenterService = $vaccineCenterService;
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create(array(
            "name" => $request->name,
            "email" => $request->email,
            "nid" => $request->nid,
            "password" => $request->password,
        ));

        Log::info('Calling registerUserToCenter with User ID: ' . $user->id . ' and Center ID: ' . $request->center);
        $this->vaccineCenterService->registerUserToCenter($user, $request->center, $request->timezone);

        return response()->json(array(
            'message' => 'Registration successful'
        ), 201);
    }

    public function login(LoginRequest $request)
    {
        // Check if the identifier is an email or NID
        $field = filter_var($request->identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'nid';
        $credential = array(
            $field => $request->identifier, 
            "password" => $request->password
        );

        if (Auth::attempt($credential)) {
            $user = Auth::user();
            $token = $user->createToken('Covax Portal Token')->plainTextToken; // Create a token

            return response()->json(array(
                'token' => $token, 
                'message' => 'Login successful',
            ));
        }

        return response()->json(array(
            "message" => "Invalid credentials",
        ), 401);
    }

    public function logout(Request $request)
    {
        $isDeleted = $request->user()->currentAccessToken()->delete();

        return response()->json(array(
            'success' => $isDeleted,
            'message' => $isDeleted ? 'Logged out successfully' : "Logout failed!",
        ));
    }
}

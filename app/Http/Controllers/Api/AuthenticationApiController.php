<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\ErrorResponse;

class AuthenticationApiController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($credentials)) {
            $error = Error::make()
                ->setCode('INVALID_CREDENTIALS')
                ->setTitle('Conflict')
                ->setDetail('The email or the password is incorrect.')
                ->setStatus(401);

            return ErrorResponse::make($error)
                ->withHeaders(['Content-Type' => 'application/vnd.api+json']);
        }

        $token = Auth::user()->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => Auth::user()
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
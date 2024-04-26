<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * @group Authentication
 *
 * API endpoints for managing authentication
 */
class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Logins a user.
     *
     * @bodyParam email string required Must be a valid email address.
     * @bodyParam password string required Password.
     *
     * @unauthenticated
     * @response {"data":{"name":"Gust Olson","email":"gschuster@example.com"},"token":"1|b5liQC0bP33jtCddheSiVp3c6ZnbiddKvDf36AxI"}
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('web');

        return (new UserResource($user))->additional([
            'token' => $token->plainTextToken,
        ]);
    }
}

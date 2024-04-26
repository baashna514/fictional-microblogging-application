<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * @group Authentication
 *
 * API endpoints for managing authentication
 */
class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Register a user.
     *
     * @bodyParam name string required Must not be greater than 255 characters.
     * @bodyParam email string required Must be a valid email address.
     * @bodyParam password string required New password.
     *
     * @unauthenticated
     * @response {"data":{"name":"Gust Olson","email":"gschuster@example.com"},"token":"1|b5liQC0bP33jtCddheSiVp3c6ZnbiddKvDf36AxI"}
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        $user = User::create([
            'name'              => $data['name'],
            'email'             => $data['email'],
            'password'          => Hash::make($data['password']),
            'email_verified_at' => config('app.must_verify_email') ? null : now(),
        ]);

        $token = $user->createToken('web');

        return (new UserResource($user))->additional([
            'token' => $token->plainTextToken,
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'   => ['required', 'string', 'max:255'],
            'email'        => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user ?? null)],
            'password'     => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
        ]);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

/**
 * @group Authentication
 *
 * API endpoints for managing authentication
 */
class SessionController extends Controller
{
    /**
     * Get the authenticated user data.
     *
     * @authenticated
     * @response {"data":{"id":"5","email":"theresa42@example.net","name":"Arno Grady"}}
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();
        abort_if(!$user, 401, 'Unauthorized');

        return (new UserResource($user))->additional([
            'token' => $request->bearerToken(),
        ]);
    }
}

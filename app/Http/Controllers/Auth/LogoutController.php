<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @group Authentication
 *
 * API endpoints for managing authentication
 */
class LogoutController extends Controller
{
    /**
     * Logout.
     *
     * @authenticated
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->noContent();
    }
}

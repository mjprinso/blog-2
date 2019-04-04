<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();
            $user->generateToken();

            return response()->json([
                'data' => $user->toArray(),
            ]);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();
        $user1 = Auth::guard('api')->user(); // instance of the logged user
        $user2 =  Auth::guard('api')->check(); // if a user is authenticated
        $user3 = Auth::guard('api')->id(); // the id of the authenticated user

        $user4 = Auth::user();

        if ($user) {
            $user->api_token = null;
            $user->save();

            Auth::logout();

            return response()->json(['data' => 'User logged out.'], 200);
        }

        return response()->json(['data' => $user1. $user2. $user3. $user4. 'User logged out failed.'], 200);

        // return response()->json(['data' => 'User logged out.'], 200);
    }
}

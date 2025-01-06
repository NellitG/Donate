<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use App\Helpers\Helper;

class AuthJwtController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['jwtauth'])->except('login');
    }

    /**User registration */
    public function register(Request $request)
    {

        $fields = $request->validate([
            'firstName' => 'required|string|min:3',
            'secondName' => 'required|string|min:3',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|string|min:8',
            'phone_no' => 'required|string|min:8|unique:users,phone_no',
        ]);

        $name = $fields['firstName'] . " " . $fields['secondName'];

        $user = User::create([
            'name' => $name,
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'phone_no' => $fields['phone_no'],
        ]);

        $response = [
            'message' => 'Registration completed successfully',
            'user' => $user,
        ];

        return response($response, 201);
    }

    /**User login */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        /** Get user with email from db */
        $user = User::where('email', $credentials['email'])->first();

        // if (!$user || !Hash::check($credentials['password'], $user->password)) {
        //     return response()->json(['success' => false, 'message' => 'Invalid credentials'], 401);
        // }

        /**Return if user not found */
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Invalid credentials'], 401);
        }

        /** Add user info in token */
        $customClaims = ['user_id' => $user->id];

        // $token = JWTAuth::attempt($credentials);
        $token = JWTAuth::claims($customClaims)->attempt($credentials);

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        /** Generate refresh token */
        $refresh_ttl = config('REFRESH_TTL');
        $refreshToken = auth()->setTTL($refresh_ttl)
            ->attempt($credentials);

        /** Store refresh token in user table */
        $user->authtoken = $refreshToken;
        $user->save();

        /**Set refresh token as a cookie */
        $cookie = cookie('jwt', $refreshToken, $refresh_ttl); //3 days

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user
        ], 200)->withCookie($cookie);
    }

    /**Get the current user */
    public function user()
    {
        return auth()->user();
        // return Auth::user();
    }

    /**Check Token */
    public function checkToken()
    {
        return response()->json(['success' => true], 200);
    }

    /**User logout */
    public function logout(Request $request)
    {
        auth()->logout();
        $cookie = Cookie::forget('jwt');

        return response(
            ['message' => 'Logged out']
        )->withCookie($cookie);
    }
}

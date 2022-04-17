<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;

class AuthController extends BaseController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Login
     *
     * @return void
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }
        return $this->respondWithToken($token);
    }

    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {

        //validate incoming request
        $validator = $this->validate($request, [
            'email' => 'required|string|unique:users',
            'password' => 'required|confirmed',
            'name' => 'required|string',
        ]);

        // if ($validator->fails()) {
        //     return response()->json(['success' => false, 'error' => 'Validation Error.', $validator->errors()]);
        // }

        try {
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = app('hash')->make($request->input('password'));
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 409);
        }
    }

    /**
     * Logout
     *
     * @return void
     */
    public function logout()
    {
        auth()->logout();
        return response()->json([
            'message' => 'Logout with success!'
        ], 401);
    }

    /**
     * Undocumented function
     *
     * @param [type] $token
     * @return void
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 // default 1 hour
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer; // untuk beberapa aksi, yaitu untuk proses register dan login.
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth; // untuk proses authentication dan generate token.
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // untuk proses hash password saat register customer.
use Illuminate\Support\Facades\Validator; // untuk proses validasi di dalam register dan login.

class AuthController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct() // untuk memberikan sebuah middleware untuk authentication.
    {
        $this->middleware('auth:api')->except(['register', 'login']);
    } 
    
    /**
     * register
     *
     * @param  mixed $request
     * @return void
     */
    public function register(Request $request) // untuk proses registrasi customer.
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:customers',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $customer = Customer::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password)
        ]);

        $token = JWTAuth::fromUser($customer);

        if($customer) {
            return response()->json([
                'success' => true,
                'user'    => $customer,  
                'token'   => $token  
            ], 201);
        }

        return response()->json([
            'success' => false,
        ], 409);
    }
    
    /**
     * login
     *
     * @param  mixed $request
     * @return void
     */
    public function login(Request $request) // untuk proses authentication user.
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $credentials = $request->only('email', 'password');

        if(!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email or Password is incorrect'
            ], 401);
        }
        return response()->json([
            'success' => true,
            'user'    => auth()->guard('api')->user(),  
            'token'   => $token   
        ], 201);
    }
    
    /**
     * getUser
     *
     * @return void
     */
    public function getUser() // untuk mendapatkan data user/customer yang sedang login.
    {
        return response()->json([
            'success' => true,
            'user'    => auth()->user()
        ], 200);
    }
}

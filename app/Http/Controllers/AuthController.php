<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Special;
use JWTAuth;
use TomLingham\Searchy\Facades\Searchy;
use Tymon\JWTAuth\Exceptions\JWTException;


class AuthController extends Controller
{
    public function special()
    {
        $specials = Special::all();
        return response($specials, 200);
    }

    public function search(Request $request){
        $users = User::hydrate(Searchy::search('users')->fields('name', 'email','birth_date','desc')->withTrashed()->query($request->q)->getQuery()->limit(12)->get()->toArray());
        return response($users,200);
    }

    public function register(Request $request)
    {
        return response(User::add($request), 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid credentails'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => "Couldn't not create token"], 500);
        }
        return response()->json(compact('token'));
    }

    public function user()
    {
        try{
            $user = JWTAuth::parseToken()->authenticate();
            return response($user, 200);
        }catch (JWTException $e){
            try{
                $token = JWTAuth::getToken();
                $new_token = JWTAuth::refresh($token);
                return response()->json(['message' => 'new token', 'new_token' => $new_token]);
            }catch (JWTException $e){
                return response()->json(['message' => 'invalid token']);
            }
        }


    }

    public function viewUser(Request $request)
    {
        $user = User::where('id','=',$request->id)->first();
        return response($user,200);
    }

}

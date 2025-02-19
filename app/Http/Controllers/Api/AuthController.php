<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function login(Request $request)
    {
        $loginData = $request-> validate ([
            'email'=>'required|email',
            'password'=>'required',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user)
        {
            return response([
               'message' => ['These credentials do not match our records.'],
            ],404);

        }

        If (!Hash::check($request->password, $user->password)){
            return response([
                  'message'=>['Password is wrong'],
                   ],404);
       // $token = $user->createToken ('auth_tokén' )->plainTextToken;
        //$response =[
          //  'user'=>$user,
           // 'token'=>$token,
       // ];
           // return response($response, 201);
        }
        $token = $user->createToken ('auth_tokén' )->plainTextToken;

        return response([
            'user'=>$user,
           'token'=>$token,
        ],200);
       // else
        //    return response([
         //   'message'=>['Password not match'],
         //   ],404);
    }
    
    public function logout(Request $request)
    {
    $request->user()->currentAccesgToken()->delete();
    return response()->json([
        'message'=>'Logout success',
    ]);

    }


}

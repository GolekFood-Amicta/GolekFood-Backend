<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    //
    public function login(Request $request){
        // $request->validate([
        //     'email' => 'required',
        //     'password' => 'required'
        // ]);

        // $user = User::where('email', $request->email)->first();
        // // dd($user);
        // if (! $user || ! Hash::check($request->password, $user->password)) {
        //     throw ValidationException::withMessages([
        //         'email' => ['The provided credentials are incorrect.'],
        //     ]);
        // }
     
        // return $user->createToken('g0l3kF0oD')->plainTextToken;

        $rules = [
            'email'         => 'required',
            'password'      => 'required',
        ];
        $messages = [
            'email.required'        => 'Email wajib diisi',
            'password.required'     => 'Password wajib diisi',
            'password.min'          => 'Password minimal 6 karakter',
            'password.confirmed'    => 'Password tidak sama dengan konfirmasi password',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return new PostResource(false, $validator->errors()->first());
        }
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return new PostResource(false, "email atau password salah");
        }

        $user = User::where('email', $request->email)->first();
        if (!Hash::check($request->password, $user->password, [])) {
            return new PostResource(false, "password anda salah");
        }

        $tokenResult = $user->createToken('g0l3kF0oD')->plainTextToken;

        $data = [
            'access_token' => $tokenResult,
            'token_type' => 'Bearer',
            'user' => $user
        ];
        return new PostResource(true, "login berhasil", $data);
    



    }

    public function logout(Request $request){
        // $request->user()->currentAccessToken()->delete();
        try {
            $user = $request->user();
            $user->tokens()->where('id', $user->id)->delete();
            $request->user()->currentAccessToken()->delete();
            return new PostResource(true, "logout berhasil", $user);
        } catch (\Throwable $th) {
            return new PostResource(false, "logout gagal");
        }
    }

    public function register(Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:users',
            'name' => 'required|min:4|max:32',
            'address' => 'required|min:4|max:32',
            'password' => 'required|min:6|confirmed',
            'roles_id' => 'required',

        ];

        $messages = [
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Email tidak valid',
            'email.unique'          => 'Email sudah terdaftar',
            'name.required' => 'Nama Lengkap wajib diisi',
            'name.min'      => 'Nama lengkap minimal 4 karakter',
            'name.max'      => 'Nama lengkap maksimal 32 karakter',
            'password.required'     => 'Password wajib diisi',
            'password.min'          => 'Password minimal 6 karakter',
            'password.confirmed'    => 'Password tidak sama dengan konfirmasi password',
            'roles_id.required'     => 'Roles tidak tersedia',
            'address.required' => 'Alamat wajib diisi',
            'address.min'      => 'Alamat minimal 4 karakter',
            'address.max'      => 'Alamat maksimal 32 karakter',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return new PostResource(false, $validator->errors()->first());
        }
        $data = [
            'email' => strtolower($request->email),
            'name' => strtolower($request->name),
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'roles_id' => $request->roles_id,
        ];
        try {
            $user = User::create($data);
            return new PostResource(true, "User berhasil teregistrasi", $user);
        } catch (\Throwable $th) {
            return new PostResource(false, $th->getMessage());
        }
    }
}

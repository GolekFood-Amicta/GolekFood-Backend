<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    //
    public function login(Request $request)
    {
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

    public function logout(Request $request)
    {
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
            event(new Registered($user));

            return new PostResource(true, "User berhasil teregistrasi", $user);
        } catch (\Throwable $th) {
            return new PostResource(false, $th->getMessage());
        }
    }

    public function changePassword(Request $request)
    {
        try {
            if (Auth::check()) {
                $rules = [
                    'old_password' => 'required',
                    'password'      => 'required|min:6|confirmed',
                ];
                $messages = [
                    'password.required'     => 'Password wajib diisi',
                    'password.min'          => 'Password minimal 6 karakter',
                    'password.confirmed'    => 'Password tidak sama dengan konfirmasi password',
                ];
                $validator = Validator::make($request->all(), $rules, $messages);
                if ($validator->fails()) {
                    return new PostResource(false, $validator->errors()->first());
                }
                $user = $request->user();
                $user = User::where('id', $user->id)->first();

                if(!Hash::check($request->old_password, $user->password)){
                    return new PostResource(false, "password anda salah");
                }

                try {
                    $user->update([
                        'password' => Hash::make($request->password)
                    ]);
                    return new PostResource(true, "Password Berhasil diperbarui");
                } catch (\Throwable $th) {
                    return new PostResource(false, "Password Gagal diperbarui");
                }
            }
        } catch (\Throwable $th) {
            return new PostResource(false, "unauthenticated");
        }
    }

    public function forgotPassword(Request $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT
            ? new PostResource(true, "Email reset password berhasil dikirim")
            : new PostResource(false, "Email reset password gagal dikirim");
    }

    public function resetPassword($token){
        return $token;
    }

    public function resetPasswordClient(Request $request)
    {  
        try {
            $request->validate([
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6|confirmed',
            ]);
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password){
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));
                    $user->save();
                        
                    event(new \Illuminate\Auth\Events\PasswordReset($user));
                }
            );  
            if ($status == Password::INVALID_TOKEN) {
                return new PostResource(false, "reset password gagal");
            }
            return new PostResource(true, "reset password berhasil");
        } catch (\Throwable $th) {
            return $th;
        }
        
    }

    public function verifyEmail($user_id, Request $request)
    {
        if (! $request->hasValidSignature()) {
            return new PostResource(false, "link verifikasi tidak valid");
        }

        $user = User::findOrFail($user_id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }
        // $request->fulfill();
    
        // return new PostResource(true, "Email berhasil diverifikasi");
        return new PostResource(true, "Email berhasil diverifikasi", $request);
    }


}



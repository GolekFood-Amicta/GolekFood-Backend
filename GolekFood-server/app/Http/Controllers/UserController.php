<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getUser($id = null)
    {
        try {
            if (isset($id)) {
                $user = User::where('id', $id)->first();
            } else {
                $user = User::all();
            }
            return new PostResource(true, "data User ditemukan", $user);
        } catch (\Throwable $th) {
            return new PostResource(false, "data User tidak ada");
        }
    }


    public function updateUser(Request $request)
    {
        try {
            $data = [
                'id_user' => $request->id_user,
                'email' => strtolower($request->email),
                'name' => strtolower($request->name),
                'address' => $request->address,
                'password' => Hash::make($request->password),
                'roles_id' => $request->roles_id,
            ];
            $user = User::where('id', $request->id_user)->first();
            if (!$user) {
                return new PostResource(false, "User tidak ditemukan");
            }

            $user->update($data);
            return new PostResource(true, "data User berhasil diubah", $user);
        } catch (\Throwable $th) {
            return new PostResource(false, "data User gagal diubah");
        }
    }

    public function deleteUser(Request $request)
    {
        try {
            $user = User::where('id', $request->id_user)->first();
            $user->delete();
            return new PostResource(true, "User Berhasil dihapus", $user);
        } catch (\Throwable $th) {
            return new PostResource(false, "User Gagal dihapus");
        }
    }

}
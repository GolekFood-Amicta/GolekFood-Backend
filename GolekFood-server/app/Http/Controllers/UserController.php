<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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


    public function updateUser(Request $request, $id)
    {
        try {

            $user = User::where('id', $id)->first();
            if (!$user) {
                return new PostResource(false, "User tidak ditemukan");
            }

            $avatar = $user->avatar;
             if($request->file ){
                 $fileName = $this->generateRandomString();
                 $extension = $request->file->extension();
                 $avatar = $fileName.'.'.$extension;
                 //jika bukan default
                if($user->avatar != 'default-profile.png'){
                    Storage::delete('image/'.$user->avatar);
                }

                 Storage::putFileAs('image', $request->file, $avatar);
             }

             $data = [
                'id_user' => $request->id_user,
                'email' => strtolower($request->email),
                'name' => strtolower($request->name),
                'address' => $request->address,
                'password' => Hash::make($request->password),
                'roles_id' => $request->roles_id,
                'avatar' => $avatar
            ];             

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
            Storage::delete('image/'.$user->avatar);
            $user->delete();
            return new PostResource(true, "User Berhasil dihapus", $user);
        } catch (\Throwable $th) {
            return new PostResource(false, "User Gagal dihapus");
        }
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
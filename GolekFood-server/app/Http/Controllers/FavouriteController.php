<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreFavouriteRequest;
use App\Http\Requests\UpdateFavouriteRequest;

class FavouriteController extends Controller
{
   
    public function getFavourite($id = null)
    {
        try {
            if (isset($id)) {
                $food = Favourite::where('id', $id)->first();
            } else {
                $food = Favourite::all();
            }
            return new PostResource(true, "data Food ditemukan", $food);
        } catch (\Throwable $th) {
            return new PostResource(false, "data Food tidak ada");
        }
    }

    public function getFavouriteByIdUser($id)
    {
        try {
            $food = Favourite::where('user_id', $id)->get();
            return new PostResource(true, "data Food ditemukan", $food);
        } catch (\Throwable $th) {
            return new PostResource(false, "data Food tidak ada");
        }
    }

    public function addFavourite(Request $request)
    {
        try {
            if (isset($request->id_favourite)) {
                return $this->updateFavourite($request);
            } else {
                $rules = [
                    'user_id' => 'required',
                    'foodname'=> 'required',
                    'fat' => 'required',
                    'protein' => 'required',
                    'carbohydrate' => 'required',
                    'calories' => 'required',

                ];
                $validation = Validator::make($request->all(), $rules);
                if ($validation->fails()) {
                    return new PostResource(false, "Favourite gagal ditambahkan", $validation->errors()->all());
                }
                $user = Favourite::where('id', $request->user_id)->first();
                if (!$user) {
                    return new PostResource(false, "User tidak ditemukan");
                }

                $data = [
                    'user_id' => $request->user_id,
                    'id_favourite' => $request->id_favourite,
                    'foodname' => $request->foodname,
                    'fat' => $request->fat,
                    'protein' => $request->protein,
                    'carbohydrate' => $request->carbohydrate,
                    'calories' => $request->calories,
                ];
                $favourite = Favourite::create($data);
            }

            return new PostResource(true, "Favourite berhasil ditambahkan", $favourite);
        } catch (\Throwable $th) {
            return new PostResource(false, "Favourite gagal ditambahkan");
        }
    }


    public function updateFavourite(Request $request)
    {
        try {
            $data = [
                'id_favourite' => $request->id_favourite,
                'foodname' => $request->foodname,
                'fat' => $request->fat,
                'protein' => $request->protein,
                'carbohydrate' => $request->carbohydrate,
                'calories' => $request->calories,
            ];
            $food = Favourite::where('id', $request->id_favourite)->first();
            if (!$food) {
                return new PostResource(false, "Favourite tidak ditemukan");
            }

            $food->update($data);
            return new PostResource(true, "data Favourite berhasil diubah", $food);
        } catch (\Throwable $th) {
            return new PostResource(false, "data Favourite gagal diubah");
        }
    }

    public function deleteFavourite(Request $request)
    {
        try {
            $food = Favourite::where('id', $request->id_favourite)->first();
            $food->delete();
            return new PostResource(true, "Favourite Berhasil dihapus", $food);
        } catch (\Throwable $th) {
            return new PostResource(false, "Favourite Gagal dihapus");
        }
    }

}

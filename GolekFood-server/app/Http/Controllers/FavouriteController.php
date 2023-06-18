<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreFavouriteRequest;
use App\Http\Requests\UpdateFavouriteRequest;
use Illuminate\Support\Facades\Http;

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
                    'food_id' => 'required',
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
                    'id_favourite' => $request->id_favourite,
                    'user_id' => $request->user_id,
                    'food_id' => $request->food_id,
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
                'food_id' => $request->food_id,
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


    public function discoverFood(Request $request)
    {
        try {
            $url = "https://golekfoodsflask-production.up.railway.app/advpredict"; // Ganti dengan URL API yang sesuai
    
            $data = [
                "user_id" => $request->user_id,
                "energi" => $request->energi,
                "protein" => $request->protein,
                "lemak" => $request->lemak,
                "karbohidrat" => $request->karbohidrat
            ];
        
            $response = Http::post($url, $data);
            
            $data = $response->json();
            // Mengakses data di dalam "data"
            $recom = $data['data'];

            // Menambahkan key "is_favourite" pada setiap data
            $recomWithFavourite = array_map(function ($item) use ($request) {
                $item['is_favourite'] = Favourite::where('user_id', $request->user_id)->where('food_id', $item['id_food'])->exists();
                return $item;
            }, $recom);
        
            // Menggabungkan data yang telah ditambahkan "is_favourite" ke dalam "data"
            $result = ['data' => $recomWithFavourite];

            return new PostResource(true, "Berhasil mendapatkan data discover Food", $result);
        } catch (\Throwable $th) {
            return new PostResource(false, "Gagal mendapatkan data discover Food");
        }

    }

}

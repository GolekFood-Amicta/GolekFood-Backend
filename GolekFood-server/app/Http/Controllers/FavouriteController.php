<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSubs;
use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreFavouriteRequest;
use App\Http\Requests\UpdateFavouriteRequest;
use App\Models\UserHistory;

class FavouriteController extends Controller
{

    public function getFavourite($id = null)
    {
        try {
            if (isset($id)) {
                $food = Favourite::where('id', $id)->first();
                $food->user = User::where('id', $food->user_id)->first();
                unset($food->user_id);
            } else {
                $food = Favourite::all();
                foreach ($food as $data) {
                    $user_id = $data->user->id;
                    unset($data->user_id);
                    $data->user = User::where('id', $user_id)->first();
                }
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
                    'foodname' => 'required',
                    'fat' => 'required',
                    'protein' => 'required',
                    'carbohydrate' => 'required',
                    'calories' => 'required',
                    'image' => 'required'

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
                    'image' => $request->image
                ];
                $favourite = Favourite::create($data);
                $favourite['is_favourite'] = true;
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
                'image' => $request->image
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

            $rules = [
                'user_id' => 'required',
                'food_id' => 'required'
            ];
            $validation = Validator::make($request->all(), $rules);
            if ($validation->fails()) {
                return new PostResource(false, "Favourite gagal dihapus", $validation->errors()->all());
            }
            $food = Favourite::where('user_id', $request->user_id)->where('food_id', $request->food_id)->first();
            if (!$food) {
                return new PostResource(false, "Favourite tidak ditemukan");
            }
            $food->delete();

            // $food = Favourite::where('id', $request->id_favourite)->first();
            // $food->delete();
            return new PostResource(true, "Favourite Berhasil dihapus", $food);
        } catch (\Throwable $th) {
            return new PostResource(false, "Favourite Gagal dihapus");
        }
    }


    // public function discoverFood(Request $request)
    // {
    //     try {
    //         $url = "http://34.101.68.137:5000/predict"; // Ganti dengan URL API yang sesuai

    //         $data = [
    //             "user_id" => $request->user_id,
    //             "energi" => $request->energi,
    //             "protein" => $request->protein,
    //             "lemak" => $request->lemak,
    //             "karbohidrat" => $request->karbohidrat
    //         ];

    //         $response = Http::post($url, $data);

    //         $data = $response->json();
    //         // Mengakses data di dalam "data"
    //         $recom = $data['data'];

    //         // Menambahkan key "is_favourite" pada setiap data
    //         $recomWithFavourite = array_map(function ($item) use ($request) {
    //             $item['is_favourite'] = Favourite::where('user_id', $request->user_id)->where('food_id', $item['id_food'])->exists();
    //             return $item;
    //         }, $recom);

    //         // Menggabungkan data yang telah ditambahkan "is_favourite" ke dalam "data"
    //         $result = $recomWithFavourite;

    //         return new PostResource(true, "Berhasil mendapatkan data discover Food", $result);
    //     } catch (\Throwable $th) {
    //         return new PostResource(false, "Gagal mendapatkan data discover Food");
    //     }

    // }

    public function discoverFoodAdv(Request $request)
    {
        try {

            $limitUserNonPremium = 3;

            $periksa = UserHistory::where('user_id', $request->user()->id)->get();

            $count = 0;
            foreach ($periksa as $d) {
                if (($d->created_at)->isToday()) {
                    $count++;
                }
            }

            if (!Auth::check()) {
                return new PostResource(false, "unauthenticated");
            }


            //Mengambil data subscription user 
            $subs = UserSubs::where('user_id', $request->user()->id)->latest()->first();
            //Mengambil data tanggal saat ini
            $currentDate = Carbon::now();

            //Jika user bukan admin
            if (!($request->user()->roles_id == 2)) {

                // Jika user bukan admin dan sudah mencapai limit harian
                if ($request->user()->roles_id = 1 && $count >= $limitUserNonPremium) {
                    return new PostResource(false, "Sudah Mencapai limit harian user biasa");

                    // Jika user bukan admin dan belum berlangganan
                    if ($currentDate->lt($subs['subscription_start']) || $currentDate->gt($subs['subscription_end'])) {
                        // Jika tanggal saat ini sebelum tanggal mulai atau setelah tanggal berakhir
                        return new PostResource(false, "subscription telah habis");
                    }
                }
            }


            $url = "http://34.101.68.137:5000/advpredict"; // Ganti dengan URL API yang sesuai

            $data = [
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
                //Jika pada saat ini user sudah pernah memfavoritkan makanan tersebut
                $item['is_favourite'] = Favourite::where('user_id', $request->user()->id)->where('food_id', $item['id_food'])->exists();
                return $item;
            }, $recom);


            UserHistory::create([
                'user_id' => $request->user()->id
            ]);

            // Menggabungkan data yang telah ditambahkan "is_favourite" ke dalam "data"
            $result = $recomWithFavourite;

            return new PostResource(true, "Berhasil mendapatkan data discover Food", $result);
        } catch (\Throwable $th) {
            return  $th;
            // new PostResource(false, "Gagal mendapatkan data discover Food");
        }
    }
}

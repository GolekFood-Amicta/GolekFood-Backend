<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class NewsController extends Controller
{


    public function getNews($id = null,)
    {
        try {
            if (isset($id)) {
                $news = News::where('id', $id)->first();
                // foreach ($news as $data) {
                //     $user = User::where('id', $data->user_id)->first();
                //     unset($data->user_id);
                //     $data->author = $user;
                // }
                
            } else {
                $news = News::paginate(5);
                foreach ($news as $data) {
                    $user = User::where('id', $data->user_id)->first();
                    unset($data->user_id);
                    $data->author = $user;
                }
            }   
            return new PostResource(true, "data News ditemukan", $news);
        } catch (\Throwable $th) {
            return new PostResource(false, "data News tidak ada");
        }
    }

    public function getNewsByIdUser($id)
    {
        try {
            $news = News::where('user_id', $id)->get();
            foreach ($news as $data) {
                $user = User::where('id', $data->user_id)->first();
                unset($data->user_id);
                $data->author = $user;
            }
            return new PostResource(true, "data news ditemukan", $news);
        } catch (\Throwable $th) {
            return new PostResource(false, "data news tidak ada");
        }
    }

    public function addNews(Request $request)
    {
        try {

                $rules = [
                    'user_id' => 'required',
                    'title' => 'required', 
                    'body' => 'required'
                ];
                $validation = Validator::make($request->all(), $rules);
                if ($validation->fails()) {
                    return new PostResource(false, "News gagal ditambahkan", $validation->errors()->all());
                }
                $user = User::where('id', $request->user_id)->first();
                if (!$user) {
                    return new PostResource(false, "User tidak ditemukan");
                }

                $image = null;
                if($request->file){
                    $fileName = $this->generateRandomString();
                    $extension = $request->file->extension();
                    $image = $fileName.'.'.$extension;

                    Storage::putFileAs('image', $request->file, $image);
                }


                $data = [
                    'user_id' => $request->user_id,
                    'title' => $request->title,
                    'body' => $request->body,
                    'image' => $image
                ];

                $news = News::create($data);
        

            return new PostResource(true, "News berhasil ditambahkan", $news);
        } catch (\Throwable $th) {
            return new PostResource(false, "News gagal ditambahkan");
        }
    }


    public function updateNews(Request $request, $id)
    {
        try {
            $news = News::where('id', $id)->first();
            if (!$news) {
                return new PostResource(false, "News tidak ditemukan");
            }

             $image = $news->image;
             if($request->file){
                 $fileName = $this->generateRandomString();
                 $extension = $request->file->extension();
                 $image = $fileName.'.'.$extension;
                 if($news->image != 'default-image.png'){
                    Storage::delete('image/'.$news->image);
                }
                 //Storage::delete('image'.$news->image);
                 Storage::putFileAs('image', $request->file, $image);
             }

            $data = [
                'id_news' => $request->id_news,
                'title' => $request->title,
                'body' => $request->body,
                'image' => $image
            ];

            $news->update($data);
            return new PostResource(true, "data News berhasil diubah", $news);
        } catch (\Throwable $th) {
            return new PostResource(false, "data News gagal diubah");
        }
    }

    public function deleteNews(Request $request)
    {
        try {
            $news = News::where('id', $request->id_news)->first();
            Storage::delete('image/'.$news->image);
            $news->delete();
            return new PostResource(true, "News Berhasil dihapus", $news);
        } catch (\Throwable $th) {
            return new PostResource(false, "News Gagal dihapus");
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

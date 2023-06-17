<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;


class NewsController extends Controller
{


    public function getNews($id = null)
    {
        try {
            if (isset($id)) {
                $news = News::where('id', $id)->first();
            } else {
                $news = News::all();
            }
            return new PostResource(true, "data News ditemukan", $news);
        } catch (\Throwable $th) {
            return new PostResource(false, "data News tidak ada");
        }
    }

    public function getNewsByIdUser($id)
    {
        try {
            $feedback = News::where('user_id', $id)->get();
            return new PostResource(true, "data news ditemukan", $feedback);
        } catch (\Throwable $th) {
            return new PostResource(false, "data news tidak ada");
        }
    }

    public function addNews(Request $request)
    {
        try {
            if (isset($request->id_news)) {
                return $this->updateNews($request);
            } else {
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

                $data = [
                    'user_id' => $request->user_id,
                    'title' => $request->user_id,
                    'body' => $request->body
                ];
                $feedback = News::create($data);
            }

            return new PostResource(true, "Feedback berhasil ditambahkan", $feedback);
        } catch (\Throwable $th) {
            return new PostResource(false, "feedback gagal ditambahkan");
        }
    }


    public function updateNews(Request $request)
    {
        try {
            $data = [
                'id_news' => $request->id_news,
                'title' => $request->title,
                'body' => $request->body
            ];
            $news = News::where('id', $request->id_news)->first();
            if (!$news) {
                return new PostResource(false, "News tidak ditemukan");
            }

            $news->update($data);
            return new PostResource(true, "data News berhasil diubah", $news);
        } catch (\Throwable $th) {
            return new PostResource(false, "data News gagal diubah");
        }
    }

    public function deleteNews(Request $request)
    {
        try {
            $feedback = News::where('id', $request->id_news)->first();
            $feedback->delete();
            return new PostResource(true, "News Berhasil dihapus", $feedback);
        } catch (\Throwable $th) {
            return new PostResource(false, "News Gagal dihapus");
        }
    }

}

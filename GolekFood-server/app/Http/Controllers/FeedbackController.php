<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    
    public function getFeedback($id = null)
    {
        try {
            if (isset($id)) {
                $feedback = Feedback::where('id', $id)->first();
                $feedback->user = User::where('id',$feedback->user_id)->first();
                unset($feedback->user_id);
            } else {
                $feedback = Feedback::all();
                foreach ($feedback as $data) {
                    $user_id = $data->user->id;
                    unset($data->user_id);
                    $data->user = User::where('id', $user_id)->first();
                }
            }
            return new PostResource(true, "data feedback ditemukan", $feedback);
        } catch (\Throwable $th) {
            return new PostResource(false, "data feedback tidak ada");
        }
    }

    public function getFeedbackByIdUser($id)
    {
        try {
                $feedback = Feedback::where('user_id', $id)->get();
            return new PostResource(true, "data feedback ditemukan", $feedback);
        } catch (\Throwable $th) {
            return new PostResource(false, "data feedback tidak ada");
        }
    }

    public function addFeedback(Request $request)
    {
        try {
            if (isset($request->id_feedback)) {
                return $this->updateFeedback($request);
            } else {
                $rules = [
                    'user_id' => 'required',
                    'content' => 'required'
                ];
                $validation = Validator::make($request->all(), $rules);
                if ($validation->fails()) {
                    return new PostResource(false, "Feedback gagal ditambahkan", $validation->errors()->all());
                }
                $user = User::where('id', $request->user_id)->first();
                if (!$user) {
                    return new PostResource(false, "User tidak ditemukan");
                }

                $data = [
                    'user_id' => $request->user_id,
                    'content' => $request->content
                ];
                $feedback = Feedback::create($data);
            }

            return new PostResource(true, "Feedback berhasil ditambahkan", $feedback);
        } catch (\Throwable $th) {
            return new PostResource(false, "feedback gagal ditambahkan");
        }
    }

    public function updateFeedback(Request $request)
    {
        try {
            $data = [
                'id_feedback' => $request->id_feedback,
                'content' => $request->content
            ];
            $feedback = Feedback::where('id', $request->id_feedback)->first();
            if (!$feedback) {
                return new PostResource(false, "Feedback tidak ditemukan");
            }


            $feedback->update($data);
            return new PostResource(true, "Feedback berhasil diubah", $feedback);
        } catch (\Throwable $th) {
            return new PostResource(false, "Feedback gagal diubah");
        }
    }

    public function deleteFeedback(Request $request)
    {
        try {
            $feedback = Feedback::where('id', $request->id_feedback)->first();
            $feedback->delete();
            return new PostResource(true, "Data Feedback Berhasil dihapus", $feedback);
        } catch (\Throwable $th) {
            return new PostResource(false, "Data Feedback Gagal dihapus");
        }
    }

}

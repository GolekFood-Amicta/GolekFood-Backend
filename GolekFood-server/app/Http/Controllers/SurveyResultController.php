<?php

namespace App\Http\Controllers;

use App\Models\SurveyResult;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SurveyResultController extends Controller
{

    public function getSurveyResult()
    {
        try{
            $surveyResult = SurveyResult::all();
            return new PostResource(true, "data Survey Result ditemukan", $surveyResult);
        } catch (\Throwable $th) {
            return new PostResource(false, "data Survey Result tidak ada");
        }
    }

    public function addSurveyResult(Request $request)
    {
        try {
                $rules = [
                    'user_id' => 'required',
                    'already_survey' => 'required',
                ];
                $validation = Validator::make($request->all(), $rules);
                if ($validation->fails()) {
                    return new PostResource(false, "Survey Result gagal ditambahkan", $validation->errors()->all());
                }

                $user = User::where('id', $request->user_id)->first();
                if (!$user) {
                    return new PostResource(false, "Survey Result gagal ditambahkan", "User tidak ditemukan");
                }

                $user->update([
                    'already_survey' => $request->already_survey,
                ]);

                if(isset($request->umur) && isset($request->jenis_kelamin) && isset($request->hasil)){
                    $data = [
                        'umur' => $request->umur,
                        'jenis_kelamin' => $request->jenis_kelamin,
                        'hasil' => $request->hasil,
                    ];

                    $survey = SurveyResult::create($data);
                    $survey->user = $user;
                }

               if(isset($survey)){
                    return new PostResource(true, "Survey Result berhasil ditambahkan", $survey);
                } 
        
            return new PostResource(true, "Survey Result berhasil ditambahkan", $user);
        } catch (\Throwable $th) {
            return new PostResource(false, "Survey Result gagal ditambahkan");
        }
    }

    public function deleteSurveyResult(Request $request)
    {
        try {
            $survey = SurveyResult::where('id', $request->id_survey)->first();
            return new PostResource(true, "Survey Result Berhasil dihapus", $survey);
        } catch (\Throwable $th) {
            return new PostResource(false, "Survey Result Gagal dihapus");
        }
    }


}

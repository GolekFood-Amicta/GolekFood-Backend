<?php

namespace App\Http\Controllers;

use App\Models\SurveyResult;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
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
                    'umur' => 'required',
                    'hasil' => 'required', 
                ];
                $validation = Validator::make($request->all(), $rules);
                if ($validation->fails()) {
                    return new PostResource(false, "Survey Result gagal ditambahkan", $validation->errors()->all());
                }

                $data = [
                    'umur' => $request->umur,
                    'hasil' => $request->hasil,
                ];

                $news = SurveyResult::create($data);
        

            return new PostResource(true, "Survey Result berhasil ditambahkan", $news);
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

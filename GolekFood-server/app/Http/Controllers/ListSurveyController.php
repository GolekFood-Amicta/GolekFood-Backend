<?php

namespace App\Http\Controllers;

use App\Models\SurveyResult;
use Illuminate\Http\Request;

class ListSurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
 
                $data = SurveyResult::latest()->simplePaginate(15);
                return view('adminpage.surveyresultpage.listsurvey', ['dataSurvey' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SurveyResult $surveyResult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SurveyResult $surveyResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SurveyResult $surveyResult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SurveyResult $surveyResult)
    {
        //
    }
}

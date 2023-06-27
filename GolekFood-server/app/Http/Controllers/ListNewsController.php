<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class ListNewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        //
        $data = News::latest()->simplePaginate(10);
        return view('adminpage.newspage.listnews', ['dataNews' => $data]);

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
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        //
    }
}

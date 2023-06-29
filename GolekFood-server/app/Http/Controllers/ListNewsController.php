<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        return view('adminpage.newspage.createnews');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        return $request;
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
    public function edit($id)
    {
        //
        $news = News::find($id);
        return view('adminpage.newspage.editnews', ['news' => $news]);
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


    public function search(Request $request){
        // Get the search value from the request

        $search = $request->get('search');
    
        // Search in the title and body columns from the posts table
        $data = News::query()->join('users', 'news.user_id', '=', 'users.id')
        ->select('news.*', 'users.name')

            ->where('title', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->orWhere('body', 'LIKE', "%{$search}%")
            ->simplePaginate(10);
    
        // Return the search view with the resluts compacted
        return view('adminpage.newspage.listnews', ['dataNews' => $data]);
    }

}

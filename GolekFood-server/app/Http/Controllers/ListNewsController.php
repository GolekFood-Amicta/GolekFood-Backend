<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $validatedDAta = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
        ]);

        $image = null;
        if ($request->file('image')) {
            $fileName = $this->generateRandomString();
            $extension = $request->file('image')->extension();
            $image = $fileName . '.' . $extension;

            Storage::putFileAs('image', $request->file('image'), $image);
        }

        $validatedDAta['user_id'] = auth()->user()->id;
        $validatedDAta['image'] = $image;


        News::create($validatedDAta);
        return redirect('/list-news')->with('success', 'News telah berhasil ditambahkan');
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
        
        if($news->image != null){
            $urlImage = Storage::url('image/' . $news->image);
        }

        return view('adminpage.newspage.editnews', [
            'news' => $news,
            'urlImage' => $urlImage
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $news = News::where('id', $id)->first();

        $validatedDAta = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp'
        ]);

        $image = $news->image;
        if ($request->file('image')) {
            $fileName = $this->generateRandomString();
            $extension = $request->file('image')->extension();
            $image = $fileName . '.' . $extension;
            if ($news->image != 'default-image.png') {
                Storage::delete('image/' . $news->image);
            }
            Storage::putFileAs('image', $request->file('image'), $image);
        }

        $validatedDAta['user_id'] = auth()->user()->id;
        $validatedDAta['image'] = $image;


        $news->update($validatedDAta);
        return redirect('/list-news')->with('success', 'News telah berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $news = News::where('id', $id)->first();
        Storage::delete('image/'.$news->image);
        $news->delete();
        return redirect('/list-news')->with('success', 'News telah berhasil dihapus');
    }


    public function search(Request $request)
    {
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

    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

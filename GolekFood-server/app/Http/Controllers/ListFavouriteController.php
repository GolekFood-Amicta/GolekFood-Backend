<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Favourite;
use Illuminate\Http\Request;

class ListFavouriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Favourite::select('foodname', DB::raw('COUNT(*) as user_count'))
        ->groupBy('foodname')
        ->orderBy('user_count', 'desc')
        ->latest()
        ->simplePaginate(10);
        return view('adminpage.favouritepage.listfavourite', ['dataFavourite' => $data]);
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
    public function show(Favourite $favourite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Favourite $favourite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Favourite $favourite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Favourite $favourite)
    {
        //
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
    
        $data = Favourite::select('foodname', DB::raw('COUNT(*) as user_count'))
            ->where('foodname', 'LIKE', "%{$search}%")
            ->groupBy('foodname')
            ->orderBy('user_count', 'desc')
            ->simplePaginate(10);
    
        return view('adminpage.favouritepage.listfavourite', ['dataFavourite' => $data]);
    }

}

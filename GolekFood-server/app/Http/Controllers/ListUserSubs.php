<?php

namespace App\Http\Controllers;

use App\Models\UserSubs;
use Illuminate\Http\Request;

class ListUserSubs extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = UserSubs::latest()->where('status', 'Active')->simplePaginate(15);
        return view('adminpage.usersubscriptionpage.listusersubs', ['dataSubs' => $data]);
    
    }

    public function indexAntrean()
    {
        //
        $data = UserSubs::latest()->where('status', 'Inactive')->simplePaginate(15);
        return view('adminpage.usersubscriptionpage.listusersubs', ['dataSubs' => $data]);
    
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
    public function show(UserSubs $userSubs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserSubs $userSubs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserSubs $userSubs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserSubs $userSubs)
    {
        //
    }
}

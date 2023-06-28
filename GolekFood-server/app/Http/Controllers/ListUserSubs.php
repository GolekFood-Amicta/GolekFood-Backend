<?php

namespace App\Http\Controllers;

use App\Models\UserSubs;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

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
        return view('adminpage.usersubscriptionpage.listqueuesubs', ['dataSubs' => $data]);
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
    public function update($id)
    {
        //
        $user = UserSubs::where('id', $id)->first();

        if (($user->subscription) == "Mingguan") {
            $subscription_end = Carbon::now()->addDays(7);
        }

        if (($user->subscription) == "Bulanan") {
            $subscription_end = Carbon::now()->addMonth();
        }

        if (($user->subscription) == "Tahunan") {
            $subscription_end = Carbon::now()->addYear();
        }


        $data = [
            'user_id' => $user->user_id,
            'subscription' => $user->subscription,
            'status' => 'Active',
            'subscription_start' => Carbon::now(),
            'subscription_end' => $subscription_end
        ];
        
        UserSubs::where('id', $id )->update($data);

        return redirect('/list-usersubs')->with('success', 'Subscription telah berhasil ditambahkan');
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




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserSubs $userSubs)
    {
        //
    }
}

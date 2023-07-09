<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionNews;
use Illuminate\Http\Request;

class ListSubscriptionNewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $subscriptionNews = SubscriptionNews::simplePaginate(10);

        return view('adminpage.subscriptionnewspage.listsubsnews', ['dataSubscriptionNews' => $subscriptionNews]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $totalSubscriptionNews = SubscriptionNews::count();
        return view('adminpage.subscriptionnewspage.createsubsnews', ['totalSubscriptionNews' => $totalSubscriptionNews]);
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
    public function show(SubscriptionNews $subscriptionNews)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubscriptionNews $subscriptionNews)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubscriptionNews $subscriptionNews)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubscriptionNews $subscriptionNews)
    {
        //
    }

    public function search(Request $request){
        $search = $request->get('search');
        $subscriptionNews = SubscriptionNews::where('email', 'like', '%'.$search.'%')->paginate(10);
        return view('adminpage.subscriptionnewspage.listsubsnews', ['dataSubscriptionNews' => $subscriptionNews]);
    }
}

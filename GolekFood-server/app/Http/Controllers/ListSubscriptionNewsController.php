<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProcessNewsletter;

use App\Models\SubscriptionNews;
use App\Mail\TestingSendingEmail;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessNewsSubs;
use Illuminate\Support\Facades\Mail;


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
        $emails = SubscriptionNews::pluck('email');
        $validateData = $request->validate([
            'subject' => 'required|max:255',
            'body' => 'required',
        ]);

        foreach($emails as $email){
            // Mail::to($email)->send(new TestingSendingEmail($validateData['subject'], $validateData['body']));
            ProcessNewsSubs::dispatch($email, $validateData['subject'], $validateData['body']);
        }

        return redirect()->route('dashboard')->with('success', 'Email has been sent to queue');
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

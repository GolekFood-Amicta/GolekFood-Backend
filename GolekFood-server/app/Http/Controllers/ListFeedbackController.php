<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class ListFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Feedback::latest()->simplePaginate(10);
        return view('adminpage.feedbackpage.listfeedback', ['dataFeedback' => $data]);
        
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
    public function show(Feedback $feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feedback $feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback)
    {
        //
    }

    public function search(Request $request){
        // Get the search value from the request

        $search = $request->get('search');
    
        // Search in the title and body columns from the posts table
        $data = Feedback::query()->join('users', 'feedback.user_id', '=', 'users.id')
        ->select('feedback.*', 'users.name')

            ->where('subject', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->orWhere('content', 'LIKE', "%{$search}%")
            ->simplePaginate(10);
    
        // Return the search view with the resluts compacted
        return view('adminpage.feedbackpage.listfeedback', ['dataFeedback' => $data]);
    }
}


<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use App\Models\Feedback;
use App\Models\UserSubs;
use App\Models\SurveyResult;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    //
    public function index()
    {
        return view('dashboard', [
            "info" => [
                "totalUser" => User::all()->count(),
                "subscription" => [
                    "inactive" => UserSubs::where('status', 'inactive')->count(),
                    "active" =>  UserSubs::where('status', 'active')->count()
                ],
                "features" => [
                    "totalNews" => News::all()->count(),
                    "totalFeedback" => Feedback::all()->count(),
                    "totalSurvey" => SurveyResult::all()->count(),
                ]
            ],
        ]);
    }
}

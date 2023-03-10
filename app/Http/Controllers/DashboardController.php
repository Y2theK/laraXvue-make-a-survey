<?php

namespace App\Http\Controllers;

use App\Http\Resources\SurveyAnswersResource;
use App\Http\Resources\SurveyResourceDashboard;
use App\Models\Survey;
use App\Models\SurveyAnswer;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        //total surveys count

        $totalSurveys = Survey::query()->where('user_id', $user->id)->count();


        //latest survey
        $latestSurvey = Survey::query()->where('user_id', $user->id)->orderBy('created_at', 'desc')->first();


        //total answers count
        $totalAnswers = SurveyAnswer::query()
        ->join('surveys', 'survey_answers.survey_id', '=', 'surveys.id')
        ->where('surveys.user_id', $user->id)
        ->count();


        //lastest answers
        $lastestAnswers = SurveyAnswer::query()
        ->join('surveys', 'survey_answers.survey_id', '=', 'surveys.id')
        ->where('surveys.user_id', $user->id)
        ->orderBy('end_date', 'desc')
        ->limit(5)
        // ->get();
        ->getModels('survey_answers.*');

        return response([
            'totalSurveys' => $totalSurveys,
            'latestSurvey' => $latestSurvey ? new SurveyResourceDashboard($latestSurvey) : null,
            'totalAnswers' => $totalAnswers,
            'latestAnswers' => SurveyAnswersResource::collection($lastestAnswers)
        ]);
    }
}

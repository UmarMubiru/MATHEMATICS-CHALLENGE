<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    // i. The Most Correctly Answered Questions
    public function getMostCorrectlyAnsweredQuestions()
    {
        return Result::select('questions')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('questions')
            ->orderByDesc('count')
            ->limit(10)
            ->get();
    }

    // ii. School Rankings
    public function getSchoolRankings()
    {
        return Result::select('schoolName as school', DB::raw('AVG(totalScore) as average_marks'))
            ->groupBy('schoolName')
            ->orderByDesc('average_marks')
            ->limit(10) // Top 10 schools
            ->get();
    }

    // iii. Performance of Schools and Participants Over the Years
    public function getPerformanceOverYears()
    {
        // Schools' performance
        $schoolPerformance = Result::select(DB::raw('YEAR(created_at) as year'), 'schoolName as school', DB::raw('AVG(totalScore) as average_marks'))
            ->groupBy('year', 'schoolName')
            ->orderBy('year')
            ->get();

        // Participants' performance
        $participantPerformance = Result::select(DB::raw('YEAR(created_at) as year'), 'participantName as participant', DB::raw('AVG(totalScore) as average_marks'))
            ->groupBy('year', 'participantName')
            ->orderBy('year')
            ->get();

        return [
            'schoolPerformance' => $schoolPerformance,
            'participantPerformance' => $participantPerformance,
        ];
    }

    // iv. Percentage Repetition of Questions for a Given Participant
    public function getRepetitionData($participantName)
    {
        $results = Result::where('participantName', $participantName)->get();
        $questionCounts = [];

        // Count occurrences of each question
        foreach ($results as $result) {
            $questions = explode(',', $result->questions);
            foreach ($questions as $question) {
                $question = trim($question);
                if (!isset($questionCounts[$question])) {
                    $questionCounts[$question] = 0;
                }
                $questionCounts[$question]++;
            }
        }

        $totalAttempts = count($results);
        $repetitionPercentages = [];

        // Calculate the repetition percentage for each question
        foreach ($questionCounts as $question => $count) {
            $repetitionPercentages[$question] = ($count / $totalAttempts) * 100;
        }

        return $repetitionPercentages;
    }

    // v. List of Worst Performing Schools for a Given Challenge
    public function getWorstSchoolsForChallenge($challengeName)
    {
        return Result::select('schoolName as school', DB::raw('AVG(totalScore) as average_marks'))
            ->where('challengeName', $challengeName)
            ->groupBy('schoolName')
            ->orderBy('average_marks')
            ->limit(10) // Worst 10 schools
            ->get();
    }

    // vi. List of Best Performing Schools for All Challenges
    public function getBestSchools()
    {
        return Result::select('schoolName as school', DB::raw('AVG(totalScore) as average_marks'))
            ->groupBy('schoolName')
            ->orderByDesc('average_marks')
            ->limit(10) // Best 10 schools
            ->get();
    }

    // vii. List of Participants with Incomplete Challenges
    public function getIncompleteParticipants()
    {
        // Define the criteria for an incomplete challenge (e.g., less than 50% score)
        $incompleteCriteria = 0.5;

        return Result::whereRaw('totalScore < ? * (SELECT MAX(totalScore) FROM results WHERE challengeName = results.challengeName)', [$incompleteCriteria])
            ->select('participantName as participant', 'challengeName as challenge', 'totalScore as marks')
            ->get();
    }

    // viii. Additional Reports (e.g., Participants with Fastest Times)
    public function getFastestParticipants()
    {
        return Result::select('participantName as participant', 'challengeName as challenge', 'totalTime')
            ->orderBy('totalTime') // Fastest times
            ->limit(10) // Top 10 fastest participants
            ->get();
    }
}

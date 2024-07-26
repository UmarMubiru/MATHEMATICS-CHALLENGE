<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use Illuminate\Support\Facades\DB; // Import the DB facade

class ChallengeController extends Controller
{
    public function getChallengeWinners()
    {
        // Fetch all distinct challenge names
        $challenges = Result::select('challengeName')
            ->distinct()
            ->pluck('challengeName');

        $winners = [];

        foreach ($challenges as $challenge) {
            // Fetch winners for each challenge
            $challengeWinners = Result::select('participantName as winner', 'schoolName as school')
                ->where('challengeName', $challenge)
                ->where('totalScore', function ($query) use ($challenge) {
                    $query->selectRaw('MAX(totalScore)')
                        ->from('results')
                        ->where('challengeName', $challenge);
                })
                ->get();

            $winners[$challenge] = $challengeWinners;
        }

        return $winners;
    }

    public function getTopSchools()
    {
        // Fetch the top 2 schools based on their average score
        return Result::select('schoolName as school', DB::raw('AVG(totalScore) as average_score'))
            ->groupBy('schoolName')
            ->orderBy('average_score', 'desc')
            ->limit(2)
            ->get();
    }
    public function index()
    {
        $winners = $this->getChallengeWinners();
        $topSchools = $this->getTopSchools();

        return view('welcome', compact('winners', 'topSchools'));
    }

}

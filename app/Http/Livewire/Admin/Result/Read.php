<?php

namespace App\Http\Livewire\Admin\Result;

use App\Models\Result;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Read extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;
    public $sortType;
    public $sortColumn;

    protected $queryString = ['search'];
    protected $listeners = ['resultDeleted'];

    public function resultDeleted()
    {
        // No action needed for this example
    }

    public function sort($column)
    {
        $sort = $this->sortType == 'desc' ? 'asc' : 'desc';
        $this->sortColumn = $column;
        $this->sortType = $sort;
    }

    public function getMostCorrectlyAnsweredQuestions()
    {
        // Get all results from the database
        $results = Result::all();

        $questionCounts = [];

        foreach ($results as $result) {
            // Split questions and answers by spaces
            $questions = explode(' ', $result->questions);
            $answers = explode(' ', $result->answers);

            // Iterate through questions and answers
            foreach ($questions as $index => $question) {
                if (isset($answers[$index])) {
                    $answer = $answers[$index];

                    // Check if the answer is correct (this will depend on your correctness logic)
                    // For simplicity, assume all answers in `answers` are correct if they exist
                    if ($answer == 'correct') { // Replace with your actual correctness condition
                        if (!isset($questionCounts[$question])) {
                            $questionCounts[$question] = 0;
                        }
                        $questionCounts[$question]++;
                    }
                }
            }
        }

        // Sort questions by count in descending order and get the top 10
        arsort($questionCounts);
        $topQuestions = array_slice($questionCounts, 0, 10, true);

        // Convert to a collection for easier manipulation
        $resultCollection = collect($topQuestions)->map(function ($count, $question) {
            return (object) [
                'question' => $question,
                'count' => $count,
            ];
        });

        return $resultCollection;
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

    public function getPerformanceOverYears()
    {
        // Fetch the performance of schools and participants over the years
        $schoolPerformance = Result::select(DB::raw('YEAR(created_at) as year'), 'schoolName as school', DB::raw('AVG(totalScore) as average_marks'))
            ->groupBy('year', 'schoolName')
            ->orderBy('year')
            ->get();

        $participantPerformance = Result::select(DB::raw('YEAR(created_at) as year'), 'participantName as participant', DB::raw('AVG(totalScore) as average_marks'))
            ->groupBy('year', 'participantName')
            ->orderBy('year')
            ->get();

        // Get the best performing schools for each year
        $bestSchools = Result::select(DB::raw('YEAR(created_at) as year'), 'schoolName as school', DB::raw('AVG(totalScore) as average_marks'))
            ->groupBy('year', 'schoolName')
            ->orderBy('year')
            ->get()
            ->groupBy('year') // Group by year
            ->map(function ($yearlyData) {
                return $yearlyData->sortByDesc('average_marks')->first(); // Get the best performing school each year
            });

        return [
            'schoolPerformance' => $schoolPerformance,
            'participantPerformance' => $participantPerformance,
            'bestSchools' => $bestSchools,
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

    public function getWorstSchoolsForChallenge($challengeName)
    {
        // Get the worst performing schools for the given challenge
        $worstSchools = Result::select('schoolName as school', DB::raw('AVG(totalScore) as average_marks'))
            ->where('challengeName', $challengeName)
            ->groupBy('schoolName')
            ->orderBy('average_marks') // Ordering by average_marks in ascending order
            ->limit(10) // Limiting to the bottom 10 schools
            ->get();

        // Add position to each school
        foreach ($worstSchools as $index => $school) {
            $school->position = $index + 1;
        }

        return $worstSchools;
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

    public function render()
    {
        $data = Result::query();

        $instance = getCrudConfig('result');
        if ($instance->searchable()) {
            $array = (array) $instance->searchable();
            $data->where(function (Builder $query) use ($array) {
                foreach ($array as $item) {
                    if (!\Str::contains($item, '.')) {
                        $query->orWhere($item, 'like', '%' . $this->search . '%');
                    } else {
                        $array = explode('.', $item);
                        $query->orWhereHas($array[0], function (Builder $query) use ($array) {
                            $query->where($array[1], 'like', '%' . $this->search . '%');
                        });
                    }
                }
            });
        }

        if ($this->sortColumn) {
            $data->orderBy($this->sortColumn, $this->sortType);
        } else {
            $data->latest('results_id');
        }

        $data = $data->paginate(config('easy_panel.pagination_count', 15));

        // Pass all required data to the view
        return view('livewire.admin.result.read', [
            'results' => $data,
            'correctQuestions' => $this->getMostCorrectlyAnsweredQuestions(),
            'schoolRankings' => $this->getSchoolRankings(),
            'performanceData' => $this->getPerformanceOverYears(),
            'repetitionData' => $this->getRepetitionData('example_participant'), // Pass a real participant name
            'worstSchools' => $this->getWorstSchoolsForChallenge('example_challenge'), // Pass a real challenge name
            'bestSchools' => $this->getBestSchools(),
            'incompleteParticipants' => $this->getIncompleteParticipants(),
            'fastestParticipants' => $this->getFastestParticipants(),
        ])->layout('admin::layouts.app', ['title' => __(\Str::plural('Result'))]);
    }
}

<?php

// app/Imports/QuestionsImport.php
namespace App\Imports;

use App\Models\Questions;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class QuestionsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Log::info('Processing row:', $row->toArray());

            $questions = Questions::where('questions', $row['questions'])->first();

            if ($questions) {
                $questions->update([
                    'marks' => $row['marks'],
                ]);
            } else {
                Questions::create([
                    'questions' => $row['questions'],
                    'marks' => $row['marks'],
                ]);
            }
        }
    }
}


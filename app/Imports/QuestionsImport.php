<?php

namespace App\Imports;

use App\Models\Questions;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuestionsImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $questions = Questions::where('questions', $row['questions'])->first();
            if($questions){

                $questions->update([
                    'marks' => $row['marks'],
                ]);

            }else{

                questions::create([
                    'questions' => $row['questions'],
                    'marks' => $row['marks'],
                ]);
            }

        }
    }
}

<?php

namespace App\Imports;

use App\Models\Answers;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AnswersImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $answers = Answers::where('answers', $row['answers'])->first();
            if($answers){

                $answers->update([
                    'answers' => $row['answers'],
                ]);

            }else{

                answers::create([
                    'answers' => $row['answers'],

                ]);
            }

        }
    }
}

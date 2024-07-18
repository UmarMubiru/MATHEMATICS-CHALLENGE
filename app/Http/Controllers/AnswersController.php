<?php

namespace App\Http\Controllers;

use App\Models\Answers;
use Illuminate\Http\Request;
use App\Imports\AnswersImport;
use Maatwebsite\Excel\Facades\Excel;

class AnswersController extends Controller
{
    public function index()
    {
        $answers = Answer::all();
        return view('answers.index', compact('answers'));
    }

    public function importExcelData(Request $request)
    {
        $request->validate([
            'import_file' => [
                'required',
                'file'
            ],
        ]);

        Excel::import(new AnswersImport, $request->file('import_file'));

        return redirect()->back()->with('status', 'Imported Successfully');
    }
}

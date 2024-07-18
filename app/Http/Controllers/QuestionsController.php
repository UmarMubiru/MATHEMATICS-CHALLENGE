<?php

namespace App\Http\Controllers;

use App\Models\Questions;
use Illuminate\Http\Request;
use App\Imports\QuestionsImport;
use Maatwebsite\Excel\Facades\Excel;

class QuestionsController extends Controller
{
    public function index()
    {
        $questions = Questions::all();
        return view('questions.index', compact('questions'));
    }

    public function importExcelData(Request $request)
    {
        $request->validate([
            'import_file' => [
                'required',
                'file'
            ],
        ]);

        Excel::import(new QuestionsImport, $request->file('import_file'));

        return redirect()->back()->with('status', 'Imported Successfully');
    }
}

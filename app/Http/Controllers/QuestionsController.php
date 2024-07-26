<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\QuestionsImport;
use Maatwebsite\Excel\Facades\Excel;

class QuestionsController extends Controller

{
    public function importExcelData(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'import_file' => 'required|mimes:xlsx,xls,csv|max:2048', // Add max size if needed
        ]);

        // Check if the file is uploaded
        if ($request->hasFile('import_file')) {
            // Import the data
            Excel::import(new QuestionsImport, $request->file('import_file'));

            // Return a response
            return redirect()->back()->with('status', 'Questions imported successfully.');
        }

        // Return error if no file was uploaded
        return redirect()->back()->with('status', 'Please upload a valid file.');

        Log::info('Request data:', $request->all());

    }
}

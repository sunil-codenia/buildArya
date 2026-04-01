<?php

namespace App\Http\Controllers;

use App\Imports\YourImportClass;
use Illuminate\Http\Request;
use Excel;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

class ExcelImportController extends Controller
{
    public function import(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
 
        // Get the uploaded file
        $file = $request->file('file');
 
        // Process the Excel file
       
        // Excel::import(new YourImportClass, $file);
 
        return redirect()->back()->with('success', 'Excel file imported successfully!');
    }
}

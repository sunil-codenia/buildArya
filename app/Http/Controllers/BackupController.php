<?php

namespace App\Http\Controllers;
use App\Exports\BackupExport;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BackupController extends Controller
{
    public function generateBackup(Request $request){
        $dbName = $request->session()->get('comp_db_conn_name');
        $mytime = Carbon::now();
         return Excel::download(new BackupExport($dbName), 'Construction_Munshi_Backup_'.$mytime.'_.xlsx');
    }
}

<?php

namespace App\Exports;

use App\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\expense\ExpenseModel;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class MachineryExport implements FromView
{

    use Exportable;
    protected $user_db_conn_name;
    protected $start_date;
    protected $end_date;
    protected $report_code;
    protected $sitename;
    protected $headname;


    public function __construct($user_db_conn_name, $start_date = null, $end_date = null, $report_code = null, $sitename = null,  $headname = null)

    {
        $this->user_db_conn_name = $user_db_conn_name;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->report_code = $report_code;
        $this->sitename = $sitename;
        $this->headname = $headname;
    }

    public function view(): View
    {

        if ($this->report_code == 1) {
            return view('layouts.machinery.exports.purrAccToHead', [
                'data' => DB::connection($this->user_db_conn_name)
                ->table('machinery_details')
                ->leftjoin('sites as ws', 'ws.id', '=', 'machinery_details.site_id')
                ->leftjoin('expenses', 'expenses.id', '=', 'machinery_details.expense_id')
                ->leftjoin('sites as ps', 'ps.id', '=', 'expenses.site_id')
                ->leftjoin('users as u', 'u.id', '=', 'expenses.user_id')
             
                ->leftJoin('bills_party', function ($join) {
                    $join->on('expenses.party_id', '=', 'bills_party.id')
                        ->where('expenses.party_type', '=', 'bill');
                })
                ->leftJoin('expense_party', function ($join) {
                    $join->on('expenses.party_id', '=', 'expense_party.id')
                        ->where('expenses.party_type', '=', 'expense');
                })
                ->selectRaw('machinery_details.*, ws.name as working_site, ps.name as purchase_site,expenses.date,u.name as user_name, CASE WHEN expenses.party_type = "bill" THEN bills_party.name WHEN expenses.party_type = "expense" THEN expense_party.name END AS party_name')
                ->where('machinery_details.head_id',$this->headname)
                ->whereBetween('expenses.date', [$this->start_date, $this->end_date])
                ->orderBy('machinery_details.id', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],
                'headname' => DB::connection($this->user_db_conn_name)->table('machinery_head')->where('id',$this->headname)->get()[0]->name

            ]);
        }else   if ($this->report_code == 2) {
            return view('layouts.machinery.exports.purrAccToSite', [
                'data' => DB::connection($this->user_db_conn_name)
                ->table('machinery_details')
                ->leftJoin('machinery_head','machinery_head.id','machinery_details.head_id')
                ->leftjoin('sites as ws', 'ws.id', '=', 'machinery_details.site_id')
                ->leftjoin('expenses', 'expenses.id', '=', 'machinery_details.expense_id')
                ->leftjoin('users as u', 'u.id', '=', 'expenses.user_id')
             
                ->leftJoin('bills_party', function ($join) {
                    $join->on('expenses.party_id', '=', 'bills_party.id')
                        ->where('expenses.party_type', '=', 'bill');
                })
                ->leftJoin('expense_party', function ($join) {
                    $join->on('expenses.party_id', '=', 'expense_party.id')
                        ->where('expenses.party_type', '=', 'expense');
                })
                ->selectRaw('machinery_details.*, ws.name as working_site, machinery_head.name as head_name,expenses.date,u.name as user_name, CASE WHEN expenses.party_type = "bill" THEN bills_party.name WHEN expenses.party_type = "expense" THEN expense_party.name END AS party_name')
                ->where('expenses.site_id',$this->sitename)
                ->whereBetween('expenses.date', [$this->start_date, $this->end_date])
                ->orderBy('machinery_details.id', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],
                'sitename' => DB::connection($this->user_db_conn_name)->table('sites')->where('id',$this->sitename)->get()[0]->name

            ]);
        }else if ($this->report_code == 3) {
            return view('layouts.machinery.exports.compPurr', [
                'data' => DB::connection($this->user_db_conn_name)
                ->table('machinery_details')
                ->leftJoin('machinery_head','machinery_head.id','machinery_details.head_id')
                ->leftjoin('sites as ws', 'ws.id', '=', 'machinery_details.site_id')
                ->leftjoin('expenses', 'expenses.id', '=', 'machinery_details.expense_id')
                ->leftjoin('sites as ps', 'ps.id', '=', 'expenses.site_id')
                ->leftjoin('users as u', 'u.id', '=', 'expenses.user_id')
             
                ->leftJoin('bills_party', function ($join) {
                    $join->on('expenses.party_id', '=', 'bills_party.id')
                        ->where('expenses.party_type', '=', 'bill');
                })
                ->leftJoin('expense_party', function ($join) {
                    $join->on('expenses.party_id', '=', 'expense_party.id')
                        ->where('expenses.party_type', '=', 'expense');
                })
                ->selectRaw('machinery_details.*, ws.name as working_site,  ps.name as purchase_site, machinery_head.name as head_name,expenses.date,u.name as user_name, CASE WHEN expenses.party_type = "bill" THEN bills_party.name WHEN expenses.party_type = "expense" THEN expense_party.name END AS party_name')                
                ->whereBetween('expenses.date', [$this->start_date, $this->end_date])
                ->orderBy('machinery_details.id', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],             
            ]);
        }else if ($this->report_code == 4) {
            return view('layouts.machinery.exports.saleAccToHead', [

                'data' => DB::connection($this->user_db_conn_name)
                ->table('machinery_details')
                ->leftjoin('sites as ss', 'ss.id', '=', 'machinery_details.site_id')
                ->leftjoin('machinery_transaction as mt', 'mt.machinery_id', '=', 'machinery_details.id')
                
                ->selectRaw('machinery_details.*, ss.name as sale_site,  CASE WHEN mt.transaction_type = "Sold" THEN mt.create_datetime END AS sale_date')
                ->where('machinery_details.head_id', $this->headname)
                ->where('mt.transaction_type', 'Sold')
                ->whereBetween('mt.create_datetime', [$this->start_date, $this->end_date])
                ->orderBy('machinery_details.id', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],   
                'headname' => DB::connection($this->user_db_conn_name)->table('machinery_head')->where('id',$this->headname)->get()[0]->name
          
            ]);
        }
        else if ($this->report_code == 5) {
            return view('layouts.machinery.exports.saleAccToSite', [

                'data' => DB::connection($this->user_db_conn_name)
                ->table('machinery_details')
                ->leftjoin('machinery_transaction as mt', 'mt.machinery_id', '=', 'machinery_details.id')
                ->leftJoin('machinery_head','machinery_head.id','machinery_details.head_id')
                ->selectRaw('machinery_details.*,  machinery_head.name as head_name, CASE WHEN mt.transaction_type = "Sold" THEN mt.create_datetime END AS sale_date')
                ->where('machinery_details.site_id', $this->sitename)
                ->where('mt.transaction_type', 'Sold')
                ->whereBetween('mt.create_datetime', [$this->start_date, $this->end_date])
                ->orderBy('machinery_details.id', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],   
                'sitename' => DB::connection($this->user_db_conn_name)->table('sites')->where('id',$this->sitename)->get()[0]->name
          
            ]);
        }
        else if ($this->report_code == 6) {
            return view('layouts.machinery.exports.compSale', [

                'data' => DB::connection($this->user_db_conn_name)
                ->table('machinery_details')
                ->leftjoin('sites as ss', 'ss.id', '=', 'machinery_details.site_id')

                ->leftJoin('machinery_head', 'machinery_head.id', 'machinery_details.head_id')
                ->leftjoin('machinery_transaction as mt', 'mt.machinery_id', '=', 'machinery_details.id')                
                ->selectRaw('machinery_details.*, machinery_head.name as head_name,  ss.name as sale_site,  CASE WHEN mt.transaction_type = "Sold" THEN mt.create_datetime END AS sale_date')                  
                ->where('mt.transaction_type', 'Sold')
                ->whereBetween('mt.create_datetime', [$this->start_date, $this->end_date])
                ->orderBy('machinery_details.id', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],   
            ]);
        }
        else if ($this->report_code == 7) {
            return view('layouts.machinery.exports.transAccToHead', [

                'data' => DB::connection($this->user_db_conn_name)
                ->table('machinery_transaction')
                ->leftjoin('sites as fs', 'fs.id', '=', 'machinery_transaction.from_site')
                ->leftjoin('sites as ts', 'ts.id', '=', 'machinery_transaction.to_site')
                ->leftJoin('machinery_details', 'machinery_details.id', 'machinery_transaction.machinery_id')
                ->selectRaw('machinery_transaction.*, machinery_details.name as machine_name,  fs.name as from_site_name, ts.name as to_site_name')                                  
                ->where('machinery_details.head_id',$this->headname)
                ->whereBetween('machinery_transaction.create_datetime', [$this->start_date, $this->end_date])
                ->orderBy('machinery_transaction.machinery_id', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],   
                'headname' => DB::connection($this->user_db_conn_name)->table('machinery_head')->where('id',$this->headname)->get()[0]->name

            ]);
        }  else if ($this->report_code == 8) {
            return view('layouts.machinery.exports.compTrans', [

                'data' => DB::connection($this->user_db_conn_name)
                ->table('machinery_transaction')
                ->leftjoin('sites as fs', 'fs.id', '=', 'machinery_transaction.from_site')
                ->leftjoin('sites as ts', 'ts.id', '=', 'machinery_transaction.to_site')
                ->leftJoin('machinery_details', 'machinery_details.id', 'machinery_transaction.machinery_id')
                ->leftJoin('machinery_head', 'machinery_head.id', 'machinery_details.head_id')
                ->selectRaw('machinery_transaction.*, machinery_details.name as machine_name, machinery_head.name as head_name,  fs.name as from_site_name, ts.name as to_site_name')                                  
                ->whereBetween('machinery_transaction.create_datetime', [$this->start_date, $this->end_date])
                ->orderBy('machinery_transaction.machinery_id', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],   

            ]);
        }
        else if ($this->report_code == 9) {
            return view('layouts.machinery.exports.docAccToHead', [

                'data' =>  DB::connection($this->user_db_conn_name)
                ->table('machinery_documents')
                ->leftJoin('machinery_details', 'machinery_details.id', 'machinery_documents.machinery_id')
                ->leftJoin('machinery_head', 'machinery_head.id', 'machinery_details.head_id')
                ->selectRaw('machinery_documents.*, machinery_details.name as machine_name')       
                ->where('machinery_details.head_id',$this->headname)                           
                ->whereBetween('machinery_documents.create_date', [$this->start_date, $this->end_date])
                ->orderBy('machinery_documents.machinery_id', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],   
                'headname' => DB::connection($this->user_db_conn_name)->table('machinery_head')->where('id',$this->headname)->get()[0]->name


            ]);
        } else if ($this->report_code == 10) {
            return view('layouts.machinery.exports.compDoc', [

                'data' =>  DB::connection($this->user_db_conn_name)
                ->table('machinery_documents')
                ->leftJoin('machinery_details', 'machinery_details.id', 'machinery_documents.machinery_id')
                ->leftJoin('machinery_head', 'machinery_head.id', 'machinery_details.head_id')
                ->selectRaw('machinery_documents.*, machinery_details.name as machine_name,machinery_head.name as head_name')                                  
                ->whereBetween('machinery_documents.create_date', [$this->start_date, $this->end_date])
                ->orderBy('machinery_documents.machinery_id', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],   
                


            ]);
        }
        else if ($this->report_code == 11) {
            return view('layouts.machinery.exports.servAccToHead', [

                'data' =>  DB::connection($this->user_db_conn_name)
                ->table('machinery_services')
                ->leftJoin('machinery_details', 'machinery_details.id', 'machinery_services.machinery_id')
                ->leftJoin('machinery_head', 'machinery_head.id', 'machinery_details.head_id')
                ->leftJoin('users','users.id','machinery_services.user_id')
                ->selectRaw('machinery_services.*, machinery_details.name as machine_name,users.name as user_name')
                ->where('machinery_details.head_id',$this->headname)         
                ->whereBetween('machinery_services.create_date', [$this->start_date, $this->end_date])
                ->orderBy('machinery_services.machinery_id', 'desc')->get(),                
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],   
                'headname' => DB::connection($this->user_db_conn_name)->table('machinery_head')->where('id',$this->headname)->get()[0]->name


            ]);
        } else if ($this->report_code == 12) {
            return view('layouts.machinery.exports.compServ', [

                'data' =>  DB::connection($this->user_db_conn_name)
                ->table('machinery_services')
                ->leftJoin('machinery_details', 'machinery_details.id', 'machinery_services.machinery_id')
                ->leftJoin('machinery_head', 'machinery_head.id', 'machinery_details.head_id')
                ->leftJoin('users','users.id','machinery_services.user_id')
                ->selectRaw('machinery_services.*, machinery_details.name as machine_name,users.name as user_name,machinery_head.name as head_name')
                ->whereBetween('machinery_services.create_date', [$this->start_date, $this->end_date])
                ->orderBy('machinery_services.machinery_id', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],   
                


            ]);
        }
        else if ($this->report_code == 13) {
            $site = DB::connection($this->user_db_conn_name)->table('sites')->where('id',$this->sitename)->first();

            return view('layouts.machinery.exports.siteMachineryReport', [

                'data' =>DB::connection($this->user_db_conn_name)->table('machinery_details')->leftjoin('sites', 'sites.id', '=', 'machinery_details.site_id')->leftjoin('machinery_head', 'machinery_head.id', '=', 'machinery_details.head_id')->select('machinery_details.*', 'sites.name as site', 'machinery_head.name as head')->where('machinery_details.site_id','=',$this->sitename)->get(),            
                'site_name' => $site->name,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],   
                


            ]);
        }
    }
}

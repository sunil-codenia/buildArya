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

class AssetsExport implements FromView
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
            return view('layouts.asset.exports.purrAccToHead', [
                'data' => DB::connection($this->user_db_conn_name)
                ->table('assets')
                ->leftjoin('sites as ws', 'ws.id', '=', 'assets.site_id')
                ->leftjoin('expenses', 'expenses.id', '=', 'assets.expense_id')
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
                ->selectRaw('assets.*, ws.name as working_site, ps.name as purchase_site,expenses.date,u.name as user_name, CASE WHEN expenses.party_type = "bill" THEN bills_party.name WHEN expenses.party_type = "expense" THEN expense_party.name END AS party_name')
                ->where('assets.head_id',$this->headname)
                ->whereBetween('expenses.date', [$this->start_date, $this->end_date])
                ->orderBy('assets.id', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],
                'headname' => DB::connection($this->user_db_conn_name)->table('asset_head')->where('id',$this->headname)->get()[0]->name

            ]);
        }else   if ($this->report_code == 2) {
            return view('layouts.asset.exports.purrAccToSite', [
                'data' => DB::connection($this->user_db_conn_name)
                ->table('assets')
                ->leftJoin('asset_head','asset_head.id','assets.head_id')
                ->leftjoin('sites as ws', 'ws.id', '=', 'assets.site_id')
                ->leftjoin('expenses', 'expenses.id', '=', 'assets.expense_id')
                ->leftjoin('users as u', 'u.id', '=', 'expenses.user_id')
             
                ->leftJoin('bills_party', function ($join) {
                    $join->on('expenses.party_id', '=', 'bills_party.id')
                        ->where('expenses.party_type', '=', 'bill');
                })
                ->leftJoin('expense_party', function ($join) {
                    $join->on('expenses.party_id', '=', 'expense_party.id')
                        ->where('expenses.party_type', '=', 'expense');
                })
                ->selectRaw('assets.*, ws.name as working_site, asset_head.name as head_name,expenses.date,u.name as user_name, CASE WHEN expenses.party_type = "bill" THEN bills_party.name WHEN expenses.party_type = "expense" THEN expense_party.name END AS party_name')
                ->where('expenses.site_id',$this->sitename)
                ->whereBetween('expenses.date', [$this->start_date, $this->end_date])
                ->orderBy('assets.id', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],
                'sitename' => DB::connection($this->user_db_conn_name)->table('sites')->where('id',$this->sitename)->get()[0]->name

            ]);
        }else if ($this->report_code == 3) {
            return view('layouts.asset.exports.compPurr', [
                'data' => DB::connection($this->user_db_conn_name)
                ->table('assets')
                ->leftJoin('asset_head','asset_head.id','assets.head_id')
                ->leftjoin('sites as ws', 'ws.id', '=', 'assets.site_id')
                ->leftjoin('expenses', 'expenses.id', '=', 'assets.expense_id')
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
                ->selectRaw('assets.*, ws.name as working_site,  ps.name as purchase_site, asset_head.name as head_name,expenses.date,u.name as user_name, CASE WHEN expenses.party_type = "bill" THEN bills_party.name WHEN expenses.party_type = "expense" THEN expense_party.name END AS party_name')                
                ->whereBetween('expenses.date', [$this->start_date, $this->end_date])
                ->orderBy('assets.id', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],             
            ]);
        }else if ($this->report_code == 4) {
            return view('layouts.asset.exports.saleAccToHead', [

                'data' => DB::connection($this->user_db_conn_name)
                ->table('assets')
                ->leftjoin('sites as ss', 'ss.id', '=', 'assets.site_id')
                ->leftjoin('asset_transaction as at', 'at.asset_id', '=', 'assets.id')
                
                ->selectRaw('assets.*, ss.name as sale_site,  CASE WHEN at.transaction_type = "Sold" THEN at.create_datetime END AS sale_date')
                ->where('assets.head_id', $this->headname)
                ->where('at.transaction_type', 'Sold')
                ->whereBetween('at.create_datetime', [$this->start_date, $this->end_date])
                ->orderBy('assets.id', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],   
                'headname' => DB::connection($this->user_db_conn_name)->table('asset_head')->where('id',$this->headname)->get()[0]->name
          
            ]);
        }
        else if ($this->report_code == 5) {
            return view('layouts.asset.exports.saleAccToSite', [

                'data' => DB::connection($this->user_db_conn_name)
                ->table('assets')
                ->leftjoin('asset_transaction as at', 'at.asset_id', '=', 'assets.id')
                ->leftJoin('asset_head','asset_head.id','assets.head_id')
                ->selectRaw('assets.*,  asset_head.name as head_name, CASE WHEN at.transaction_type = "Sold" THEN at.create_datetime END AS sale_date')
                ->where('assets.site_id', $this->sitename)
                ->where('at.transaction_type', 'Sold')
                ->whereBetween('at.create_datetime', [$this->start_date, $this->end_date])
                ->orderBy('assets.id', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],   
                'sitename' => DB::connection($this->user_db_conn_name)->table('sites')->where('id',$this->sitename)->get()[0]->name
          
            ]);
        }
        else if ($this->report_code == 6) {
            return view('layouts.asset.exports.compSale', [

                'data' => DB::connection($this->user_db_conn_name)
                ->table('assets')
                ->leftjoin('sites as ss', 'ss.id', '=', 'assets.site_id')

                ->leftJoin('asset_head', 'asset_head.id', 'assets.head_id')
                ->leftjoin('asset_transaction as at', 'at.asset_id', '=', 'assets.id')                
                ->selectRaw('assets.*, asset_head.name as head_name,  ss.name as sale_site,  CASE WHEN at.transaction_type = "Sold" THEN at.create_datetime END AS sale_date')                  
                ->where('at.transaction_type', 'Sold')
                ->whereBetween('at.create_datetime', [$this->start_date, $this->end_date])
                ->orderBy('assets.id', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],   
            ]);
        }
        else if ($this->report_code == 7) {
            return view('layouts.asset.exports.transAccToHead', [

                'data' => DB::connection($this->user_db_conn_name)
                ->table('asset_transaction')
                ->leftjoin('sites as fs', 'fs.id', '=', 'asset_transaction.from_site')
                ->leftjoin('sites as ts', 'ts.id', '=', 'asset_transaction.to_site')
                ->leftJoin('assets', 'assets.id', 'asset_transaction.asset_id')
                ->selectRaw('asset_transaction.*, assets.name as asset_name,  fs.name as from_site_name, ts.name as to_site_name')                                  
                ->where('assets.head_id',$this->headname)
                ->whereBetween('asset_transaction.create_datetime', [$this->start_date, $this->end_date])
                ->orderBy('asset_transaction.asset_id', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],   
                'headname' => DB::connection($this->user_db_conn_name)->table('asset_head')->where('id',$this->headname)->get()[0]->name

            ]);
        }  else if ($this->report_code == 8) {
            return view('layouts.asset.exports.compTrans', [

                'data' => DB::connection($this->user_db_conn_name)
                ->table('asset_transaction')
                ->leftjoin('sites as fs', 'fs.id', '=', 'asset_transaction.from_site')
                ->leftjoin('sites as ts', 'ts.id', '=', 'asset_transaction.to_site')
                ->leftJoin('assets', 'assets.id', 'asset_transaction.asset_id')
                ->leftJoin('asset_head', 'asset_head.id', 'assets.head_id')
                ->selectRaw('asset_transaction.*, assets.name as asset_name, asset_head.name as head_name,  fs.name as from_site_name, ts.name as to_site_name')                                  
                ->whereBetween('asset_transaction.create_datetime', [$this->start_date, $this->end_date])
                ->orderBy('asset_transaction.asset_id', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],   

            ]);
        }
        else if ($this->report_code == 9) {
            $site = DB::connection($this->user_db_conn_name)->table('sites')->where('id',$this->sitename)->first();

            return view('layouts.asset.exports.siteAssetReport', [

                'data' => DB::connection($this->user_db_conn_name)->table('assets')->leftjoin('sites', 'sites.id', '=', 'assets.site_id')->leftjoin('asset_head', 'asset_head.id', '=', 'assets.head_id')->select('assets.*', 'sites.name as site', 'asset_head.name as head')->where('assets.site_id','=',$this->sitename)->get()                ,            
                'site_name' => $site->name,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],   
                


            ]);
        }
    }
}

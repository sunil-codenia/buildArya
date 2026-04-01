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

class ExpenseExport implements FromView
{

    use Exportable;
    protected $user_db_conn_name;
    protected $start_date;
    protected $end_date;
    protected $report_code;
    protected $sitename;
    protected $partyname;
    protected $partytype;
    protected $headname;


    public function __construct($user_db_conn_name, $start_date = null, $end_date = null, $report_code = null, $sitename = null, $partyname = null, $headname = null,$partytype=null)

    {
        $this->user_db_conn_name = $user_db_conn_name;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->partyname = $partyname;
        $this->report_code = $report_code;
        $this->sitename = $sitename;
        $this->headname = $headname;
        $this->partytype = $partytype;
    }

    public function view(): View
    {

        if ($this->report_code == 1) {

            return view('layouts.expense.exports.accToDate', [
                'Expenses' => DB::connection($this->user_db_conn_name)
                    ->table('expenses')
                    ->leftJoin('bills_party', function ($join) {
                        $join->on('expenses.party_id', '=', 'bills_party.id')
                            ->where('expenses.party_type', '=', 'bill');
                    })
                    ->leftJoin('expense_party', function ($join) {
                        $join->on('expenses.party_id', '=', 'expense_party.id')
                            ->where('expenses.party_type', '=', 'expense');
                    })
                    ->leftjoin('expense_head', 'expense_head.id', '=', 'expenses.head_id')
                    ->leftjoin('sites', 'sites.id', '=', 'expenses.site_id')
                    ->leftjoin('users', 'users.id', '=', 'expenses.user_id')
                    ->selectRaw('expenses.*, CASE WHEN expenses.party_type = "bill" THEN bills_party.name WHEN expenses.party_type = "expense" THEN expense_party.name END AS party_name, sites.name as site_name, users.name as user_name,expense_head.name as head_name')
                    ->whereBetween('expenses.create_datetime', [$this->start_date, $this->end_date])
                    ->orderBy('expenses.create_datetime', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'color'=>session()->get('primary_color')[0],
                'sec_color'=>session()->get('secondry_color')[0],
            ]);
        } elseif ($this->report_code == 2) {

            return view('layouts.expense.exports.accToSite', [
                'Expenses' => DB::connection($this->user_db_conn_name)
                    ->table('expenses')
                    ->leftJoin('bills_party', function ($join) {
                        $join->on('expenses.party_id', '=', 'bills_party.id')
                            ->where('expenses.party_type', '=', 'bill');
                    })
                    ->leftJoin('expense_party', function ($join) {
                        $join->on('expenses.party_id', '=', 'expense_party.id')
                            ->where('expenses.party_type', '=', 'expense');
                    })
                    ->leftjoin('expense_head', 'expense_head.id', '=', 'expenses.head_id')
                    ->leftjoin('sites', 'sites.id', '=', 'expenses.site_id')
                    ->leftjoin('users', 'users.id', '=', 'expenses.user_id')
                    ->selectRaw(
                        'expenses.*, CASE WHEN expenses.party_type = "bill" THEN bills_party.name WHEN expenses.party_type = "expense" THEN expense_party.name END AS party_name, sites.name as site_name, users.name as user_name,expense_head.name as head_name'
                    )
                    ->where([['expenses.site_id', '=', $this->sitename]])
                    ->whereBetween('expenses.create_datetime', [$this->start_date, $this->end_date])
                    ->orderBy('expenses.create_datetime', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'sitename' => getSiteDetailsById($this->sitename)->name,
                'color'=>session()->get('primary_color')[0],
                'sec_color'=>session()->get('secondry_color')[0],
            ]);
        } elseif ($this->report_code == 3) {
            return view('layouts.expense.exports.accToParty', [
                'Expenses' => DB::connection($this->user_db_conn_name)
                    ->table('expenses')
                    ->leftJoin('bills_party', function ($join) {
                        $join->on('expenses.party_id', '=', 'bills_party.id')
                            ->where('expenses.party_type', '=', 'bill');
                    })
                    ->leftJoin('expense_party', function ($join) {
                        $join->on('expenses.party_id', '=', 'expense_party.id')
                            ->where('expenses.party_type', '=', 'expense');
                    })
                    ->leftjoin('expense_head', 'expense_head.id', '=', 'expenses.head_id')
                    ->leftjoin('sites', 'sites.id', '=', 'expenses.site_id')
                    ->leftjoin('users', 'users.id', '=', 'expenses.user_id')
                    ->selectRaw(
                        'expenses.*, CASE WHEN expenses.party_type = "bill" THEN bills_party.name WHEN expenses.party_type = "expense" THEN expense_party.name END AS party_name, sites.name as site_name, users.name as user_name,expense_head.name as head_name'
                    )
                    ->whereBetween('expenses.create_datetime', [$this->start_date, $this->end_date])
                    ->where('expenses.party_id', '=', $this->partyname)
                    ->where('expenses.party_type', '=', $this->partytype)
                    ->orderBy('expenses.create_datetime', 'desc')->get(),

                'start_date' => $this->start_date,
                'end_date' => $this->end_date,                
                'partyname' => $this->partytype == 'expense' ? DB::connection($this->user_db_conn_name)->table('expense_party')->where('id',$this->partyname)->get()[0]->name : DB::connection($this->user_db_conn_name)->table('bills_party')->where('id',$this->partyname)->get()[0]->name,               
                'color'=>session()->get('primary_color')[0],
                'sec_color'=>session()->get('secondry_color')[0],
            ]);
        } elseif ($this->report_code == 4) {

            return view('layouts.expense.exports.accToPartyAtSite', [
                'Expenses' => DB::connection($this->user_db_conn_name)
                    ->table('expenses')
                    ->leftJoin('bills_party', function ($join) {
                        $join->on('expenses.party_id', '=', 'bills_party.id')
                            ->where('expenses.party_type', '=', 'bill');
                    })
                    ->leftJoin('expense_party', function ($join) {
                        $join->on('expenses.party_id', '=', 'expense_party.id')
                            ->where('expenses.party_type', '=', 'expense');
                    })
                    ->leftjoin('expense_head', 'expense_head.id', '=', 'expenses.head_id')
                    ->leftjoin('sites', 'sites.id', '=', 'expenses.site_id')
                    ->leftjoin('users', 'users.id', '=', 'expenses.user_id')
                    ->selectRaw(
                        'expenses.*, CASE WHEN expenses.party_type = "bill" THEN bills_party.name WHEN expenses.party_type = "expense" THEN expense_party.name END AS party_name, sites.name as site_name, users.name as user_name,expense_head.name as head_name'
                    )

                    ->whereBetween('expenses.create_datetime', [$this->start_date, $this->end_date])
                    ->where('expenses.party_id', '=', $this->partyname)
                    ->where('expenses.party_type', '=', $this->partytype)
                    ->where('expenses.site_id', '=', $this->sitename)
                    ->orderBy('expenses.create_datetime', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'partyname' => $this->partytype == 'expense' ? DB::connection($this->user_db_conn_name)->table('expense_party')->where('id',$this->partyname)->get()[0]->name : DB::connection($this->user_db_conn_name)->table('bills_party')->where('id',$this->partyname)->get()[0]->name,               
                'sitename' => getSiteDetailsById($this->sitename)->name,
                'color'=>session()->get('primary_color')[0],
                'sec_color'=>session()->get('secondry_color')[0],
             


            ]);
        } elseif ($this->report_code == 5) {

            return view('layouts.expense.exports.accToHead', [
                'Expenses' => DB::connection($this->user_db_conn_name)
                    ->table('expenses')
                    ->leftJoin('bills_party', function ($join) {
                        $join->on('expenses.party_id', '=', 'bills_party.id')
                            ->where('expenses.party_type', '=', 'bill');
                    })
                    ->leftJoin('expense_party', function ($join) {
                        $join->on('expenses.party_id', '=', 'expense_party.id')
                            ->where('expenses.party_type', '=', 'expense');
                    })
                    ->leftjoin('expense_head', 'expense_head.id', '=', 'expenses.head_id')
                    ->leftjoin('sites', 'sites.id', '=', 'expenses.site_id')
                    ->leftjoin('users', 'users.id', '=', 'expenses.user_id')
                    ->selectRaw(
                        'expenses.*, CASE WHEN expenses.party_type = "bill" THEN bills_party.name WHEN expenses.party_type = "expense" THEN expense_party.name END AS party_name, sites.name as site_name, users.name as user_name,expense_head.name as head_name'
                    )

                    ->whereBetween('expenses.create_datetime', [$this->start_date, $this->end_date])
                    ->where('expenses.head_id', '=', $this->headname)
                    ->orderBy('expenses.create_datetime', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'headname' => DB::connection($this->user_db_conn_name)->table('expense_head')->where('id',$this->headname)->get()[0]->name,
                'color'=>session()->get('primary_color')[0],
                'sec_color'=>session()->get('secondry_color')[0],
                
            ]);
        } else {
            return view('layouts.expense.exports.accToHeadAtSite', [
                'Expenses' => DB::connection($this->user_db_conn_name)
                    ->table('expenses')
                    ->leftJoin('bills_party', function ($join) {
                        $join->on('expenses.party_id', '=', 'bills_party.id')
                            ->where('expenses.party_type', '=', 'bill');
                    })
                    ->leftJoin('expense_party', function ($join) {
                        $join->on('expenses.party_id', '=', 'expense_party.id')
                            ->where('expenses.party_type', '=', 'expense');
                    })
                    ->leftjoin('expense_head', 'expense_head.id', '=', 'expenses.head_id')
                    ->leftjoin('sites', 'sites.id', '=', 'expenses.site_id')
                    ->leftjoin('users', 'users.id', '=', 'expenses.user_id')
                    ->selectRaw(
                        'expenses.*, CASE WHEN expenses.party_type = "bill" THEN bills_party.name WHEN expenses.party_type = "expense" THEN expense_party.name END AS party_name, sites.name as site_name, users.name as user_name,expense_head.name as head_name'
                    )
                    ->whereBetween('expenses.create_datetime', [$this->start_date, $this->end_date])
                    ->where('expenses.head_id', '=', $this->headname)->where('expenses.site_id', '=', $this->sitename)
                    ->orderBy('expenses.create_datetime', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'headname' => DB::connection($this->user_db_conn_name)->table('expense_head')->where('id',$this->headname)->get()[0]->name,
                'sitename' => getSiteDetailsById($this->sitename)->name,
                'color'=>session()->get('primary_color')[0],
                'sec_color'=>session()->get('secondry_color')[0],
            ]);
        }
    }
}

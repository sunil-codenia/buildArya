<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class SiteBillExport implements FromView
{

    use Exportable;

    protected $user_db_conn_name;
    protected $start_date;
    protected $end_date;
    protected $report_code;
    protected $sitename;
    protected $partyname;

    protected $headname;

    public function __construct($user_db_conn_name, $start_date = null, $end_date = null, $report_code = null, $sitename = null, $partyname = null, $headname = null)

    {
        $this->user_db_conn_name = $user_db_conn_name;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->partyname = $partyname;
        $this->report_code = $report_code;
        $this->sitename = $sitename;
        $this->headname = $headname;
    }

    public function view(): View
    {
        if ($this->report_code == 1) {

            return view('layouts.bills.exports.accToDate', [


                'bills' => DB::connection($this->user_db_conn_name)
                    ->table('new_bill_entry')
                    ->leftjoin('users', 'users.id', '=', 'new_bill_entry.user_id')
                    ->leftjoin('sites', 'sites.id', '=', 'new_bill_entry.site_id')
                    ->leftjoin('bills_party', 'bills_party.id', '=', 'new_bill_entry.party_id')
                    ->select('new_bill_entry.*', 'users.name as user_name', 'sites.name as site_name', 'bills_party.name as party_name')
                    ->whereBetween('new_bill_entry.billdate', [$this->start_date, $this->end_date])
                    ->orderBy('new_bill_entry.billdate', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],
            ]);
        } else if ($this->report_code == 2) {
            $bills = DB::connection($this->user_db_conn_name)
                ->table('new_bill_entry')
                ->leftjoin('users', 'users.id', '=', 'new_bill_entry.user_id')
                ->leftjoin('sites', 'sites.id', '=', 'new_bill_entry.site_id')
                ->leftjoin('bills_party', 'bills_party.id', '=', 'new_bill_entry.party_id')
                ->select('new_bill_entry.*', 'users.name as user_name', 'sites.name as site_name', 'bills_party.name as party_name')
                ->whereBetween('new_bill_entry.billdate', [$this->start_date, $this->end_date])
                ->orderBy('new_bill_entry.billdate', 'desc')->get();
            $count = 0;
            foreach ($bills as $bill) {
                $items = DB::connection($this->user_db_conn_name)
                    ->table('new_bills_item_entry')
                    ->leftjoin('bills_work', 'bills_work.id', '=', 'new_bills_item_entry.work_id')
                    ->select('new_bills_item_entry.*', 'bills_work.name as work_name')
                    ->where('new_bills_item_entry.bill_id', '=', $bill->id)
                    ->get();
                $bills[$count++]->items = $items;
            }



            return view('layouts.bills.exports.accToDateDetailed', [
                'bills'=>$bills,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],
            ]);
        } else  if ($this->report_code == 3) {

            return view('layouts.bills.exports.accToItem', [
                'bills' => DB::connection($this->user_db_conn_name)
                    ->table('new_bill_entry')
                    ->leftjoin('users', 'users.id', '=', 'new_bill_entry.user_id')
                    ->leftjoin('sites', 'sites.id', '=', 'new_bill_entry.site_id')
                    ->leftjoin('bills_party', 'bills_party.id', '=', 'new_bill_entry.party_id')
                    ->leftjoin('new_bills_item_entry', 'new_bill_entry.id', '=', 'new_bills_item_entry.bill_id')
                    ->select('new_bill_entry.*', 'users.name as user_name', 'sites.name as site_name', 'bills_party.name as party_name', 'new_bills_item_entry.unit', 'new_bills_item_entry.rate', 'new_bills_item_entry.qty', 'new_bills_item_entry.amount as item_amount')
                    ->where('new_bills_item_entry.work_id', $this->headname)
                    ->whereBetween('new_bill_entry.billdate', [$this->start_date, $this->end_date])
                    ->orderBy('new_bill_entry.billdate', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'headname' => DB::connection($this->user_db_conn_name)->table('bills_work')->where('id', $this->headname)->get()[0]->name,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],
            ]);
        } else  if ($this->report_code == 4) {

            return view('layouts.bills.exports.accToItemAtSite', [
                'bills' => DB::connection($this->user_db_conn_name)
                    ->table('new_bill_entry')
                    ->leftjoin('users', 'users.id', '=', 'new_bill_entry.user_id')
                    ->leftjoin('sites', 'sites.id', '=', 'new_bill_entry.site_id')
                    ->leftjoin('bills_party', 'bills_party.id', '=', 'new_bill_entry.party_id')
                    ->leftjoin('new_bills_item_entry', 'new_bill_entry.id', '=', 'new_bills_item_entry.bill_id')
                    ->select('new_bill_entry.*', 'users.name as user_name', 'sites.name as site_name', 'bills_party.name as party_name', 'new_bills_item_entry.unit', 'new_bills_item_entry.rate', 'new_bills_item_entry.qty', 'new_bills_item_entry.amount as item_amount')
                    ->where('new_bills_item_entry.work_id', $this->headname)
                    ->where('new_bill_entry.site_id', $this->sitename)
                    ->whereBetween('new_bill_entry.billdate', [$this->start_date, $this->end_date])
                    ->orderBy('new_bill_entry.billdate', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'sitename' => getSiteDetailsById($this->sitename)->name,
                'headname' => DB::connection($this->user_db_conn_name)->table('bills_work')->where('id', $this->headname)->get()[0]->name,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],
            ]);
        } else  if ($this->report_code == 5) {

            return view('layouts.bills.exports.accToParty', [
                'bills' => DB::connection($this->user_db_conn_name)
                    ->table('new_bill_entry')
                    ->leftjoin('users', 'users.id', '=', 'new_bill_entry.user_id')
                    ->leftjoin('sites', 'sites.id', '=', 'new_bill_entry.site_id')
                    ->leftjoin('bills_party', 'bills_party.id', '=', 'new_bill_entry.party_id')
                    ->select('new_bill_entry.*', 'users.name as user_name', 'sites.name as site_name', 'bills_party.name as party_name')
                    ->where('new_bill_entry.party_id', $this->partyname)
                    ->whereBetween('new_bill_entry.billdate', [$this->start_date, $this->end_date])
                    ->orderBy('new_bill_entry.billdate', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'partyname' => DB::connection($this->user_db_conn_name)->table('bills_party')->where('id', $this->partyname)->get()[0]->name,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],
            ]);
        } else  if ($this->report_code == 6) {
            $bills =  DB::connection($this->user_db_conn_name)
                ->table('new_bill_entry')
                ->leftjoin('users', 'users.id', '=', 'new_bill_entry.user_id')
                ->leftjoin('sites', 'sites.id', '=', 'new_bill_entry.site_id')
                ->leftjoin('bills_party', 'bills_party.id', '=', 'new_bill_entry.party_id')
                ->select('new_bill_entry.*', 'users.name as user_name', 'sites.name as site_name', 'bills_party.name as party_name')
                ->where('new_bill_entry.party_id', $this->partyname)
                ->whereBetween('new_bill_entry.billdate', [$this->start_date, $this->end_date])
                ->orderBy('new_bill_entry.billdate', 'desc')->get();
            $count = 0;
            foreach ($bills as $bill) {
                $items = DB::connection($this->user_db_conn_name)
                    ->table('new_bills_item_entry')
                    ->leftjoin('bills_work', 'bills_work.id', '=', 'new_bills_item_entry.work_id')
                    ->select('new_bills_item_entry.*', 'bills_work.name as work_name')
                    ->where('new_bills_item_entry.bill_id', '=', $bill->id)
                    ->get();
                $bills[$count++]->items = $items;
            }

            return view('layouts.bills.exports.accToPartyDetailed', [
                'bills'=>$bills,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'partyname' => DB::connection($this->user_db_conn_name)->table('bills_party')->where('id', $this->partyname)->get()[0]->name,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],
            ]);
        } else  if ($this->report_code == 7) {

            return view('layouts.bills.exports.accToPartyAtSite', [


                'bills' => DB::connection($this->user_db_conn_name)
                    ->table('new_bill_entry')
                    ->leftjoin('users', 'users.id', '=', 'new_bill_entry.user_id')
                    ->leftjoin('sites', 'sites.id', '=', 'new_bill_entry.site_id')
                    ->leftjoin('bills_party', 'bills_party.id', '=', 'new_bill_entry.party_id')
                    ->select('new_bill_entry.*', 'users.name as user_name', 'sites.name as site_name', 'bills_party.name as party_name')
                    ->where('new_bill_entry.party_id', $this->partyname)
                    ->where('new_bill_entry.site_id', $this->sitename)
                    ->whereBetween('new_bill_entry.billdate', [$this->start_date, $this->end_date])
                    ->orderBy('new_bill_entry.billdate', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'partyname' => DB::connection($this->user_db_conn_name)->table('bills_party')->where('id', $this->partyname)->get()[0]->name,
                'sitename' => getSiteDetailsById($this->sitename)->name,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],
            ]);
        } else  if ($this->report_code == 8) {

            $bills = DB::connection($this->user_db_conn_name)
                ->table('new_bill_entry')
                ->leftjoin('users', 'users.id', '=', 'new_bill_entry.user_id')
                ->leftjoin('sites', 'sites.id', '=', 'new_bill_entry.site_id')
                ->leftjoin('bills_party', 'bills_party.id', '=', 'new_bill_entry.party_id')
                ->select('new_bill_entry.*', 'users.name as user_name', 'sites.name as site_name', 'bills_party.name as party_name')
                ->where('new_bill_entry.party_id', $this->partyname)
                ->where('new_bill_entry.site_id', $this->sitename)
                ->whereBetween('new_bill_entry.billdate', [$this->start_date, $this->end_date])
                ->orderBy('new_bill_entry.billdate', 'desc')->get();
            $count = 0;
            foreach ($bills as $bill) {
                $items = DB::connection($this->user_db_conn_name)
                    ->table('new_bills_item_entry')
                    ->leftjoin('bills_work', 'bills_work.id', '=', 'new_bills_item_entry.work_id')
                    ->select('new_bills_item_entry.*', 'bills_work.name as work_name')
                    ->where('new_bills_item_entry.bill_id', '=', $bill->id)
                    ->get();
                $bills[$count++]->items = $items;
            }
            return view('layouts.bills.exports.accToPartyAtSiteDetailed', [


                'bills'=>$bills,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'partyname' => DB::connection($this->user_db_conn_name)->table('bills_party')->where('id', $this->partyname)->get()[0]->name,
                'sitename' => getSiteDetailsById($this->sitename)->name,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],
            ]);
        } else  if ($this->report_code == 9) {

            return view('layouts.bills.exports.accToSite', [


                'bills' => DB::connection($this->user_db_conn_name)
                    ->table('new_bill_entry')
                    ->leftjoin('users', 'users.id', '=', 'new_bill_entry.user_id')
                    ->leftjoin('sites', 'sites.id', '=', 'new_bill_entry.site_id')
                    ->leftjoin('bills_party', 'bills_party.id', '=', 'new_bill_entry.party_id')
                    ->select('new_bill_entry.*', 'users.name as user_name', 'sites.name as site_name', 'bills_party.name as party_name')
                    ->where('new_bill_entry.site_id', $this->sitename)
                    ->whereBetween('new_bill_entry.billdate', [$this->start_date, $this->end_date])
                    ->orderBy('new_bill_entry.billdate', 'desc')->get(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'sitename' => getSiteDetailsById($this->sitename)->name,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],
            ]);
        } else  if ($this->report_code == 10) {
            $bills = DB::connection($this->user_db_conn_name)
                ->table('new_bill_entry')
                ->leftjoin('users', 'users.id', '=', 'new_bill_entry.user_id')
                ->leftjoin('sites', 'sites.id', '=', 'new_bill_entry.site_id')
                ->leftjoin('bills_party', 'bills_party.id', '=', 'new_bill_entry.party_id')
                ->select('new_bill_entry.*', 'users.name as user_name', 'sites.name as site_name', 'bills_party.name as party_name')
                ->where('new_bill_entry.site_id', $this->sitename)
                ->whereBetween('new_bill_entry.billdate', [$this->start_date, $this->end_date])
                ->orderBy('new_bill_entry.billdate', 'desc')->get();
            $count = 0;
            foreach ($bills as $bill) {
                $items = DB::connection($this->user_db_conn_name)
                    ->table('new_bills_item_entry')
                    ->leftjoin('bills_work', 'bills_work.id', '=', 'new_bills_item_entry.work_id')
                    ->select('new_bills_item_entry.*', 'bills_work.name as work_name')
                    ->where('new_bills_item_entry.bill_id', '=', $bill->id)
                    ->get();
                $bills[$count++]->items = $items;
            }
            return view('layouts.bills.exports.accToSiteDetailed', [
                'bills'=>$bills,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'sitename' => getSiteDetailsById($this->sitename)->name,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],
            ]);
        }else  if ($this->report_code == 12) {
            $bills = DB::connection($this->user_db_conn_name)
                ->table('new_bill_entry')
                ->leftjoin('users', 'users.id', '=', 'new_bill_entry.user_id')
                ->leftjoin('sites', 'sites.id', '=', 'new_bill_entry.site_id')
                ->leftjoin('bills_party', 'bills_party.id', '=', 'new_bill_entry.party_id')
                ->select('new_bill_entry.*', 'users.name as user_name', 'sites.name as site_name', 'bills_party.name as party_name')
                ->where('new_bill_entry.site_id', $this->sitename)
                ->whereBetween('new_bill_entry.billdate', [$this->start_date, $this->end_date])
                ->orderBy('new_bill_entry.billdate', 'desc')->get();
            $count = 0;
            foreach ($bills as $bill) {
                $items = DB::connection($this->user_db_conn_name)
                    ->table('new_bills_item_entry')
                    ->leftjoin('bills_work', 'bills_work.id', '=', 'new_bills_item_entry.work_id')
                    ->select('new_bills_item_entry.*', 'bills_work.name as work_name')
                    ->where('new_bills_item_entry.bill_id', '=', $bill->id)
                    ->get();
                $bills[$count++]->items = $items;
            }
            return view('layouts.bills.exports.accToSiteDetailedWithWork', [
                'bills'=>$bills,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'sitename' => getSiteDetailsById($this->sitename)->name,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],
            ]);
        }
        else  if ($this->report_code == 11) {

            $statement = DB::connection($this->user_db_conn_name)
                ->table('bill_party_statement')
                ->where('bill_party_statement.party_id', $this->partyname)                  
                ->orderBy('bill_party_statement.id', 'asc')->get();
            $data = array();
            $total_credit = 0;
            $total_debit = 0;
            foreach ($statement as $statem) {
                if ($statem->type == 'Credit') {
                    if (!is_null($statem->expense_id)) {
                        $expense = DB::connection($this->user_db_conn_name)->table('expenses')->where('id', $statem->expense_id)->get()[0];
                        $amount = $expense->amount;
                        $site = getSiteDetailsById($expense->site_id)->name;
                        $user = getUserDetailsById($expense->user_id)->name;
                        $total_credit += $amount;
                        $dat = ['date' => $expense->date, 'ref' => 'Expense', 'ref_no' => '', 'user_name' => $user, 'site_name' => $site, 'credit' => $amount, 'debit' => '', 'particular' => $statem->particular, 'image' => $expense->image];
                        array_push($data,$dat);
                    } else if (!is_null($statem->payment_id)) {
                        $payment = DB::connection($this->user_db_conn_name)->table('bill_party_payments')->where('id', $statem->payment_id)->get()[0];
                        $amount = $payment->amount;
                        $total_credit += $amount;
                        $dat = ['date' => $payment->date, 'ref' => 'Payment', 'ref_no' => '', 'user_name' => '', 'site_name' => '', 'credit' => $amount, 'debit' => '', 'particular' => $statem->particular, 'image' => ''];
                        array_push($data,$dat);
                    } else if (!is_null($statem->payment_voucher_id)) {
                        $pv = DB::connection($this->user_db_conn_name)->table('payment_vouchers')->where('id', $statem->payment_voucher_id)->get()[0];
                        $amount = $pv->amount;
                        $site = getSiteDetailsById($pv->site_id)->name;
                        $user = getUserDetailsById($pv->created_by)->name;
                        $total_credit += $amount;
                        $dat = ['date' => $pv->date, 'ref' => 'Payment Vouchers', 'ref_no' => $pv->voucher_no, 'user_name' => $user, 'site_name' => $site, 'credit' => $amount, 'debit' => '', 'particular' => $statem->particular, 'image' => $pv->image];
                        array_push($data,$dat);
                    }
                } else {
                    if (!is_null($statem->bill_no)) {
                        $bill = DB::connection($this->user_db_conn_name)->table('new_bill_entry')->where('id', $statem->bill_no)->get()[0];
                        $amount = $bill->amount;
                        $site = getSiteDetailsById($bill->site_id)->name;
                        $user = getUserDetailsById($bill->user_id)->name;
                        $total_debit += $amount;
                        $dat = ['date' => $bill->billdate, 'ref' => 'Site Bill', 'ref_no' => $bill->bill_no, 'user_name' => $user, 'site_name' => $site, 'credit' => '', 'debit' => $amount, 'particular' => $statem->particular,'image'=>''];
                        array_push($data,$dat);
                    } else if (!is_null($statem->payment_id)) {
                        $payment = DB::connection($this->user_db_conn_name)->table('bill_party_payments')->where('id', $statem->payment_id)->get()[0];
                        $amount = $payment->amount;
                        $total_debit += $amount;
                        $dat = ['date' => $payment->date, 'ref' => 'Payment', 'ref_no' => '', 'user_name' => '', 'site_name' => '', 'credit' => '', 'debit' => $amount, 'particular' => $statem->particular, 'image' => ''];
                        array_push($data,$dat);
                    }
                }
            }
            usort($data, function($a, $b) {
                $dateA = strtotime($a['date']);
                $dateB = strtotime($b['date']);
                return $dateA - $dateB;
            });

            $partybalance = getBillPartyBalance($this->partyname);
            $party_name = DB::connection($this->user_db_conn_name)->table('bills_party')->where('id', $this->partyname)->get()[0]->name;


            return view('layouts.bills.exports.partyStatement', [
                'data'=>$data,                
                'party_name' => $party_name,                  
                'partybalance' => $partybalance,
                'total_debit' => $total_debit,
                'total_credit' => $total_credit,
                'color' => session()->get('primary_color')[0],
                'sec_color' => session()->get('secondry_color')[0],
            ]);
        }
    }
}

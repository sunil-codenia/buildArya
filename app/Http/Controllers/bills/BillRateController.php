<?php

namespace App\Http\Controllers\bills;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Response;
use File;
use PDF;

class BillRateController extends Controller
{
    //
    public function index(Request $request)
    {
        $data = array();
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');

        $data = DB::connection($user_db_conn_name)->table('bills_rate')->get();


        return  view('layouts.bills.billrate')->with('data', json_encode($data));
    }
    public function addbillrate(Request $request)
    {
        $work_id = $request->input('work_id');

        $rate = $request->input('rate');
        $site_id = $request->input('site_id');
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $data = ['work_id' => $work_id, 'rate' => $rate, 'site_id' => $site_id];

        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        if (!$this->billrateexist($work_id, $site_id, $user_db_conn_name)) {
            try {
               $id = DB::connection($user_db_conn_name)->table('bills_rate')->insertGetId($data);
                addActivity($id,'bills_rate',"Bill Work Rate Set For Site - ".getSiteDetailsById($site_id)->name ,4);
                return redirect('/billrate')
                    ->with('success', 'Bill Rate Created successfully!');
            } catch (\Exception $e) {
                return redirect('/billrate')
                    ->with('error', 'Error While Creating Bill rate!');
            }
        } else {
            return redirect('/billrate')
                ->with('error', 'Bill Rate Already Exists At This Site!');
        }
    }
    public function billrateexist($work_id, $site_id, $conn)
    {
   $check =   DB::connection($conn)->table('bills_rate')->where('work_id' , $work_id)->where( 'site_id', $site_id)->count();
        if ($check >= 1) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
    public function updatebillrate(Request $request)
    {
        $id = $request->input('id');
        $work_id = $request->input('work_id');
        $rate = $request->input('rate');
        $site_id = $request->input('site_id');
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        DB::connection($user_db_conn_name)->table('bills_rate')->where('id', $id)->update(['work_id' => $work_id, 'rate' => $rate]);
        // return redirect('/billrate')
        //     ->with('success', 'Bill Rate Updated Successfully!');
            if (!$this->billrateexist($work_id, $site_id, $user_db_conn_name)) {
                try {
                    DB::connection($user_db_conn_name)->table('bills_rate')->where('id', $id)->update(['work_id' => $work_id, 'rate' => $rate, 'site_id'=> $site_id]);
                    addActivity($id,'bills_rate',"Bill Work Rate Updated For Site - ".getSiteDetailsById($site_id)->name ,4);
                    return redirect('/billrate')
                        ->with('success', 'Bill Rate Updated successfully!');
                } catch (\Exception $e) {
                    return redirect('/billrate')
                        ->with('error', 'Error While Updating Bill rate!');
                }
            } else {
                return redirect('/billrate')
                    ->with('error', 'Bill Rate Already Exists At This Site!');
            }
    }
    public function edit_billrate(Request $request)
    {
        $id = $request->get('id');
        $data = array();
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $data['data'] = DB::connection($user_db_conn_name)->table('bills_rate')->get();
        $data['edit_data'] = DB::connection($user_db_conn_name)->table('bills_rate')->where('id', '=', $id)->get();
        return  view('layouts.bills.billrate')->with('data', json_encode($data));
    }
    public function delete_billrate(Request $request)
    {
        $id = $request->get('id');
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $billrate_delete = DB::connection($user_db_conn_name)->table('bills_rate')->where('id', '=', $id)->get()[0]->rate;
        DB::connection($user_db_conn_name)->table('bills_rate')->where('id', '=', $id)->delete();
        addActivity(0,'bills_rate',"Bill Work Rate Deleted Of Amount - ".$billrate_delete ,4);
        return redirect('/billrate')
            ->with('success', 'Bill Rate Deleted Successfully!');
    }
}

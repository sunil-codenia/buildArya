<?php

namespace App\Http\Controllers\bills;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class BillsWorkController extends Controller
{
    //
    public function index(Request $request){
        $data =array();
            $user_db_conn_name = $request->session()->get('comp_db_conn_name');
 
            $data = DB::connection($user_db_conn_name)->table('bills_work')->get();

            return  view('layouts.bills.billwork')->with('data',json_encode($data));
       
    }
    public function addbillwork(Request $request){
        $name = $request->input('name');
        $unit = $request->input('unit');
      
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $data=['name'=>$name,'unit'=>$unit,];

        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        try {
            $id = DB::connection($user_db_conn_name)->table('bills_work')->insertGetId($data);
            addActivity($id,'bills_work',"New Bill work Created" ,4);

            return redirect('/billwork')
                ->with('success', 'Bill work Created successfully!');
        } catch (\Exception $e){
         if($e->getCode() == 23000){
  return redirect('/billwork')
                ->with('error', 'Bill work Already Exists!');
        }else{
              return redirect('/billwork')
                ->with('error', 'Error While Creating Bill work!');
        }
        }
         
    }
    public function updatebillwork(Request $request){
        $id = $request->input('id');
        $name = $request->input('name');
        $unit = $request->input('unit');
        
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        DB::connection($user_db_conn_name)->table('bills_work')->where('id', $id)->update(['name' => $name,'unit'=>$unit]);
        addActivity($id,'bills_work',"Bill work Updated" ,4);
         return redirect('/billwork');
    }
    public function edit_billwork(Request $request){
        $id = $request->get('id');
        $data =array();
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');

        $data['data'] = DB::connection($user_db_conn_name)->table('bills_work')->get();
        $data['edit_data'] = DB::connection($user_db_conn_name)->table('bills_work')->where('id','=',$id)->get();
        return  view('layouts.bills.billwork')->with('data',json_encode($data));

    }
    public function getsitebillworks(Request $request){
        $id = $request->get('bill_site_id');
        $data =array();
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $data['works'] = DB::connection($user_db_conn_name)->table('bills_rate')->leftJoin('bills_work','bills_work.id','=','bills_rate.work_id')->select('bills_work.id', 'bills_work.name', 'bills_work.unit','bills_rate.rate')->where('bills_rate.site_id',$id)->get();
       echo json_encode($data);

    }
    public function getsitebillworkrates(Request $request){
        $id = $request->get('bill_work_id');
        $site_id =$request->get('bill_site_id');
        $data =array();
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $data['workdata'] = DB::connection($user_db_conn_name)->table('bills_rate')->leftJoin('bills_work','bills_work.id','=','bills_rate.work_id')->select('bills_work.id', 'bills_work.name', 'bills_work.unit','bills_rate.rate')->where('bills_rate.site_id',$site_id)->where('bills_rate.work_id',$id)->get();
       echo json_encode($data);
    }
    public function delete_billwork(Request $request){
        $id = $request->get('id');
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $billswork_delete = DB::connection($user_db_conn_name)->table('bills_work')->where('id', '=', $id)->get()[0]->name;
       $check = DB::connection($user_db_conn_name)->table('new_bills_item_entry')->where('work_id','=',$id)->get();
       if(Count($check) > 0){
    return redirect('/billwork')
    ->with('error', 'Bill Work Is In Use!');
   }else{
    DB::connection($user_db_conn_name)->table('bills_work')->where('id','=',$id)->delete();
    addActivity(0,'bills_work',"Bill Work Deleted - ".$billswork_delete  ,4);
    DB::connection($user_db_conn_name)->table('bills_rate')->where('work_id','=',$id)->delete();


        return redirect('/billwork')
        ->with('success', 'Bill Work Deleted Successfully!');
}
    
    }





    




   

}

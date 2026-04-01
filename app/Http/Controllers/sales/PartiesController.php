<?php

namespace App\Http\Controllers\sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartiesController extends Controller
{
    //
    function sales_parties(Request $request){
        $data =array();
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');

        $data = DB::connection($user_db_conn_name)->table('sales_party')->get();

        return  view('layouts.sales.parties')->with('data',json_encode($data));
    }
    function delete_sales_party(Request $request){
        $id = $request->get('id');
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
       $check = DB::connection($user_db_conn_name)->table('sales_invoice')->where('party_id','=',$id)->get();
       $partyname = DB::connection($user_db_conn_name)->table('sales_party')->where('id','=',$id)->get()[0]->name;
       if(Count($check) > 0){
    return redirect('/sales_parties')
    ->with('error', 'This Party Cannot Be Deleted. Party Has Invoices In Its Name!');
   }else{
    DB::connection($user_db_conn_name)->table('sales_party')->where('id','=',$id)->delete();
    addActivity(0,'sales_party',"Sales Party Deleted - ".$partyname, 7);
        return redirect('/sales_parties')
        ->with('success', 'Party Deleted Successfully!');
}
    }
    function updatesalesparty(Request $request){
        $id = $request->input('id');
        $name = $request->input('name');
        $address = $request->input('address');     
        $phone = $request->input('phone');
        $gst = $request->input('gst');
        $state = $request->input('state');
        $state_code = $request->input('state_code');
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
      
        try {
            DB::connection($user_db_conn_name)->table('sales_party')->where('id', $id)->update(['name' => $name,'address'=>$address,'phone'=>$phone,'gst'=>$gst,'state'=>$state,'state_code'=>$state_code]);
            addActivity($id,'sales_party',"Sales Party Data Updated",7);
            return redirect('/sales_parties')
                ->with('success', 'Party Updated successfully!');
        } catch (\Exception $e){
         if($e->getCode() == 23000){
  return redirect('/sales_parties')
                ->with('error', 'Party Already Exists With Same Credentials!');
        }else{
              return redirect('/sales_parties')
                ->with('error', 'Error While Updating Party!');
        }
        }
    }
    function edit_sales_party(Request $request){
        $id = $request->get('id');
        $data =array();
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $data['data'] = DB::connection($user_db_conn_name)->table('sales_party')->get();
        $data['edit_data'] = DB::connection($user_db_conn_name)->table('sales_party')->where('id','=',$id)->get();
        return  view('layouts.sales.parties')->with('data',json_encode($data));
    }
    function update_sales_party_status(Request $request){
        $id = $request->get('id');
        $status = $request->get('status');
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        DB::connection($user_db_conn_name)->table('sales_party')->where('id', '=', $id)->update(['status' => $status]);
        addActivity($id,'sales_party',"Sales Party Status Updated - ".$status,7);
        if ($status == 'Active') {
            return redirect('/sales_parties')
                ->with('success', 'Party Activated!');
        } else {
            return redirect('/sales_parties')
                ->with('success', 'Party Deactivated!');
        }
    }

    

    function addsalesParty(Request $request){
        $name = $request->input('name');
        $address = $request->input('address');     
        $phone = $request->input('phone');
        $gst = $request->input('gst');
        $state = $request->input('state');
        $state_code = $request->input('state_code');
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $data=['name'=>$name,'address'=>$address,'phone'=>$phone,'gst'=>$gst,'state'=>$state,'state_code'=>$state_code
    ];

        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        try {
         $addsalesParty = DB::connection($user_db_conn_name)->table('sales_party')->insertGetId($data);
            addActivity($addsalesParty,'sales_party',"New Sales Party Created",7);
            return redirect('/sales_parties')
                ->with('success', 'Party Created successfully!');
        } catch (\Exception $e){
         if($e->getCode() == 23000){
  return redirect('/sales_parties')
                ->with('error', 'Party Already Exists!');
        }else{
              return redirect('/sales_parties')
                ->with('error', 'Error While Creating Party!');
        }
        }
}
}

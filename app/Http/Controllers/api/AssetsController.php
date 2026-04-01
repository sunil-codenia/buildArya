<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AssetsController extends Controller
{
    //
    public function get_assets(Request $request){
        $conn = $request->post('conn');
        $site_id = $request->post('site_id');
        $user_db_conn_name = $conn;
        $data = DB::connection($user_db_conn_name)->table('assets')->where('site_id', $site_id)->get();
        return json_encode($data);
    }


    public function soldasset(Request $request){
        $id = $request->get('id');
        $conn = $request->post('conn');
        $user_db_conn_name = $conn;
        $head_id = $request->get('head_id');
        $from_site = $request->get('from_site');
        $sold_value = $request->get('sold_value');
        $remark = $request->get('remark');



            try{

                $id=DB::connection($user_db_conn_name)->table('assets')->where('id', $id)->update(['status' => 'Sold','sale_price'=> $sold_value]);
                addActivity($id, 'assets', "Asset Sold For Amount - ".$sold_value, 5,0,$user_db_conn_name);
                $asset_trans = [
                    'asset_id' => $id,
                    'from_site' => $from_site,
                    'transaction_type' => 'Sold',
                    'remark' => $remark
                ];
                DB::connection($user_db_conn_name)->table('asset_transaction')->insert($asset_trans);
                $this->addsitesBalance($from_site,$sold_value, "Asset Sold - ".$remark,$user_db_conn_name);
               

        } catch (\Exception $e) {
            $result['status'] = 'Failed';
                $result['message'] = 'Error While Selling Asset!';
            
        }
        
        $response = array();
        array_push($response);
        return json_encode($response);

    }


    public function addsitesBalance($id,$amount, $remark,$user_db_conn_name){
      
        $data=['site_id'=>$id,
        'amount'=>$amount,
        'remark'=>$remark    
    ];
     $pay_id =   DB::connection($user_db_conn_name)->table('site_payments')->insertGetId($data);
     addActivity($pay_id, 'site_payments', "Site Payment Created By Selling Asset For Amount - ".$amount, 1,0,$user_db_conn_name);
          
            $tdata = [
                'site_id'=>$id,
                'type'=>'Credit',
                'payment_id'=>$pay_id
            ];
            DB::connection($user_db_conn_name)->table('sites_transaction')->where('payment_id', '=', $pay_id)->delete();

            DB::connection($user_db_conn_name)->table('sites_transaction')->insert($tdata);
        
    }



}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        

<?php

namespace App\Http\Controllers\material;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PDF;
use File;
use Response;

class MaterialSupplierController extends Controller
{
    //
    public function index(Request $request)
    {
        $data = array();
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');

        $data = DB::connection($user_db_conn_name)->table('material_supplier')->get();

        return  view('layouts.material.materialsupplier')->with('data', json_encode($data));
    }
    public function update_material_supplier_status(Request $request)
    {
        $id = $request->get('id');
        $status = $request->get('status');
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        DB::connection($user_db_conn_name)->table('material_supplier')->where('id', '=', $id)->update(['status' => $status]);
        addActivity($id, 'material_supplier', "Material Supplier Status Update - " . $status, 3);
        if ($status == 'Active') {
            return redirect('/materialsupplier')
                ->with('success', 'Material Supplier Activated!');
        } else {
            return redirect('/materialsupplier')
                ->with('success', 'Material Supplier Deactivated!');
        }
    }
    public function addmaterialsupplier(Request $request)
    {
        $name = $request->input('name');
        $address = $request->input('address');
        $gstin = $request->input('gstin');
        $bank_ac = $request->input('bank_ac');
        $bank_ifsc = $request->input('bank_ifsc');
        $bank_name = $request->input('bank_name');
        $bank_ac_holder = $request->input('bank_ac_holder');
        $data = [
            'name' => $name,
            'address' => $address,
            'gstin' => $gstin,
            'bank_ac' => $bank_ac,
            'bank_ifsc' => $bank_ifsc,
            'bank_name' => $bank_name,
            'bank_ac_holder' => $bank_ac_holder
        ];
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        try {
            $id = DB::connection($user_db_conn_name)->table('material_supplier')->insertGetId($data);
            addActivity($id, 'material_supplier', "New Material Supplier Created", 3);
            DB::connection($user_db_conn_name)->table('contact_profile')->insert(['comp_name' => $name, 'contact_name' => $name, 'category' => 'Material Supplier']);
            return redirect('/materialsupplier')
                ->with('success', 'Material Supplier Created successfully!');
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return redirect('/materialsupplier')
                    ->with('error', 'Material Supplier Already Exists!');
            } else {
                return redirect('/material')
                    ->with('error', 'Error While Creating Material Supplier!');
            }
        }
    }
    public function updatematerialsupplier(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $address = $request->input('address');
        $gstin = $request->input('gstin');
        $bank_ac = $request->input('bank_ac');
        $bank_ifsc = $request->input('bank_ifsc');
        $bank_name = $request->input('bank_name');
        $bank_ac_holder = $request->input('bank_ac_holder');
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        DB::connection($user_db_conn_name)->table('material_supplier')->where('id', $id)->update(['name' => $name, 'address' => $address, 'gstin' => $gstin, 'bank_ac' => $bank_ac, 'bank_ifsc' => $bank_ifsc, 'bank_name' => $bank_name, 'bank_ac_holder' => $bank_ac_holder]);
        addActivity($id, 'material_supplier', "Material Supplier Updated", 3);
        return redirect('/materialsupplier');
    }
    public function edit_materialsupplier(Request $request)
    {
        $id = $request->get('id');
        $data = array();
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');

        $data['data'] = DB::connection($user_db_conn_name)->table('material_supplier')->get();
        $data['edit_data'] = DB::connection($user_db_conn_name)->table('material_supplier')->where('id', '=', $id)->get();
        return  view('layouts.material.materialsupplier')->with('data', json_encode($data));
    }
    public function delete_materialsupplier(Request $request)
    {
        $id = $request->get('id');
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $check = DB::connection($user_db_conn_name)->table('material_entry')->where('supplier', '=', $id)->get();
        $material_supplier = DB::connection($user_db_conn_name)->table('material_supplier')->where('id', '=', $id)->get()[0]->name;
        if (Count($check) > 0) {
            return redirect('/materialsupplier')
                ->with('error', 'Material Supplier Is In Use!');
        } else {
            DB::connection($user_db_conn_name)->table('material_supplier')->where('id', '=', $id)->delete();
            addActivity(0, 'material_supplier', "Material Supplier Deleted - " . $material_supplier, 3);
            return redirect('/materialsupplier')
                ->with('success', 'Material Supplier Deleted Successfully!');
        }
    }
}

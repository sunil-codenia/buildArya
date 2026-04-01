<?php

namespace App\Http\Controllers\material;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MaterialEntryController extends Controller
{
    //
    public function verified_material(Request $request)
    {
        $data = array();

        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $role_id = $request->session()->get('role');
        $site_id = $request->session()->get('site_id');
        $role_details = getRoleDetailsById($role_id);
        $view_duration = $role_details->view_duration;
        $visiblity_at_site = $role_details->visiblity_at_site;
        $dates = getdurationdates($view_duration);
        $min_date = $dates['min'];
        $max_date = $dates['max'];
        if ($visiblity_at_site == 'current') {
            $filters = [['material_entry.status', '!=', 'Pending'], ['material_entry.site_id', '=', $site_id]];
        } else {
            $filters = [['material_entry.status', '!=', 'Pending']];
        }
        $data = DB::connection($user_db_conn_name)->table('material_entry')->leftjoin('materials', 'materials.id', '=', 'material_entry.material_id')->leftjoin('material_supplier', 'material_supplier.id', '=', 'material_entry.supplier')->leftjoin('sites', 'sites.id', '=', 'material_entry.site_id')->leftjoin('units', 'units.id', '=', 'material_entry.unit')->leftjoin('users', 'users.id', '=', 'material_entry.user_id')->select('material_entry.*', 'materials.name as material', 'units.name as unit', 'sites.name as site', 'users.name as user', 'material_supplier.name as supplier')->where($filters)->whereBetween('material_entry.date', [$min_date, $max_date])->orderBy('material_entry.id', 'DESC')->get();
        return  view('layouts.material.verified')->with('data', json_encode($data));
    }
    public function pending_material(Request $request)
    {
        $data = array();
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $role_id = $request->session()->get('role');
        $site_id = $request->session()->get('site_id');
        $role_details = getRoleDetailsById($role_id);
        $view_duration = $role_details->view_duration;
        $visiblity_at_site = $role_details->visiblity_at_site;

        $from_date = $request->get('from_date');
        $to_date = $request->get('to_date');
        if ($from_date && $to_date) {
            $min_date = date('Y-m-d', strtotime($from_date));
            $max_date = date('Y-m-d', strtotime($to_date));
        } else {
            $dates = getdurationdates($view_duration);
            $min_date = date('Y-m-d', strtotime($dates['min']));
            $max_date = date('Y-m-d', strtotime($dates['max']));
        }

        $req_site_id = $request->get('site_id');
        if ($visiblity_at_site == 'current') {
            $filters = [['material_entry.status', '=', 'Pending'], ['material_entry.site_id', '=', $site_id]];
        } else {
            if ($req_site_id && $req_site_id != 'all') {
                $filters = [['material_entry.status', '=', 'Pending'], ['material_entry.site_id', '=', $req_site_id]];
            } else {
                $filters = [['material_entry.status', '=', 'Pending']];
            }
        }

        $data = DB::connection($user_db_conn_name)->table('material_entry')->leftjoin('materials', 'materials.id', '=', 'material_entry.material_id')->leftjoin('material_supplier', 'material_supplier.id', '=', 'material_entry.supplier')->leftjoin('sites', 'sites.id', '=', 'material_entry.site_id')->leftjoin('units', 'units.id', '=', 'material_entry.unit')->leftjoin('users', 'users.id', '=', 'material_entry.user_id')->select('material_entry.*', 'materials.name as material', 'units.name as unit', 'sites.name as site', 'users.name as user', 'material_supplier.name as supplier')->where($filters)->whereBetween('material_entry.date', [$min_date, $max_date])->orderBy('material_entry.id', 'DESC')->get();
        return  view('layouts.material.pending')->with('data', json_encode($data));
    }
    public function new_material(Request $request)
    {

        $data = array();
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $data['material_supplier'] = DB::connection($user_db_conn_name)->table('material_supplier')->where('status', '=', 'Active')->get();
        $data['materials'] = DB::connection($user_db_conn_name)->table('materials')->get();
        $data['units'] = DB::connection($user_db_conn_name)->table('units')->get();
        $data['sites'] = DB::connection($user_db_conn_name)->table('sites')->where('status', '=', 'Active')->get();
        return  view('layouts.material.newmaterial')->with('data', json_encode($data));
    }
    public function addnewmaterial(Request $request)
    {
        $result = false;
        $data = $request->input();
        $user_id = session()->get('uid');
        $role_id = session()->get('role');
        $status = getInitialEntryStatusByRole($role_id);
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $length = count($data['site_id']);
        for ($i = 0; $i < $length; $i++) {
            if (isset($request->image[$i])) {
                $imageName = time() . rand(10000, 1000000) . '.' . $request->image[$i]->extension();
                $request->image[$i]->move(public_path('images/app_images/' . $user_db_conn_name . '/material'), $imageName);
                $imagePath = "images/app_images/" . $user_db_conn_name . "/material/" . $imageName;
            } else {
                $imagePath = "images/expense.png";
            }
            $rawd = [
                'supplier' => $data['supplier'][$i],
                'material_id' => $data['material_id'][$i],
                'unit' => $data['unit'][$i],
                'qty' => $data['qty'][$i],
                'vehical' => $data['vehical'][$i],
                'image' => $imagePath,
                'remark' => $data['remark'][$i],
                'site_id' => $data['site_id'][$i],
                'status' => $status,
                'user_id' => $user_id,
                'date' => $data['date'][$i],
            ];
            try {
                $id =  DB::connection($user_db_conn_name)->table('material_entry')->insertGetId($rawd);

                if ($status == 'Approved') {
                    $this->approve_material_entry($id, $user_db_conn_name);
                }
                $result = true;
            } catch (\Exception $e) {
                $result = false;
            }
        }

        if ($result) {
            addActivity($id, 'material_entry', "New Material Entries Created ", 3);
            return redirect('/verified_material')
                ->with('success', 'Material Entries Created successfully!');
        } else {
            return redirect('/verified_material')
                ->with('error', 'Error While Creating Material Entries. Please Try Again After Reconciling The Statement.!');
        }
    }
    public function updatematerialEntry(Request $request)
    {
        $data = $request->input();
        $user_id = session()->get('uid');
        $role_id = session()->get('role');
        $status = getInitialEntryStatusByRole($role_id);
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $id = $data['id'];
        $material_entry = DB::connection($user_db_conn_name)->table('material_entry')->where('id', $id)->get()[0];

        if (isset($request->image)) {
            if (File::exists($material_entry->image) && $material_entry->image != 'images/expense.png') {
                File::delete($material_entry->image);
            }
            $imageName = time() . rand(10000, 1000000) . '.' . $request->image->extension();
            $request->image->move(public_path('images/app_images/' . $user_db_conn_name . '/material'), $imageName);
            $imagePath = "images/app_images/" . $user_db_conn_name . "/material/" . $imageName;
        } else {
            $imagePath = $material_entry->image;
        }
        $rawd = [
            'id' => $id,
            'supplier' => $data['supplier'],
            'material_id' => $data['material_id'],
            'unit' => $data['unit'],
            'qty' => $data['qty'],
            'vehical' => $data['vehical'],
            'image' => $imagePath,
            'remark' => $data['remark'],
            'site_id' => $data['site_id'],
            'status' => $status,
            'user_id' => $user_id,
            'date' => $data['date'],
        ];
        try {
            DB::connection($user_db_conn_name)->table('material_entry')->upsert($rawd, 'id');
            addActivity($id, 'material_entry', "Material Entry Data Updated ", 3);
            if ($status == 'Approved') {
                $this->approve_material_entry($id, $user_db_conn_name);
            }
            return redirect('/verified_material')
                ->with('success', 'Material Entries Updated successfully!');
        } catch (\Exception $e) {
            return redirect('/verified_material')
                ->with('error', 'Error While Updating Material Entries. Please Try Again After Reconciling The Statement.!');
        }
    }
    public function reject_material_by_id(Request $request)
    {
        $id = $request->get('id');
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $this->reject_material_entry($id, $user_db_conn_name);
        return redirect('/verified_material')
            ->with('success', 'Material Entries Rejected Successfully!');
    }
    public function edit_material_entry(Request $request)
    {
        $data = array();
        $id = $request->get('id');
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $data['material_supplier'] = DB::connection($user_db_conn_name)->table('material_supplier')->where('status', '=', 'Active')->get();
        $data['materials'] = DB::connection($user_db_conn_name)->table('materials')->get();
        $data['units'] = DB::connection($user_db_conn_name)->table('units')->get();
        $data['sites'] = DB::connection($user_db_conn_name)->table('sites')->where('status', '=', 'Active')->get();
        $data['materialentry'] = DB::connection($user_db_conn_name)->table('material_entry')->where('id', $id)->get()[0];

        $site_id = session()->get("site_id");
        $role_details = getRoleDetailsById(session()->get('role'));
        $entry_at_site = $role_details->entry_at_site;
        $add_duration = $role_details->add_duration;
        $duration = getdurationdates($add_duration);
        $min_date = $duration['min'];
        if ($entry_at_site == "current" && $site_id != $data['materialentry']->site_id) {
            return redirect('/pending_material')->with('error', "You don't have permission to edit entries at site - " . getSiteDetailsById($data['materialentry']->site_id)->name . "!");
        }
        if ($data['materialentry']->date < $min_date) {
            return redirect('/pending_material')
                ->with('error', "You don't have permission to edit entries before " . $min_date . " !");
        }
        return  view('layouts.material.editmaterialentry')->with('data', json_encode($data));
    }
    public function approve_material_by_id(Request $request)
    {
        $id = $request->get('id');
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $this->approve_material_entry($id, $user_db_conn_name);

        return redirect('/verified_material')
            ->with('success', 'Material Entries Approved Successfully!');
    }

    public function approve_material_entry($id, $user_db_conn_name)
    {
        $material_entry = DB::connection($user_db_conn_name)->table('material_entry')->join('materials', 'materials.id', '=', 'material_entry.material_id')->join('units', 'units.id', '=', 'material_entry.unit')->select('material_entry.*', 'materials.name as material', 'units.name as unitname')->where('material_entry.id', $id)->get()[0];
        DB::connection($user_db_conn_name)->table('material_entry')->where('id', '=', $id)->update(['status' => 'Approved']);
        $stock_data = ['site_id' => $material_entry->site_id, 'material_id' => $material_entry->material_id, 'qty' => $material_entry->qty, 'unit' => $material_entry->unit, 'type' => 'IN', 'refrence' => 'Purchase', 'refrence_id' => $material_entry->id];
        DB::connection($user_db_conn_name)->table('material_stock_transactions')->insert($stock_data);
        $check_current_stock = DB::connection($user_db_conn_name)->table('material_stock_record')->where('site_id', '=', $material_entry->site_id)->where('material_id', '=', $material_entry->material_id)->where('unit', '=', $material_entry->unit)->get();
        if (count($check_current_stock) > 0) {
            $current_qty = $check_current_stock[0]->qty;
            $new_qty = $current_qty + $material_entry->qty;
            DB::connection($user_db_conn_name)->table('material_stock_record')->where('id', '=', $check_current_stock[0]->id)->update(['qty' => $new_qty]);
        } else {
            $new_stock_data = ['material_id' => $material_entry->material_id, 'site_id' => $material_entry->site_id, 'qty' => $material_entry->qty, 'unit' => $material_entry->unit];
            DB::connection($user_db_conn_name)->table('material_stock_record')->insert($new_stock_data);
        }

        sendAlertNotification($material_entry->user_id, 'Your entry of ' . $material_entry->material . ' of ' . $material_entry->qty . ' ' . $material_entry->unitname . ' has been approved. Check Application For More Information.', 'Material Approved');
        addActivity($id, 'material_entry', "Material Entry Approved ", 3);
    }

    public function reject_material_entry($id, $user_db_conn_name)
    {
        $material_entry = DB::connection($user_db_conn_name)->table('material_entry')->join('materials', 'materials.id', '=', 'material_entry.material_id')->join('units', 'units.id', '=', 'material_entry.unit')->select('material_entry.*', 'materials.name as material', 'units.name as unitname')->where('material_entry.id', $id)->get()[0];

        DB::connection($user_db_conn_name)->table('material_entry')->where('id', '=', $id)->update(['status' => 'Rejected']);
$check_entry_approved = DB::connection($user_db_conn_name)->table('material_stock_transactions')->where('refrence_id', '=', $material_entry->id)->where('refrence', '=', 'Purchase')->get();
if(count($check_entry_approved) == 1){
    DB::connection($user_db_conn_name)->table('material_stock_transactions')->where('refrence_id', '=', $material_entry->id)->where('refrence', '=', 'Purchase')->delete();
    $check_current_stock = DB::connection($user_db_conn_name)->table('material_stock_record')->where('site_id', '=', $material_entry->site_id)->where('material_id', '=', $material_entry->material_id)->where('unit', '=', $material_entry->unit)->get();
    if (count($check_current_stock) > 0) {
        $current_qty = $check_current_stock[0]->qty;
        $new_qty = $current_qty - $material_entry->qty;
        DB::connection($user_db_conn_name)->table('material_stock_record')->where('id', '=', $check_current_stock[0]->id)->update(['qty' => $new_qty]);
    } 
}
       
        sendAlertNotification($material_entry->user_id, 'Your entry of ' . $material_entry->material . ' of ' . $material_entry->qty . ' ' . $material_entry->unitname . ' has been approved. Check Application For More Information.', 'Material Approved');
        addActivity($id, 'material_entry', "Material Entry Rejected ", 3);
    }

    public function update_material(Request $request)
    {
        $ids = $request->input('check_list');
        $user_db_conn_name = session()->get('comp_db_conn_name');
        if ($ids != null) {
            if ($request->input('approve_material') !== null) {
                foreach ($ids as $id) {
                    $this->approve_material_entry($id, $user_db_conn_name);
                }
                return redirect('/pending_material')
                    ->with('success', 'Material Approved successfully!');
            } else if ($request->input('reject_material') !== null) {
                foreach ($ids as $id) {
                    $this->reject_material_entry($id, $user_db_conn_name);
                }
                return redirect('/pending_material')
                    ->with('success', 'Material Rejected successfully!');
            }
        } else {
            return redirect('/pending_material')
                ->with('error', 'Please Choose Atleast One Material Entry!');
        }
    }

    public function add_material_bill_info(Request $request)
    {
        $result = array();
        $ids = $request->input('check_list');
        $user_db_conn_name = session()->get('comp_db_conn_name');
        if ($ids != null) {
            foreach ($ids as $id) {
                $rawd = DB::connection($user_db_conn_name)->table('material_entry')->leftjoin('materials', 'materials.id', '=', 'material_entry.material_id')->leftjoin('material_supplier', 'material_supplier.id', '=', 'material_entry.supplier')->leftjoin('sites', 'sites.id', '=', 'material_entry.site_id')->leftjoin('units', 'units.id', '=', 'material_entry.unit')->leftjoin('users', 'users.id', '=', 'material_entry.user_id')->select('material_entry.*', 'materials.name as material', 'units.name as unit', 'sites.name as site', 'users.name as user', 'material_supplier.name as supplier')->where('material_entry.id', '=', $id)->get();
                array_push($result, $rawd);
            }
            $data['material_entries'] = $result;

            return view('layouts.material.materialbillinfo')->with('data', json_encode($data));
        } else {
            return redirect('/verified_material')
                ->with('error', 'Please Choose Atleast One Material Entry!');
        }
    }
    public function update_material_bill_info(Request $request)
    {

        $data = $request->input();
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $length = count($data['ids']);
        $bill_info = $data['bill_no'];
        for ($i = 0; $i < $length; $i++) {
            $id = $data['ids'][$i];
            $rate = $data['rates'][$i];
            $tax = $data['tax'][$i];
            $material_entry = DB::connection($user_db_conn_name)->table('material_entry')->where('id', $id)->get()[0];
            $taxamunt = ($tax * $rate) / 100;
            $finalamount = $taxamunt + $rate;
            $amount = $material_entry->qty * $finalamount;
            DB::connection($user_db_conn_name)->table('material_entry')->where('id', '=', $id)->update(['amount' => $amount, 'rate' => $rate, 'tax' => $tax, 'bill_no' => $bill_info]);
            $debit_data = ['supplier_id' => $material_entry->supplier, 'type' => 'Debit', 'entry_id' => $id];
            DB::connection($user_db_conn_name)->table('material_supplier_statement')->where('entry_id', $id)->delete();
            DB::connection($user_db_conn_name)->table('material_supplier_statement')->insert($debit_data);
            addActivity($id, 'material_entry', "Material Bill information Updated ", 3);
        }

        return redirect('/verified_material')
            ->with('success', 'Material Bills Updated successfully!');
    }
}

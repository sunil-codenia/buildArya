<?php

namespace App\Http\Controllers\material;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MaterialUnitController extends Controller
{
    //
    public function index(Request $request)
    {
        $data = array();
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');

        $data = DB::connection($user_db_conn_name)->table('units')->get();

        return  view('layouts.material.unit')->with('data', json_encode($data));
    }
    public function addmaterialunit(Request $request)
    {
        $name = $request->input('name');
        $data = ['name' => $name];
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        try {
            $id = DB::connection($user_db_conn_name)->table('units')->insertGetId($data);
            addActivity($id, 'units', "New Material Unit Created ", 3);

            return redirect('/materialunit')
                ->with('success', 'Material Unit Created successfully!');
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return redirect('/materialunit')
                    ->with('error', 'Material Unit Already Exists!');
            } else {
                return redirect('/materialunit')
                    ->with('error', 'Error While Creating Material Unit!');
            }
        }
    }
    public function updatematerialunit(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');

        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        DB::connection($user_db_conn_name)->table('units')->where('id', $id)->update(['name' => $name]);
        addActivity($id, 'units', "Material Unit Updated ", 3);

        return redirect('/materialunit');
    }
    public function edit_material_unit(Request $request)
    {
        $id = $request->get('id');
        $data = array();
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');

        $data['data'] = DB::connection($user_db_conn_name)->table('units')->get();
        $data['edit_data'] = DB::connection($user_db_conn_name)->table('units')->where('id', '=', $id)->get();
        return  view('layouts.material.unit')->with('data', json_encode($data));
    }
    public function delete_material_unit(Request $request)
    {
        $id = $request->get('id');
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $check = DB::connection($user_db_conn_name)->table('material_entry')->where('unit', '=', $id)->get();
        $delete_material_unit = DB::connection($user_db_conn_name)->table('unit')->where('id', '=', $id)->get()[0]->name;
        if (Count($check) > 0) {
            return redirect('/materialunit')
                ->with('error', 'Material Unit Is In Use!');
        } else {
            DB::connection($user_db_conn_name)->table('units')->where('id', '=', $id)->delete();
            addActivity(0, 'units', "Material Unit Deleted - " . $delete_material_unit, 3);
            return redirect('/materialunit')
                ->with('success', 'Material Unit Deleted Successfully!');
        }
    }

    public function manage_unit_conversion(Request $request)
    {
        $id = $request->get('id');
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $unit_conversions = DB::connection($user_db_conn_name)
            ->table('material_conversion_rules')->join('units as f_unit', 'f_unit.id', '=', 'material_conversion_rules.from_unit')->join('units as t_unit', 't_unit.id', '=', 'material_conversion_rules.to_unit')->where('material_id', '=', $id)
            ->select('material_conversion_rules.id as id', 'material_conversion_rules.conversion_factor', 'f_unit.name as from_unit', 't_unit.name as to_unit')->get();
        $material =  DB::connection($user_db_conn_name)->table('materials')->where('id', '=', $id)->first();
        $units = DB::connection($user_db_conn_name)->table('units')->get();
        return  view('layouts.material.unit_conversion_rules', compact(['unit_conversions', 'material', 'units']));
    }
    public function add_unit_conversion(Request $request)
    {
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $uid = $request->session()->get('uid');
        $material_id = $request->get('material_id');
        $from_unit = $request->get('from_unit');
        $to_unit = $request->get('to_unit');
        $conversion_factor = $request->get('conversion_factor');
        if ($from_unit != $to_unit) {
            $check = DB::connection($user_db_conn_name)->table('material_conversion_rules')->where('material_id', '=', $material_id)->where('from_unit', '=', $from_unit)->where('to_unit', '=', $to_unit)->count();
            if ($check == 0) {
                if ($conversion_factor > 0) {
                    $data = ['material_id' => $material_id, 'from_unit' => $from_unit, 'to_unit' => $to_unit, 'conversion_factor' => $conversion_factor, 'created_by' => $uid];
                    DB::connection($user_db_conn_name)->table('material_conversion_rules')->insert($data);
                    return redirect('/manage_unit_conversion?id=' . $material_id)
                        ->with('success', "Conversion Rule Created Successfully!");
                } else {
                    return redirect('/manage_unit_conversion?id=' . $material_id)
                        ->with('error', "Conversion Factor Can't Be Less Than Or Equal To 0!");
                }
            } else {
                return redirect('/manage_unit_conversion?id=' . $material_id)
                    ->with('error', "Unit Conversion With Same Units Already Available!");
            }
        } else {
            return redirect('/manage_unit_conversion?id=' . $material_id)
                ->with('error', "Both Unit Can't Be Same!");
        }
    }
    public function delete_unit_conversion(Request $request)
    {
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $id = $request->get('id');
        $material_id = DB::connection($user_db_conn_name)->table('material_conversion_rules')->where('id', '=', $id)->first()->material_id;
        DB::connection($user_db_conn_name)->table('material_conversion_rules')->where('id', '=', $id)->delete();

        return redirect('/manage_unit_conversion?id=' . $material_id)
            ->with('success', "Conversion Rule Deleted Successfully!");
    }
}

<?php

namespace App\Http\Controllers\expense;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Response;
use File;
use PDF;

class ExpenseHeadController extends Controller
{
    //
    public function index(Request $request)
    {
        $data = array();
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');

        $data = DB::connection($user_db_conn_name)->table('expense_head')->get();

        return  view('layouts.expense.head')->with('data', json_encode($data));
    }
    public function addexpensehead(Request $request)
    {
        $name = $request->input('name');
        $data = ['name' => $name];
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        try {
            $id = DB::connection($user_db_conn_name)->table('expense_head')->insertGetId($data);
            addActivity($id, 'expense_head', "New Expense Head Created", 2);
            return redirect('/expense_head')
                ->with('success', 'Expense Head Created successfully!');
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return redirect('/expense_head')
                    ->with('error', 'Expense Head Already Exists!');
            } else {
                return redirect('/expense_head')
                    ->with('error', 'Error While Creating Expense Head!');
            }
        }
    }
    public function updateexpensehead(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        try {
            DB::connection($user_db_conn_name)->table('expense_head')->where('id', $id)->update(['name' => $name]);
            addActivity($id, 'expense_head', "Expense Head Updated", 2);
            return redirect('/expense_head')
                ->with('success', 'Expense Head Updated Successfully!');;
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return redirect('/expense_head')
                    ->with('error', 'Expense Head Already Exists!');
            } else {
                return redirect('/expense_head')
                    ->with('error', 'Error While Updating Expense Head!');
            }
        }
    }
    public function edit_expense_head(Request $request)
    {
        $id = $request->get('id');
        $data = array();
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');

        $data['data'] = DB::connection($user_db_conn_name)->table('expense_head')->get();
        $data['edit_data'] = DB::connection($user_db_conn_name)->table('expense_head')->where('id', '=', $id)->get();
        return  view('layouts.expense.head')->with('data', json_encode($data));
    }
    public function delete_expense_head(Request $request)
    {
        $id = $request->get('id');
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $check = DB::connection($user_db_conn_name)->table('expenses')->where('head_id', '=', $id)->get();

        $expense_head = DB::connection($user_db_conn_name)->table('expense_head')->where('id', '=', $id)->get()[0]->name;

        if (Count($check) > 0) {
            return redirect('/expense_head')
                ->with('error', 'Expense Head Is In Use!');
        } else {
            DB::connection($user_db_conn_name)->table('expense_head')->where('id', '=', $id)->delete();
            addActivity(0, 'expense_head', "Expense Head Deleted - " . $expense_head, 2);
            return redirect('/expense_head')
                ->with('success', 'Expense Head Deleted Successfully!');
        }
    }
}

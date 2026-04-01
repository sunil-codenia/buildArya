<?php

namespace App\Http\Controllers\material;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use File;
use Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MaterialExport;

class MaterialController extends Controller
{
    //
    public function index(Request $request)
    {
        $data = array();
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');

        $data = DB::connection($user_db_conn_name)->table('materials')->get();

        return  view('layouts.material.material')->with('data', json_encode($data));
    }
    public function addmaterial(Request $request)
    {
        $name = $request->input('name');
        $data = ['name' => $name];
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        try {
            $id = DB::connection($user_db_conn_name)->table('materials')->insertGetId($data);
            addActivity($id, 'materials', "New Material SKU Created", 3);
            return redirect('/material')
                ->with('success', 'Material Created successfully!');
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return redirect('/material')
                    ->with('error', 'Material Already Exists!');
            } else {
                return redirect('/material')
                    ->with('error', 'Error While Creating Material!');
            }
        }
    }
    public function updatematerial(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        DB::connection($user_db_conn_name)->table('materials')->where('id', $id)->update(['name' => $name]);
        addActivity($id, 'materials', "Material SKU Updated", 3);
        return redirect('/material')->with('success', 'Material Updated successfully!');;
    }
    public function edit_material(Request $request)
    {
        $id = $request->get('id');
        $data = array();
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');

        $data['data'] = DB::connection($user_db_conn_name)->table('materials')->get();
        $data['edit_data'] = DB::connection($user_db_conn_name)->table('materials')->where('id', '=', $id)->get();
        return  view('layouts.material.material')->with('data', json_encode($data));
    }
    public function delete_material(Request $request)
    {
        $id = $request->get('id');
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $check = DB::connection($user_db_conn_name)->table('material_entry')->where('material_id', '=', $id)->get();
        $material_name = DB::connection($user_db_conn_name)->table('materials')->where('id', '=', $id)->get()[0]->name;
        if (Count($check) > 0) {
            return redirect('/material')
                ->with('error', 'Material Is In Use!');
        } else {
            DB::connection($user_db_conn_name)->table('materials')->where('id', '=', $id)->delete();
            addActivity(0, 'materials', "Material SKU Deleted- " . $material_name, 3);

            return redirect('/material')
                ->with('success', 'Material Deleted Successfully!');
        }
    }




    public function materials_report(Request $request)
    {
        return view('layouts.material.material_report');
    }

    public function materialreports(Request $request)
    {
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $type = $request->get('Report_Type');
        $report_code = $request->get('type');
        $start_date = $request->get('start_date');
        $sitename = $request->get('site_id');
        $partyname = $request->get('supplier_id');
        $headname = $request->get('material_id');
        $end_date = $request->get('end_date');
        addActivity(0, 'materials', "Material Report Generated Of Data (" . $start_date . " - " . $end_date . ")", 3);

        if ($report_code == 1) {
            if ($type == 1) {
                return $this->exportExcel($user_db_conn_name, $start_date, $end_date, $report_code);
            } else {
                $file_name = "Material Date Report (" . $start_date . " To " . $end_date . ").pdf";
                $material = DB::connection($user_db_conn_name)
                    ->table('material_entry')->leftjoin('materials', 'materials.id', '=', 'material_entry.material_id')
                    ->leftjoin('material_supplier', 'material_supplier.id', '=', 'material_entry.supplier')
                    ->leftjoin('sites', 'sites.id', '=', 'material_entry.site_id')
                    ->leftjoin('units', 'units.id', '=', 'material_entry.unit')
                    ->leftjoin('users', 'users.id', '=', 'material_entry.user_id')
                    ->select('material_entry.*', 'materials.name as material', 'units.name as unit', 'sites.name as site', 'users.name as user', 'material_supplier.name as supplier')
                    ->whereBetween('material_entry.date', [$start_date, $end_date])
                    ->orderBy('material_entry.date', 'desc')->get();
                $pdf = Pdf::loadView('layouts.material.pdfs.accToDate', compact('material', 'start_date', 'end_date'));
                return $pdf->download($file_name);
            }
        } elseif ($report_code == 2) {
            if ($type == 1) {
                return $this->exportExcel($user_db_conn_name, $start_date, $end_date, $report_code, $sitename, "", "");
            } else {
                $file_name = "Material Site Report (" . $start_date . " To " . $end_date . ").pdf";
                $material = DB::connection($user_db_conn_name)
                    ->table('material_entry')
                    ->leftjoin('materials', 'materials.id', '=', 'material_entry.material_id')
                    ->leftjoin('material_supplier', 'material_supplier.id', '=', 'material_entry.supplier')
                    ->leftjoin('sites', 'sites.id', '=', 'material_entry.site_id')
                    ->leftjoin('units', 'units.id', '=', 'material_entry.unit')
                    ->leftjoin('users', 'users.id', '=', 'material_entry.user_id')
                    ->select('material_entry.*', 'materials.name as material', 'units.name as unit', 'sites.name as site', 'users.name as user', 'material_supplier.name as supplier')
                    ->whereBetween('material_entry.date', [$start_date, $end_date])
                    ->orderBy('material_entry.date', 'desc')->get();
                $sitename = getSiteDetailsById($sitename)->name;
                $pdf = Pdf::loadView('layouts.material.pdfs.accToSite', compact('material', 'start_date', 'end_date', 'sitename'));
                return $pdf->download($file_name);
            }
        } elseif ($report_code == 3) {
            if ($type == 1) {
                return $this->exportExcel($user_db_conn_name, $start_date, $end_date, $report_code, "", $partyname, "");
            } else {

                $file_name = "Material Supplier Report (" . $start_date . " To " . $end_date . ").pdf";
                $material = DB::connection($user_db_conn_name)
                    ->table('material_entry')
                    ->leftjoin('materials', 'materials.id', '=', 'material_entry.material_id')
                    ->leftjoin('material_supplier', 'material_supplier.id', '=', 'material_entry.supplier')
                    ->leftjoin('sites', 'sites.id', '=', 'material_entry.site_id')
                    ->leftjoin('units', 'units.id', '=', 'material_entry.unit')
                    ->leftjoin('users', 'users.id', '=', 'material_entry.user_id')
                    ->select('material_entry.*', 'materials.name as material', 'units.name as unit', 'sites.name as site', 'users.name as user', 'material_supplier.name as supplier')
                    ->whereBetween('material_entry.date', [$start_date, $end_date])
                    ->orderBy('material_entry.date', 'desc')->get();
                $partyname = DB::connection($user_db_conn_name)->table('material_supplier')->where('id', $partyname)->get()[0]->name;

                $pdf = Pdf::loadView('layouts.material.pdfs.accToSupp', compact('material', 'start_date', 'end_date', 'partyname'));
                return $pdf->download($file_name);
            }
        } elseif ($report_code == 4) {
            if ($type == 1) {
                return $this->exportExcel($user_db_conn_name, $start_date, $end_date, $report_code, $sitename, $partyname, "");
            } else {
                $file_name = "Material Supplier Report At Particular Site (" . $start_date . " To " . $end_date . ").pdf";
                $material = DB::connection($user_db_conn_name)
                    ->table('material_entry')
                    ->leftjoin('materials', 'materials.id', '=', 'material_entry.material_id')
                    ->leftjoin('material_supplier', 'material_supplier.id', '=', 'material_entry.supplier')
                    ->leftjoin('sites', 'sites.id', '=', 'material_entry.site_id')
                    ->leftjoin('units', 'units.id', '=', 'material_entry.unit')
                    ->leftjoin('users', 'users.id', '=', 'material_entry.user_id')
                    ->select('material_entry.*', 'materials.name as material', 'units.name as unit', 'sites.name as site', 'users.name as user', 'material_supplier.name as supplier')
                    ->whereBetween('material_entry.date', [$start_date, $end_date])
                    ->orderBy('material_entry.date', 'desc')->get();
                $partyname = DB::connection($user_db_conn_name)->table('material_supplier')->where('id', $partyname)->get()[0]->name;
                $sitename = getSiteDetailsById($sitename)->name;

                $pdf = Pdf::loadView('layouts.material.pdfs.accToSuppAtSite', compact('material', 'start_date', 'end_date', 'partyname', 'sitename'));
                return $pdf->download($file_name);
            }
        } elseif ($report_code == 5) {
            if ($type == 1) {
                return $this->exportExcel($user_db_conn_name, $start_date, $end_date, $report_code, "", "", $headname);
            } else {
                $file_name = "Material Item Report (" . $start_date . " To " . $end_date . ").pdf";
                $material = DB::connection($user_db_conn_name)
                    ->table('material_entry')
                    ->leftjoin('materials', 'materials.id', '=', 'material_entry.material_id')
                    ->leftjoin('material_supplier', 'material_supplier.id', '=', 'material_entry.supplier')
                    ->leftjoin('sites', 'sites.id', '=', 'material_entry.site_id')
                    ->leftjoin('units', 'units.id', '=', 'material_entry.unit')
                    ->leftjoin('users', 'users.id', '=', 'material_entry.user_id')
                    ->select('material_entry.*', 'materials.name as material', 'units.name as unit', 'sites.name as site', 'users.name as user', 'material_supplier.name as supplier')
                    ->whereBetween('material_entry.date', [$start_date, $end_date])
                    ->orderBy('material_entry.date', 'desc')->get();
                $headname = DB::connection($user_db_conn_name)->table('materials')->where('id', $headname)->get()[0]->name;

                $pdf = Pdf::loadView('layouts.material.pdfs.accToMat', compact('material', 'start_date', 'end_date', 'headname'));
                return $pdf->download($file_name);
            }
        } else if ($report_code == 6) {
            if ($type == 1) {
                return $this->exportExcel($user_db_conn_name, $start_date, $end_date, $report_code, $sitename, "", $headname);
            } else {
                $file_name = "Material Item Report At Particular Site (" . $start_date . " To " . $end_date . ").pdf";
                $material = DB::connection($user_db_conn_name)
                    ->table('material_entry')
                    ->leftjoin('materials', 'materials.id', '=', 'material_entry.material_id')
                    ->leftjoin('material_supplier', 'material_supplier.id', '=', 'material_entry.supplier')
                    ->leftjoin('sites', 'sites.id', '=', 'material_entry.site_id')
                    ->leftjoin('units', 'units.id', '=', 'material_entry.unit')
                    ->leftjoin('users', 'users.id', '=', 'material_entry.user_id')
                    ->select('material_entry.*', 'materials.name as material', 'units.name as unit', 'sites.name as site', 'users.name as user', 'material_supplier.name as supplier')
                    ->whereBetween('material_entry.date', [$start_date, $end_date])
                    ->orderBy('material_entry.date', 'desc')->get();
                $headname = DB::connection($user_db_conn_name)->table('materials')->where('id', $headname)->get()[0]->name;
                $sitename = getSiteDetailsById($sitename)->name;

                $pdf = Pdf::loadView('layouts.material.pdfs.accToMatAtSite', compact('material', 'start_date', 'end_date', 'headname', 'sitename'));
                return $pdf->download($file_name);
            }
        } else if ($report_code == 7) {
        
            if ($type == 1) {
                return $this->exportExcel($user_db_conn_name, "", "", $report_code, "",  $partyname,"");
            } else {
                $party_name = DB::connection($user_db_conn_name)->table('material_supplier')->where('id', $partyname)->get()[0]->name;
                
                $file_name = "Material Supplier Statement - " . $party_name . " .pdf";
                $statement = DB::connection($user_db_conn_name)
                    ->table('material_supplier_statement')
                    ->where('material_supplier_statement.supplier_id', $partyname)
                    ->orderBy('material_supplier_statement.id', 'asc')->get();
                    $data = array();
                $total_credit = 0;
                $total_debit = 0;
                foreach ($statement as $statem) {
                    if ($statem->type == 'Credit') {
                      
                            $pv = DB::connection($user_db_conn_name)->table('payment_vouchers')->where('id', $statem->payment_voucher_id)->get()[0];
                            $amount = $pv->amount;
                            $site = getSiteDetailsById($pv->site_id)->name;
                            $user = getUserDetailsById($pv->created_by)->name;
                            $total_credit += $amount;
                            $dat = ['date' => $pv->date, 'ref' => 'Payment Vouchers', 'ref_no' => $pv->voucher_no, 'user_name' => $user, 'site_name' => $site, 'credit' => $amount, 'debit' => '', 'particular' => $pv->remark, 'image' => $pv->image];
                            array_push($data, $dat);
                        
                    } else {
                            $mat = DB::connection($user_db_conn_name)->table('material_entry')->join('materials','materials.id','=','material_entry.material_id')->join('units','units.id','=','material_entry.unit')->select('material_entry.*','units.name as unit_name','materials.name as mat_name')->where('material_entry.id', $statem->entry_id)->get()[0];
                            $amount = $mat->amount;
                            $site = getSiteDetailsById($mat->site_id)->name;
                            $user = getUserDetailsById($mat->user_id)->name;
                            $total_debit += $amount;
                            $dat = ['date' => $mat->date, 'ref' => 'Material Entry', 'ref_no' => $mat->bill_no, 'user_name' => $user, 'site_name' => $site, 'credit' => '', 'debit' => $amount, 'particular' => $mat->mat_name. " - ".$mat->qty." ".$mat->unit_name, 'image' => $mat->image];
                            array_push($data, $dat);
                        
                    }
                }
                usort($data, function ($a, $b) {
                    $dateA = strtotime($a['date']);
                    $dateB = strtotime($b['date']);
                    return $dateA - $dateB;
                });

                $partybalance = getMaterialsSupplierBalance($partyname);

                $pdf = Pdf::loadView('layouts.material.pdfs.supplierStatement', compact('data', 'party_name', 'total_credit', 'total_debit', 'partybalance'));
                return $pdf->download($file_name);
            }
        }
    }
    public function exportExcel($user_db_conn_name, $start_date, $end_date, $report_code, $sitename = null, $partyname = null, $headname = null)
    {


        $file_name = "Material ";

        if ($report_code == 1) {
            $file_name .= "Date Report";
        } else if ($report_code == 2) {
            $file_name .= "Site Report ";
        } else if ($report_code == 3) {

            $file_name .= "Supplier Report ";
        } else if ($report_code == 4) {
            $file_name .= "Supplier Report At Particular Site ";
        } else if ($report_code == 5) {
            $file_name .= "Item Report ";
        } else if ($report_code == 6) {

            $file_name .= "Item Report At Particular Site ";
        }
       
      
            $file_name .= "(" . $start_date . " TO " . $end_date . ").xlsx";
        
        if ($report_code == 7) {

            $party_name = DB::connection($user_db_conn_name)->table('material_supplier')->where('id', $partyname)->get()[0]->name;

            $file_name = "Material Supplier Statement-" . $party_name . ".xlsx";
        }


        return Excel::download(new MaterialExport($user_db_conn_name, $start_date, $end_date, $report_code, $sitename, $partyname, $headname), $file_name);
    }
}

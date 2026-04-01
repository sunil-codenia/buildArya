<?php

namespace App\Http\Controllers\users;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\Console\Input\Input;

class UserController extends Controller
{
 public function users(Request $request)
    {
        $users_list = array();
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');

        $users = DB::connection($user_db_conn_name)->table('users')->leftJoin('sites', 'users.site_id', '=', 'sites.id')->select('users.*', 'sites.name AS site')->get();
        for ($i = 0; $i < sizeof($users); $i++) {
            $other_users  = DB::connection($user_db_conn_name)->table('users')->select('name', 'id', 'image')->where('site_id', $users[$i]->site_id)->where('id', '!=', $users[$i]->id)->get();
            $users_list[$i]['data'] = $users[$i];
            $users_list[$i]['list'] = $other_users;
        }
        $data['data'] = $users_list;
        return  view('layouts.users.users')->with('data', json_encode($data));
    }
    public function user_report(Request $request)
    {
        return  view('layouts.users.reports');
    }

    
    public function addnewuser(Request $request)
    {


        $user_db_conn_name = $request->session()->get('comp_db_conn_name');

        $imageName = "images/noprofile.jpg";
        $imagePath = "images/noprofile.jpg";
        $name = $request->name;
        
        $username = $request->username;
        $password = $request->password;
        $contact_no = $request->contact_no;
        $site_id = $request->site_id;
        $role_id = $request->role_id;
        $pan_no = $request->pan_no;
        $mobile_only = $request->mobile_only;
        $status = $request->status;
       
        $request->validate([
            'contact_no' => 'required|digits:10',
            'username' => 'required|min:5',
            'name' => 'required|min:3',
            'password' => 'required|min:5'
        ], [
            'contact_no.digits' => 'Contact Number Should be 10 digits',
            'contact_no.required' => 'Contact Numeber Is Required',
            'username.min' => 'Username Should Be Minimum Of 5 Characters',
            'name.min' => 'Name Should Be Minimum Of 3 Characters',
            'password.min' => 'Password Should Be Minimum Of 5 Characters',
        ]);

        $valid_username=DB::connection($user_db_conn_name)->table('users')->where('username','=',$username)->count();
        if( $valid_username ==0 ){


        if (isset($request->image)) {
            $request->validate(
                [
                    'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                ],
                [
                    'image.mimes'   => 'Please Select Valid Image Format (Jpeg,Png,Jpg,Gif)',
                    'image.image' => 'Please Select Valid Image (Jpeg,Png,Jpg,Gif)',
                    'image.uploaded' => 'Please Choose Image Less Than 2 Mb',
                ]
            );
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/app_images/'.$user_db_conn_name.'/users'), $imageName);
            $imagePath = "images/app_images/".$user_db_conn_name."/users/" . $imageName;
        }
        
        $image = $imagePath;
        $data = [
            'name' => $name,
            'username' => $username,
            'pass' => $password,
            'site_id' => $site_id,
            'role_id' => $role_id,
            'pan_no' => $pan_no,
            'image' => $image,
            'contact_no' => $contact_no,
            'mobile_only'=>$mobile_only,
        ];
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        try {
            $user_id = DB::connection($user_db_conn_name)->table('users')->insertGetId($data);
            $rolename = getRoleDetailsById($role_id)->name;
            DB::connection($user_db_conn_name)->table('contact')->insert(['profile_id' => "1", 'name' => $name, 'phone'=>$contact_no,'position' => $rolename]);
            $comp_id = $request->session()->get('comp_db_id');
            $user_db_conn_name = $request->session()->get('comp_db_conn_name');
            $modules = DB::table('company_modules')->join('modules', 'modules.id', '=', 'company_modules.module_id')->select('modules.id', 'modules.name')->where('company_modules.company_id', '=', $comp_id)->get();
            
            // Fetch default permissions for the assigned role
            $role_permissions = DB::connection($user_db_conn_name)->table('role_permission')->where('role_id', '=', $role_id)->get()->keyBy('module_id');
            
            $permission = array();
            $perm_result = array();
            foreach ($modules as $module) {
                // If the role has default permissions for this module, use them. Otherwise default to 0.
                $def = isset($role_permissions[$module->id]) ? $role_permissions[$module->id] : null;
                
                $permission[$module->id]['can_view'] = $def ? $def->can_view : 0;
                $permission[$module->id]['can_edit'] = $def ? $def->can_edit : 0;
                $permission[$module->id]['can_certify'] = $def ? $def->can_certify : 0;
                $permission[$module->id]['can_add'] = $def ? $def->can_add : 0;
                $permission[$module->id]['can_delete'] = $def ? $def->can_delete : 0;
                $permission[$module->id]['can_pay'] = $def ? $def->can_pay : 0;
                $permission[$module->id]['can_report'] = $def ? $def->can_report : 0;
                
                $res = array();
                $res['user_id'] = $user_id;
                $res['module_id'] = $module->id;
                $res['can_view'] = $permission[$module->id]['can_view'];
                $res['can_add'] = $permission[$module->id]['can_add'];
                $res['can_delete'] = $permission[$module->id]['can_delete'];
                $res['can_edit'] = $permission[$module->id]['can_edit'];
                $res['can_certify'] = $permission[$module->id]['can_certify'];
                $res['can_pay'] = $permission[$module->id]['can_pay'];
                $res['can_report'] = $permission[$module->id]['can_report'];
                array_push($perm_result, $res);
            }
                try {
                    DB::connection($user_db_conn_name)->table('user_permission')->where('user_id', '=', $user_id)->delete();
                    DB::connection($user_db_conn_name)->table('user_permission')->insert($perm_result);

                    addActivity($user_id,'users',"User Created",1);

                    return redirect('/users')
                        ->with('success', 'User Created successfully!');
                } catch (\Exception $e) {
                    print_r($e);
                    return redirect('/users')
                        ->with('error', 'Error While Assigning Permissions!');
                }
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return redirect('/users')
                    ->with('error', 'User Already Exists!');
            } else {
                return redirect('/users')
                    ->with('error', 'Error While Creating User!');
            }
        }
 }else{
    return redirect('/users')
    ->with('error', 'Username Already Exist!');

    }

    }
    public function update_user_status(Request $request)
    {
        $id = $request->get('id');
        $status = $request->get('status');
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        DB::connection($user_db_conn_name)->table('users')->where('id', '=', $id)->update(['status' => $status]);

        if ($status == 'Active') {
            addActivity($id,'users',"User Activated",1);
            return redirect('/users')
                ->with('success', 'User Activated!');
        } else {
            addActivity($id,'users',"User Deactivated",1);
            return redirect('/users')
                ->with('success', 'User Deactivated!');
        }
    }
    public function edit_users(Request $request)
    {
        $id = $request->get('id');
        $data = array();
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');

        $users_list = array();
        $users = DB::connection($user_db_conn_name)->table('users')->leftJoin('sites', 'users.site_id', '=', 'sites.id')->select('users.*', 'sites.name AS site')->get();
        for ($i = 0; $i < sizeof($users); $i++) {
            $other_users  = DB::connection($user_db_conn_name)->table('users')->select('name', 'id', 'image')->where('site_id', $users[$i]->site_id)->where('id', '!=', $users[$i]->id)->get();
            $users_list[$i]['data'] = $users[$i];
            $users_list[$i]['list'] = $other_users;
        }
        $data['data'] = $users_list;
        $data['edit_data'] = DB::connection($user_db_conn_name)->table('users')->where('id', '=', $id)->get();
        return  view('layouts.users.users')->with('data', json_encode($data));
    }

    public function delete_users(Request $request)
    {
        $id = $request->get('id');
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $users = DB::connection($user_db_conn_name)->table('users')->where('id',$id)->get()[0]->name;
        DB::connection($user_db_conn_name)->table('users')->where('id', '=', $id)->delete();
        addActivity(0,'users',"User Deleted - ".$users,1);
        return redirect('/users')
            ->with('success', 'Users Deleted Successfully!');
    }

    public function updateusers(Request $request)
    {
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');

        $imagePath = "images/noprofile.jpg";
        if (isset($request->image)) {
            $request->validate(
                [
                    'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                ],
                [
                    'image.mimes'   => 'Please Select Valid Image Format (Jpeg,Png,Jpg,Gif)',
                    'image.image' => 'Please Select Valid Image (Jpeg,Png,Jpg,Gif)',
                    'image.uploaded' => 'Please Choose Image Less Than 2 Mb',
                ]
            );
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/app_images/'.$user_db_conn_name.'/users'), $imageName);
            $imagePath = "images/app_images/".$user_db_conn_name."/users/" . $imageName;
        }

        $id = $request->input('id');
        $name = $request->input('name');
        $username = $request->input('username');
        $password = $request->input('pass');
        $contact_no = $request->input('contact_no');
        $site_id = $request->input('site_id');
        $role_id = $request->input('role_id');
        $pan_no = $request->input('pan_no');
        $mobile_only=$request->input('mobile_only');
        $image = $imagePath;
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        DB::connection($user_db_conn_name)->table('users')->where('id', $id)->update([
            'name' => $name,
            'username' => $username,
            'pass' => $password,
            'site_id' => $site_id,
            'role_id' => $role_id,
            'pan_no' => $pan_no,
            'image' => $image,
            'contact_no' => $contact_no,
            'mobile_only'=>$mobile_only
        ]);
        addActivity($id,'users',"User Data Updated",1);
        return redirect('/users')->with('success', 'User Updated successfully!');
    }
    public function edit_site(Request $request)
    {
        $id = $request->get('id');
        $data = array();
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');

        $data['data'] = DB::connection($user_db_conn_name)->table('users')->get();
        $data['edit_data'] = DB::connection($user_db_conn_name)->table('users')->where('id', '=', $id)->get();
        return  view('layouts.users.users')->with('data', json_encode($data));
    }
    public function assign_permission(Request $request)
    {
        $id = $request->get('id');

        $comp_id = $request->session()->get('comp_db_id');
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $raw_modules = DB::table('company_modules')->join('modules', 'modules.id', '=', 'company_modules.module_id')->select('modules.id', 'modules.name')->where('company_modules.company_id', '=', $comp_id)->get();
        
        $sidebar_map = [
            1 => 'Sites & Users',
            2 => 'Expenses',
            3 => 'Material Purchase & Manage Stock',
            4 => 'Site Bills',
            6 => 'Machinery',
            5 => 'Assets',
            7 => 'Sales',
            8 => 'Payment Vouchers',
            11 => 'Document Management',
            10 => 'Contact Management',
            9 => 'Management'
        ];

        $modules = [];
        foreach ($sidebar_map as $sid => $sname) {
            foreach ($raw_modules as $rm) {
                if ($rm->id == $sid) {
                    $modules[] = ['id' => $sid, 'name' => $sname];
                    break;
                }
            }
        }
        $data['modules'] = $modules;
        $data['permissions'] = DB::connection($user_db_conn_name)->table('user_permission')->where('user_id', '=', $id)->get();
        $data['user_id'] = $id;

        return  view('layouts.users.assign_permission')->with('data', json_encode($data));
    }
    public function update_user_permission(Request $request)
    {
        $result = array();
        if (!empty($request->get('view'))) {
            $view = $request->get('view');
        }
        if (!empty($request->get('add'))) {
            $add = $request->get('add');
        }
        if (!empty($request->get('edit'))) {
            $edit = $request->get('edit');
        }
        if (!empty($request->get('certify'))) {
            $certify = $request->get('certify');
        }
        if (!empty($request->get('delete'))) {
            $delete = $request->get('delete');
        }
        if (!empty($request->get('pay'))) {
            $pay = $request->get('pay');
        }
        if (!empty($request->get('report'))) {
            $report = $request->get('report');
        }
        $user_id = $request->input('user_id');
        $comp_id = $request->session()->get('comp_db_id');
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $modules = DB::table('company_modules')->join('modules', 'modules.id', '=', 'company_modules.module_id')->select('modules.id', 'modules.name')->where('company_modules.company_id', '=', $comp_id)->get();
        $permission = array();
        foreach ($modules as $module) {

            if (isset($view)) {
                if (in_array($module->id, $view)) {
                    $permission[$module->id]['can_view'] = 1;
                } else {
                    $permission[$module->id]['can_view'] = 0;
                }
            } else {
                $permission[$module->id]['can_view'] = 0;
            }
            if (isset($edit)) {
                if (in_array($module->id, $edit)) {
                    $permission[$module->id]['can_edit'] = 1;
                } else {
                    $permission[$module->id]['can_edit'] = 0;
                }
            } else {
                $permission[$module->id]['can_edit'] = 0;
            }
            if (isset($certify)) {
                if (in_array($module->id, $certify)) {
                    $permission[$module->id]['can_certify'] = 1;
                } else {
                    $permission[$module->id]['can_certify'] = 0;
                }
            } else {
                $permission[$module->id]['can_certify'] = 0;
            }
            if (isset($add)) {
                if (in_array($module->id, $add)) {
                    $permission[$module->id]['can_add'] = 1;
                } else {
                    $permission[$module->id]['can_add'] = 0;
                }
            } else {
                $permission[$module->id]['can_add'] = 0;
            }
            if (isset($delete)) {
                if (in_array($module->id, $delete)) {
                    $permission[$module->id]['can_delete'] = 1;
                } else {
                    $permission[$module->id]['can_delete'] = 0;
                }
            } else {
                $permission[$module->id]['can_delete'] = 0;
            }

            if (isset($pay)) {
                if (in_array($module->id, $pay)) {
                    $permission[$module->id]['can_pay'] = 1;
                } else {
                    $permission[$module->id]['can_pay'] = 0;
                }
            } else {
                $permission[$module->id]['can_pay'] = 0;
            }
            if (isset($report)) {
                if (in_array($module->id, $report)) {
                    $permission[$module->id]['can_report'] = 1;
                } else {
                    $permission[$module->id]['can_report'] = 0;
                }
            } else {
                $permission[$module->id]['can_report'] = 0;
            }

            $res = array();
            $res['user_id'] = $user_id;
            $res['module_id'] = $module->id;
            $res['can_view'] = $permission[$module->id]['can_view'];
            $res['can_add'] = $permission[$module->id]['can_add'];
            $res['can_delete'] = $permission[$module->id]['can_delete'];
            $res['can_edit'] = $permission[$module->id]['can_edit'];
            $res['can_certify'] = $permission[$module->id]['can_certify'];
            $res['can_pay'] = $permission[$module->id]['can_pay'];
            $res['can_report'] = $permission[$module->id]['can_report'];
            array_push($result, $res);
        }
        // dd($result);
         try {
                DB::connection($user_db_conn_name)->table('user_permission')->where('user_id', '=', $user_id)->delete();

                DB::connection($user_db_conn_name)->table('user_permission')->insert($result);
                addActivity($user_id,'users',"User Permission Updated",1);
                return redirect('/users')
                    ->with('success', 'Permission Updated Successfully!');
            } catch (\Exception $e) {
                print_r($e);
                return redirect('/users')
                    ->with('error', 'Error While Assigning Permissions!');
            }
    }

  
}

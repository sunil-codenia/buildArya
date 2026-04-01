<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Profiler\Profile;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contact_list = array();
        $user_db_conn_name = session()->get('comp_db_conn_name');
        $data = DB::connection($user_db_conn_name)->table('contact_profile')->get();

        for ($i = 0; $i < sizeof($data); $i++) {
            $other_contact  = DB::connection($user_db_conn_name)->table('contact')->where('profile_id', $data[$i]->id)->get();
            $contact_list[$i]['data'] = $data[$i];
            $contact_list[$i]['list'] = $other_contact;
        }
        $data_contact['data'] = $contact_list;

        return view('layouts.users.contacts')->with('data', json_encode($data_contact));
    }
    public function getContactData(Request $request)
    {
        $profileId = $request->get('profile_id');
        $user_db_conn_name = session()->get('comp_db_conn_name');
        $contacts = DB::connection($user_db_conn_name)->table('contact')->where('profile_id', $profileId)->get();
        return response()->json(['data' => $contacts]);
    }

    public function addcompany(Request $request)
    {

        $comp_name = $request->companyname;
        $contact_person = $request->contactperson;
        $mobile = $request->mobile;
        $email = $request->email;
        $category = $request->category;
        $data = [
            'comp_name' => $comp_name,
            'contact_name' => $contact_person,
            'mobile' => $mobile,
            'email' => $email,
            'category' => $category,
        ];

        $user_db_conn_name = $request->session()->get('comp_db_conn_name');


        $id =  DB::connection($user_db_conn_name)->table('contact_profile')->insertGetId($data);
        addActivity($id, 'contact_profile', "New Contact Profile Created", 10);

        return redirect('/contacts')->with('success', " Successfull!");
    }

    public function edit_company(Request $request)
    {
        $id = $request->get('id');
        $data = array();
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $data_list = array();
        $alldata = DB::connection($user_db_conn_name)->table('contact_profile')->get();
        for ($i = 0; $i < sizeof($alldata); $i++) {
            $dat  = DB::connection($user_db_conn_name)->table('contact_profile')->where('id', $alldata[$i]->id)->get();
            $data_list[$i]['data'] = $alldata[$i];
            $data_list[$i]['list'] = $dat;
        }
        $data['data'] = $data_list;
        $data['edit_data'] = DB::connection($user_db_conn_name)->table('contact_profile')->where('id', '=', $id)->first();
        return  view('layouts.users.contacts')->with('data', json_encode($data));
    }

    public function update_company(Request $request)
    {
        $id = $request->id;
        $company_name = $request->company_name;
        $contact_name = $request->contact_name;
        $mobile = $request->mobile;
        $email = $request->email;
        $category = $request->category;
        $data = [
            'comp_name' => $company_name,
            'contact_name' => $contact_name,
            'mobile' => $mobile,
            'email' => $email,
            'category' => $category,
        ];
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        DB::connection($user_db_conn_name)->table('contact_profile')->where('id', '=', $id)->update($data);
        return redirect('/contacts')->with('success', "Company Profile Updated Successfully!");
    }
    public function update_contact(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        $phone = $request->phone;
        $position = $request->position;
        $email = $request->email;

        $data = [
            'name' => $name,
            'phone' => $phone,
            'position' => $position,
            'email' => $email
        ];
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        DB::connection($user_db_conn_name)->table('contact')->where('id', '=', $id)->update($data);
        addActivity($id, 'contact', "Contact Data Updated", 10);

        return redirect('/contacts')->with('success', "Contact Updated Successfully!");
    }

    public function delete_company_profile(Request $request)
    {
        $id = $request->get('id');
        $user_db_conn_name = session()->get('comp_db_conn_name');
        $comp_name = DB::connection($user_db_conn_name)->table('contact_profile')->where('id', '=', $id)->get()[0]->comp_name;
        DB::connection($user_db_conn_name)->table('contact')->where('profile_id', '=', $id)->delete();
        DB::connection($user_db_conn_name)->table('contact_profile')->where('id', '=', $id)->delete();
        addActivity(0, 'contact_profile', "Contact Profile Deleted - " . $comp_name, 10);


        return redirect('/contacts')->with('success', " Company Profile Deleted Successfully!");
    }
    public function delete_contact(Request $request)
    {
        $id = $request->get('id');
        $user_db_conn_name = session()->get('comp_db_conn_name');
        $contact_name = DB::connection($user_db_conn_name)->table('contact')->where('id', '=', $id)->get()[0]->name;
        DB::connection($user_db_conn_name)->table('contact')->where('id', '=', $id)->delete();
        addActivity(0, 'contact', "Contact Deleted - " . $contact_name, 10);

        return redirect('/contacts')->with('success', "Contact Deleted Successfully!");
    }


    // contact data-----------------

    public function edit_contact(Request $request)
    {
        $id = $request->get('id');
        $data = array();
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');
        $contact_list = array();
        $allcontact = DB::connection($user_db_conn_name)->table('contact')->get();
        for ($i = 0; $i < sizeof($allcontact); $i++) {
            $con_dat = DB::connection($user_db_conn_name)->table('contact')->where('id', $allcontact[$i]->id)->get();
            $contact_list[$i]['data'] = $allcontact[$i];
            $contact_list[$i]['list'] = $con_dat;
        }
        $data['data'] = $contact_list;
        $data['edit_data'] = DB::connection($user_db_conn_name)->table('contact')->where('id', '=', $id)->first();
        return  view('layouts.users.contacts')->with('data', json_encode($data));
    }





    public function addcontact(Request $request)
    {
        $name = $request->name;
        $number = $request->number;
        $email = $request->email;
        $position = $request->position;
        $profile_id = $request->profile_id;
        $contactdata = [
            'profile_id' => $profile_id,
            'name' => $name,
            'phone' => $number,
            'email' => $email,
            'position' => $position,
        ];
        $user_db_conn_name = $request->session()->get('comp_db_conn_name');

        $id  = DB::connection($user_db_conn_name)->table('contact')->insertGetId($contactdata);
        addActivity($id, 'contact', "New Contact Created.", 10);
        return redirect('/contacts')->with('success', " Contact Added Successfully!");
    }
}

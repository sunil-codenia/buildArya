<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ChartController extends Controller
{
    //    public function pieChart()
    //     {
    //         $user_db_conn_name = session()->get('comp_db_conn_name');
    //         $activities = DB::connection($user_db_conn_name)->table('site_payments')->get()->toArray();

    //         $chartData = [['site_id', 'amount']];

    //         foreach ($activities as $activity) {
    //             $chartData[] = [(string)$activity->site_id, (int)$activity->amount];
    //         }

    //         return view('layouts.pie', ['chartData' => json_encode($chartData)]);
    //     }

    public function pieChart()
    {
        $user_db_conn_name = session()->get('comp_db_conn_name');
        $activities = DB::connection($user_db_conn_name)->table('site_payments')->get()->toArray();

        $chartData = [['site_id', 'amount']];

        $amountsBySiteId = [];

        foreach ($activities as $activity) {
            $siteId = (string)$activity->site_id;
            $amount = (int)$activity->amount;

            // Check if the site_id is already in the $amountsBySiteId array
            if (isset($amountsBySiteId[$siteId])) {
                // If yes, add the amount to the existing entry
                $amountsBySiteId[$siteId] += $amount;
            } else {
                // If no, create a new entry for the site_id
                $amountsBySiteId[$siteId] = $amount;
            }
        }

        // Convert $amountsBySiteId to the desired format for chartData
        foreach ($amountsBySiteId as $siteId => $totalAmount) {
            $chartData[] = [$siteId, $totalAmount];
        }

        return $chartData;
    }
}

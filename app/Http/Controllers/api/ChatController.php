<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    //
    public function index(){
        $data = [
            [
                "id"=>1,
                "name"=>"Ashish",
                "layoutType"=>"0",
                "time"=>"2023-05-22 01:04:05",
                "msg"=>"Hello Sohel"
            ],
            [
                "id"=>2,
                "name"=>"Sohel",
                "layoutType"=>"1",
                "time"=>"2023-05-22 01:04:05",
                "msg"=>"Hello Ashish"
            ]
            ,
            [
                "id"=>3,
                "name"=>"Ashish",
                "layoutType"=>"2",
                "time"=>"2023-05-22 01:04:05",
                "msg"=>"https://kashpark.com/assets/img/logo-light.png"
            ],
            [
                "id"=>4,
                "name"=>"Sohel",
                "layoutType"=>"4",
                "time"=>"2023-05-22 01:04:05",
                "msg"=>"https://kashpark.com/assets/img/logo-light.png"
            ],
            [
                "id"=>5,
                "name"=>"Ashish",
                "layoutType"=>"3",
                "time"=>"2023-05-22 01:04:05",
                "msg"=>"https://kashpark.com/assets/audio.mpeg"
            ],
            [
                "id"=>6,
                "name"=>"Sohel",
                "layoutType"=>"5",
                "time"=>"2023-05-22 01:04:05",
                "msg"=>"https://kashpark.com/assets/audio.mpeg"
            ],
            [
                "id"=>7,
                "name"=>"Ashish",
                "layoutType"=>"6",
                "time"=>"2023-05-22 01:04:05",
                "msg"=>"C-13 Sanjay Nagar, Ghaziabad, 201002"
            ],
            [
                "id"=>8,
                "name"=>"Sohel",
                "layoutType"=>"7",
                "time"=>"2023-05-22 01:04:05",
                "msg"=>"C-13 Sanjay Nagar, Ghaziabad, 201002"
            ],
            
        ];
        return json_encode($data);
    }
}

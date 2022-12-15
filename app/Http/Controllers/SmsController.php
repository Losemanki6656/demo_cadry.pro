<?php

namespace App\Http\Controllers;
use App\Models\Cadry;

use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function send_sms($cadry_id, Request $request)
    {
        $val = Cadry::find($cadry_id);
        $char = ['(', ')', ' ','-','+'];
        $replace = ['', '', '','',''];

        $phone = str_replace($char, $replace, $val->phone);

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://91.204.239.44/broker-api/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{ 
                "messages":
                [ 
                    {
                        "recipient": "'.$phone.'",
                        "message-id":"1",
                        "sms": 
                        {
                            "originator": "3700","content": 
                            {
                                "text": "'.$request->comment.'"
                            }
                        }
                    }
                ]
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic YnV4b3JvdGVtaXJ5OnU4MjNTMkpwaQ==',
                'Content-Type: application/json'
            ),
            ));

            $response = curl_exec($curl);
            
            return response()->json([
                'message' => 'Successfully recieved'
            ]);
    }
}

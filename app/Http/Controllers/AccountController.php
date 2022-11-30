<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use Illuminate\Support\Facades\DB;



class AccountController extends Controller
{
    public function CreateAccount(Request $request)
    {
        $response = array();
        //$incomingData = $request;
        //dd($request);
        if (is_numeric($request->emailaddress)) {
        }
        // if (empty($request)) {

        //     $response['message'] = 'please ensure all input are not empty';
        //     $response['status'] = 'failed';
        // } else {
        //     if (is_null($request->emailaddress)) {

        //         $check_existing_phonenumber = DB::table('account')->select('*')->where('Phone_number', $request->emailaddress)->limit(1);

        //         if ($check_existing_phonenumber) {
        //             $response['message'] = " phone number '.$request->phonenumber.' already exist and Account not created";
        //             $response['status'] = 'failed';
        //         } else {

        //             $create_account = DB::table('account')->insert([
        //                 'Phone_number' => $request->phonenumber,
        //             ]);

        //             if ($create_account) {
        //                 $response['message'] = " Account Created Successfully with phone number '.$request->phonenumber.'";
        //                 $response['status'] = 'success';
        //             } else {
        //                 $response['message'] = 'Account Cannot be created';
        //                 $response['status'] = 'failed';
        //             }
        //         }
        //     } elseif (is_null($request->phonenumber)) {

        //         $check_existing_emailaddress = DB::table('account')->select('*')->where('Phone_number', $request->emailaddress)->limit(1);

        //         if ($check_existing_emailaddress) {
        //             $response['message'] = " Emailaddress'.$request->emailaddress.' already exist and Account not created";
        //             $response['status'] = 'failed';
        //         } else {

        //             $create_account = DB::table('account')->insert([
        //                 'Email_address' => $request->emailaddress,
        //             ]);

        //             if ($create_account) {
        //                 $response['message'] = " Account Created Successfully with Email '.$request->emailaddress.'";
        //                 $response['status'] = 'success';
        //             } else {
        //                 $response['message'] = 'Account Cannot be created';
        //                 $response['status'] = 'failed';
        //             }
        //         }
        //     } else {
        //         $response['message'] = 'please ensure all input are not empty';
        //         $response['status'] = 'failed';
        //     }
        // }
        return new AccountResource($response);
    }
    public function UpdateAccount(Request $request)
    {
        $response = array();
        //$incomingData = $request;
        //dd($request);
        if (empty($request)) {
            $response['message'] = 'please ensure all input are not empty';
            $response['status'] = 'failed';
        } else {
            if (
                is_null($request->fullname) || is_null($request->lastname) || is_null($request->emailaddress) || is_null($request->phonenumber)
                || is_null($request->profileimage) || is_null($request->residentialaddress)
            ) {

                $response['message'] = 'please ensure all input are not empty';
                $response['status'] = 'failed';
            } else {
                dd($request);
            }
        }
        echo json_encode($response);
    }
}
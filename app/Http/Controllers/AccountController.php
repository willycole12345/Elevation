<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use Faker\Provider\bg_BG\PhoneNumber;
use Illuminate\Support\Facades\DB;



class AccountController extends Controller
{
    public function CreateAccount(Request $request)
    {
        $response = array();
        $request->validate([
            'email' => 'required|email|max:255|regex:/(.*)@myemail\.com/i|unique:users'
        ]);

        if (empty($request)) {

            $response['message'] = 'please ensure all input are not empty';
            $response['status'] = 'failed';
        } else {
            if (empty($request->emailaddress)) {

                $check_existing_phonenumber = DB::table('account')->select('*')->where('Phone_number', $request->phonenumber)->limit(1);

                if ($check_existing_phonenumber) {
                    $response['message'] = " phone number '.$request->phonenumber.' already exist and Account not created";
                    $response['status'] = 'failed';
                } else {
                    if (is_numeric($request->phonenumber)) {
                        $create_account = DB::table('account')->insert([
                            'Phone_number' => $request->phonenumber,
                        ]);

                        if ($create_account) {
                            $response['message'] = " Account Created Successfully with phone number '.$request->phonenumber.'";
                            $response['status'] = 'success';
                        } else {
                            $response['message'] = 'Account Cannot be created';
                            $response['status'] = 'failed';
                        }
                    }
                }
            } elseif (empty($request->phonenumber)) {

                $check_existing_emailaddress = DB::table('account')->select('*')->where('Email_address', $request->emailaddress)->limit(1);

                if ($check_existing_emailaddress) {
                    $response['message'] = " Emailaddress'.$request->emailaddress.' already exist and Account not created";
                    $response['status'] = 'failed';
                } else {

                    $create_account = DB::table('account')->insert([
                        'Email_address' => $request->emailaddress,
                    ]);

                    if ($create_account) {
                        $response['message'] = " Account Created Successfully with Email '.$request->emailaddress.'";
                        $response['status'] = 'success';
                    } else {
                        $response['message'] = 'Account Cannot be created';
                        $response['status'] = 'failed';
                    }
                }
            } else {
                $response['message'] = 'please ensure all input are not empty';
                $response['status'] = 'failed';
            }
        }
        return new AccountResource($response);
    }


    public function verifiyaccount(Request $request)
    {
    }

    //
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
                empty($request->fullname) || empty($request->lastname) || empty($request->emailaddress) || empty($request->phonenumber)
                || empty($request->residentialaddress)
            ) {
                $response['message'] = 'please ensure all input are not empty';
                $response['status'] = 'failed';
            } else {
                $update_acc_rec = DB::table('users')
                    ->where('Email_address', $request->emailaddress)
                    ->orWhere('Phone_number', '=', $request->phonenumber)
                    ->update(
                        ['First_name' => $request->fullname],
                        ['Last_name' => $request->lastname],
                        ['Email_address' => $request->emailaddress],
                        ['Phone_number' => $request->phonenumber],
                        ['Residential_address' => $request->residentialaddress]

                    );
                dd($request);
            }
        }
        echo json_encode($response);
    }
}
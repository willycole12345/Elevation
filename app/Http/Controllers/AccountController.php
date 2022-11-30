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

        if (empty($request)) {

            $response['message'] = 'please ensure all input are not empty';
            $response['status'] = 'failed';
        } else {

            $incomingData = $request->CreateAccount;
            $check_email_phone = $this->validate_email_or_phone($incomingData);

            if ($check_email_phone == 'email') {

                $check_existing_emailaddress = DB::table('account')->select('*')->where('Email_address', $incomingData)->limit(1);

                if ($check_existing_emailaddress) {
                    $response['message'] = " Emailaddress'.$incomingData.' already exist and Account not created";
                    $response['status'] = 'failed';
                } else {

                    $create_account = DB::table('account')->insert([
                        'Email_address' => $incomingData,
                    ]);

                    if ($create_account) {
                        $response['message'] = " Account Created Successfully with Email '.$incomingData.'";
                        $response['status'] = 'success';
                    } else {
                        $response['message'] = 'Account Cannot be created';
                        $response['status'] = 'failed';
                    }
                }
            } else {
                $check_existing_phonenumber = DB::table('account')->select('*')->where('Phone_number', $incomingData)->limit(1);

                if ($check_existing_phonenumber) {
                    $response['message'] = " phone number '.$incomingData' already exist and Account not created";
                    $response['status'] = 'failed';
                } else {
                    $create_account = DB::table('account')->insert([
                        'Phone_number' => $incomingData,
                    ]);

                    if ($create_account) {
                        $response['message'] = " Account Created Successfully with phone number '.$incomingData.'";
                        $response['status'] = 'success';
                    } else {
                        $response['message'] = 'Account Cannot be created';
                        $response['status'] = 'failed';
                    }
                }
            }
            $response['message'] = 'please ensure all input are not empty';
            $response['status'] = 'failed';
        }
        return new AccountResource($response);
    }

    public function verifiyaccount(Request $request)
    {
    }


    public function UpdateAccount(Request $request, $UpdateAccount)
    {
        $response = array();
        //$incomingData = $request;
        //dd($request);
        if (empty($request)) {
            $response['message'] = 'please ensure all input are not empty';
            $response['status'] = 'failed';
        } else {
            $incomingData_update = $UpdateAccount;
            if (empty($incomingData_update)) {
                $response['message'] = 'please ensure all input are not empty';
                $response['status'] = 'failed';
            } else {

                $check_email_phone = $this->validate_email_or_phone($incomingData);

                if ($check_email_phone == 'phone') {

                    if (
                        empty($request->fullname) || empty($request->lastname) || empty($request->emailaddress) || empty($request->phonenumber)
                        || empty($request->residentialaddress)
                    ) {

                        $response['message'] = 'please ensure all input are not empty';
                        $response['status'] = 'failed';
                    } else {
                        $update_acc_rec = DB::table('account')
                            ->where('Phone_number', $incomingData_update)
                            ->update(
                                ['First_name' => $request->fullname],
                                ['Last_name' => $request->lastname],
                                ['Email_address' => $request->emailaddress],
                                ['Phone_number' => $request->phonenumber],
                                ['Residential_address' => $request->residentialaddress]

                            );
                        if ($update_acc_rec) {
                            $response['message'] = 'Account has been updated';
                            $response['status'] = 'failed';
                        } else {
                            $response['message'] = 'please ensure all input are not empty';
                            $response['status'] = 'failed';
                        }
                    }
                } else {
                    if (
                        empty($request->fullname) || empty($request->lastname) || empty($request->emailaddress) || empty($request->phonenumber)
                        || empty($request->residentialaddress)
                    ) {

                        $response['message'] = 'please ensure all input are not empty';
                        $response['status'] = 'failed';
                    } else {
                        $update_acc_rec = DB::table('account')
                            ->where('Email_address', $incomingData_update)
                            ->update(
                                ['First_name' => $request->fullname],
                                ['Last_name' => $request->lastname],
                                ['Email_address' => $request->emailaddress],
                                ['Phone_number' => $request->phonenumber],
                                ['Residential_address' => $request->residentialaddress]

                            );
                        if ($update_acc_rec) {
                            $response['message'] = 'Account has been updated';
                            $response['status'] = 'failed';
                        } else {
                            $response['message'] = 'please ensure all input are not empty';
                            $response['status'] = 'failed';
                        }
                    }
                }
            }
        }
        return new AccountResource($response);
    }

    public function image_upload()
    {
    }
    public function validate_email_or_phone($create_type_number_or_phone)
    {
        if (is_numeric($create_type_number_or_phone)) {
            $field = 'phone';
        } elseif (filter_var($create_type_number_or_phone, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        } else {
            $field = '';
        }
        return $field;
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\AccountResource;
use App\Mail\VerificationMail;
use App\Models\Account;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;





class AccountController extends Controller
{
    public function CreateAccount(Request $request)
    {
        $response = array();
        $code = rand(1231, 7879);

        if (empty($request)) {

            $response['message'] = 'please ensure all input are not empty';
            $response['status'] = 'failed';
        } else {

            $incomingData = $request->CreateAccount;
            $check_email_phone = $this->validate_email_or_phone($incomingData);

            if ($check_email_phone == 'email') {

                $check_existing_emailaddress = DB::table('accounts')->where('email', '=', $incomingData)->exists();

                // dd($check_existing_emailaddress);
                if ($check_existing_emailaddress == true) {
                    //  dd($check_existing_emailaddress);
                    $response['message'] = " Emailaddress'.$incomingData.' already exist and Account not created";
                    $response['status'] = 'failed';
                } else {

                    $create_account = DB::table('accounts')->insert([
                        'email' => $incomingData,
                        'otp' => $code,
                        'verify_flag' => 'N'
                    ]);
                    if ($create_account) {
                        $this->sendVerificationmail($incomingData, $code);
                        $response['message'] = " Account Created Successfully with Email '.$incomingData.'";
                        $response['status'] = 'success';
                    } else {
                        $response['message'] = 'Account Cannot be created';
                        $response['status'] = 'failed';
                    }
                    //  dd($check_existing_emailaddress);

                }
            } else {
                $check_existing_phonenumber = DB::table('accounts')->where('Phone_number', '=', $incomingData)->exists();

                if ($check_existing_phonenumber == true) {
                    $response['message'] = " phone number '.$incomingData' already exist and Account not created";
                    $response['status'] = 'failed';
                } else {
                    $create_account_phne = DB::table('accounts')->insert([
                        'Phone_number' => $incomingData,
                        'otp' => $code,
                        'verify_flag' => 'N'
                    ]);
                    $this->sendVerificationmail($incomingData, $code);
                    if ($create_account_phne) {
                        $response['message'] = " Account Created Successfully with phone number '.$incomingData.'";
                        $response['status'] = 'success';
                    } else {
                        $response['message'] = 'Account Cannot be created';
                        $response['status'] = 'failed';
                    }
                }
                $response['message'] = 'please ensure all input are not empty';
                $response['status'] = 'failed';
            }
        }
        return json_encode($response);
    }

    public function sendVerificationmail($email, $vercode)
    {

        $verication_code = rand(10, 100);
        $email = "cole.williams84@yahoo.com";
        $mailData = [
            "title" => 'verification code',
            "verification code" => $vercode,

        ];
        //Mail::to($email)->send(new VerificationMail($mailDa));
        $return = Mail::to($email)->send(new VerificationMail($mailData));
        if ($return) {
            return "Email is sent successfully.";
        } else {
            return false;
        }
        //  dd($retrn);

    }
    public function sendVerificationmail_test($email, $vercode)
    {

        $verication_code = rand(10, 100);
        $email = "cole.williams84@yahoo.com";
        $mailData = [
            "title" => 'verification code',

        ];
        //Mail::to($email)->send(new VerificationMail($mailDa));
        Mail::to($email)->send(new VerificationMail($mailData));

        //  dd($retrn);
        dd("Email is sent successfully.");
    }

    public function verify_users(Request $request)
    {
        if ($request) {
            $response['message'] = 'please ensure all input are not empty';
            $response['status'] = 'failed';
        } else {
            $incomingData = $request->emailaddress;
            $check_existing = DB::table('accounts')->where('email', '=', $incomingData);
            if ($check_existing) {
                if ($check_existing->otp == $request->otpcode) {
                    //update
                    $update_otp = DB::table('account')
                        ->where('otp', $request->otpcode)
                        ->update(
                            ['verify_flag' => 'Y']
                        );
                    if ($update_otp) {
                        $response['message'] = 'Your Account has be verified successfully';
                        $response['status'] = 'success';
                    } else {
                        $response['message'] = 'Kindly confirm your otp';
                        $response['status'] = 'failed';
                    }
                } else {
                    $response['message'] = 'please ensure your otp is correct';
                    $response['status'] = 'failed';
                }
            }
            return new AccountResource($response);
        }
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

                $check_email_phone = $this->validate_email_or_phone($incomingData_update);

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
                                ['email' => $request->emailaddress],
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
                                ['email' => $request->emailaddress],
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

    public function image_upload(Request $request, $UpdateImage)
    {
        if (empty($request)) {
            $response['message'] = 'please ensure all input are not empty';
            $response['status'] = 'failed';
        } else {
            if (empty($request->profileImage)) {
            } else {
                $check_email_phone = $this->validate_email_or_phone($UpdateImage);
                if ($check_email_phone == 'phone') {
                    $file = $request->file('profile_image');
                    $file_dd = $file->getClientOriginalExtension();
                    $title = uniqid() . '.' . $file_dd;
                    $imagepath = $file->move(public_path('images'), $file_dd);
                    $update_acc_rec = DB::table('account')
                        ->where('Phone_number', $check_email_phone)
                        ->update(['Profile_picture' => $title]);
                    if ($update_acc_rec) {
                        $response['message'] = 'Profile Image uploaded sucessfully';
                        $response['status'] = 'success';
                    } else {
                        $response['message'] = 'Account has been updated';
                        $response['status'] = 'failed';
                    }
                } else {
                    $file = $request->file('profile_image');
                    $file_dd = $file->getClientOriginalExtension();
                    $title = uniqid() . '.' . $file_dd;
                    $imagepath = $file->move(public_path('images'), $file_dd);
                    $update_acc_rec = DB::table('account')
                        ->where('email', $check_email_phone)
                        ->update(['Profile_picture' => $title]);

                    if ($update_acc_rec) {
                        $response['message'] = 'Profile Image uploaded sucessfully';
                        $response['status'] = 'success';
                    } else {
                        $response['message'] = 'Account has been updated';
                        $response['status'] = 'failed';
                    }
                }
            }
            return new AccountResource($response);
        }
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

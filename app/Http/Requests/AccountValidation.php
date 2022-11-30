<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'First_name' => 'required',
            'Last_name' => 'required',
            'Email_address' => 'required',
            'Phone_number' => 'required',
            'Profile_picture' => 'required|max:1024',
            'Residential_address' => 'required',
        ];
    }

    public function message()
    {
        return [
            'First_name.required' => 'Please ensure  provide your Fullname',
            'Last_name.required' => 'Please ensure provide your Lastname',
            'Email_address.required' => 'Please ensure  provide your Email Address',
            'Phone_number.required' => 'Please provide your Phone number',
            'Profile_picture.required' => 'Please ensure your Profile Picture',
            'Residential_address.required' => 'Please ensure provide your residentail address',
        ];
    }
}

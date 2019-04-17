<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class UpdateUserRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'username' => 'required|CheckFieldForUpdate:' . $this->user,
            'email' => 'required|CheckFieldForUpdate:' . $this->user,
            'password' => 'required_with:password_confirmation|confirmed',
            'password_confirmation' => 'required_with:password',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address' => 'required',
            'house_number' => 'required|integer',
            'postal_code' => 'required|integer',
            'city' => 'required',
            'telephone_number' => 'required|digits:10|CheckFieldForUpdate:' . $this->user,
        ];
    }
    
    public function messages()
    {
        return [
            'username.CheckFieldForUpdate' => 'The :attribute is already taken by another user.',
            'email.CheckFieldForUpdate'  => 'The :attribute is already taken by another user.',
        ];
    }
}

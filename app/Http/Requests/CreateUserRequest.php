<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class CreateUserRequest extends FormRequest
{
    
    const REQUIRED = 'required';
    
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'username' => 'required|unique:users',
            'email' => self::REQUIRED . '|unique:users,email|email',
            'password' => self::REQUIRED . '|confirmed|min:6',
            'password_confirmation' => self::REQUIRED,
            'first_name' => self::REQUIRED,
            'last_name' => self::REQUIRED,
            'address' => self::REQUIRED,
            'house_number' => self::REQUIRED . '|integer',
            'postal_code' => self::REQUIRED . '|integer',
            'city' => self::REQUIRED,
            'telephone_number' => self::REQUIRED . '|unique:users|digits:10',
        ];
    }
}
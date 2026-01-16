<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**branch	first_name	last_name	photo	mobile	email	email_verified_at	password	dob	gender	role	notify	status
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'branch' => 'required|integer',
            'username' => 'required|string|max:50',
            'first_name' => 'required|string|max:20',
            'last_name' => 'nullable|string|max:20',
            'photo' => 'nullable|string',
            'mobile' => 'required|string|max:15|unique:users,mobile',
            'email' => 'required|string|email|max:50|unique:users,email',
            'password' => 'required|string|min:8',
            'dob' => 'nullable|string',
            'gender' => 'nullable|string',
            'role' => 'required|integer',
            'notify' => 'required|integer',
            'status' => 'required|integer',
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'branch' => $this->input('branch', 1), // Default value for branch
            'photo' => $this->input('photo', ''), // Default value for photo
            'dob' => $this->input('dob', ''), // Default value for dob
            'gender' => $this->input('gender', ''), // Default value for gender
            'role' => $this->input('role', 5),     // Default value for role
            'notify' => $this->input('notify', 1), // Default value for notify
            'status' => $this->input('status', 0), // Default value for status
        ]);
    }
}

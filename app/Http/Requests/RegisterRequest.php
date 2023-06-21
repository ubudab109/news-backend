<?php

namespace App\Http\Requests;

use App\Http\Resources\RespondError;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'email'      => ['required', 'email', Rule::unique('users', 'email')],
            'name'       => ['required'],
            'password'   => ['required'],
            'c_password' => ['required', 'same:password'],
        ];
    }

    /**
     * Messages error for each validation
     * 
     * @return array
     */
    public function messages()
    {
        return [
            'email.required'    => 'Email is required',
            'email.email'       => 'Invalid email',
            'password.required' => 'Password is required',
            'c_password.same'   => 'Confirm password does not match with password'
        ];
    }

	/**
     * This function throws an exception with a JSON response containing validation errors if
     * validation fails.
     * 
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws HttpResponseException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $respond = [
            'message' => 'Bad Request',
            'errors'  => $validator->errors(),
        ];
        throw new HttpResponseException(response()->json($respond, Response::HTTP_BAD_REQUEST));
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
	/**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

	/**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'   => ['required'],
            'email'  => ['required', 'email', Rule::unique('users')->ignore(Auth::user()->id)],
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
        throw new HttpResponseException(response()->json([
            'status' => 'Bad Request',
            'errors' => $validator->errors()
        ], Response::HTTP_BAD_REQUEST));
    }
}
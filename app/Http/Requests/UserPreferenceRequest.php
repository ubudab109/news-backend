<?php

namespace App\Http\Requests;

use App\Constants\PreferenceType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class UserPreferenceRequest extends FormRequest
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
            'type'  => [
                'required', 
                'array',
                'in:'. PreferenceType::SOURCES()->getValue(). ',' . 
                PreferenceType::AUTHORS()->getValue(). ','. PreferenceType::CATEGORIES()->getValue()
            ],
            'data'  => ['required', 'array'], 
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
            'data.required' => 'Please fill data preference for at least one data',
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
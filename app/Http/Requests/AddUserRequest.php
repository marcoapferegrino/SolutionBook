<?php

namespace SolutionBook\Http\Requests;

class AddUserRequest extends Request
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

        $rules = [
            'username'  => 'required',
            'email'     => 'required',
            'password'  => 'required',
            'avatar'    => 'extension:jpg,png,bmp'

        ];


        return $rules;
    }
}

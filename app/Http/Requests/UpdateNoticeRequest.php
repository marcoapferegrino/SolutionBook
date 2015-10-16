<?php

namespace SolutionBook\Http\Requests;

use SolutionBook\Http\Requests\Request;

class UpdateNoticeRequest extends Request
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
    public function rules(\Illuminate\Http\Request $request)
    {

        $rules = [
            'title'=> 'required ',
            'description'=> 'required',
            'finishDate'=> 'required'
        ];


        return $rules;
    }
}

<?php

namespace SolutionBook\Http\Requests;



class AddNoticeRequest extends Request
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
            'title'=> 'required ',
            'description'=> 'required',
            'finishDate'=> 'required',
            'file'    => 'extension:jpg,png,bmp'
        ];


        return $rules;
    }
}

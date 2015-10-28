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
    public function rules(\Illuminate\Http\Request $request)
    {
        $apoyo=$request->all();
        $rules = [
            'title'=> 'required ',
            'description'=> 'required',
            'apoyo'=> 'array',
            'finishDate'=> 'required',
            'file'    => 'extension:jpg,png,bmp'
        ];
        foreach($apoyo['apoyo'] as $key => $val)
        {
            $rules['apoyo.'.$key] = 'extension:pdf,doc,docx,bmp,jpg,png,mp3,wav';
        }

        return $rules;
    }
}

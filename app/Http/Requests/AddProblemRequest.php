<?php

namespace SolutionBook\Http\Requests;

use SolutionBook\Http\Requests\Request;

class AddProblemRequest extends Request
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
        $images = $request->all();
       // dd($request);
       $rules = [
            'title'=> 'required',
            'institucion'=>'required',
            'descripcion'=> 'required',
            'limitTime'=> 'required',
            'limitMemory'=> 'numeric|required',
            'judgeList'=> '',
            'ejemploen'=>'required',
            'ejemplosa'=>'required',
            'tags'=> 'required',
            'inputs'=> 'required',
            'outputs'=> 'required',
            'images'=> 'array',
            'youtube' => array('url','regex:/youtube/'),
            'github' => array('url','regex:/github|bitbucket/'),
        ];

        foreach($images as $key => $val)
        {
            $rules['images.'.$key] = 'in:jpg,png,bmp,pdf';
        }

        return $rules;
    }
}
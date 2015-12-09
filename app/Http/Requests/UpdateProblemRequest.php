<?php

namespace SolutionBook\Http\Requests;


class UpdateProblemRequest extends Request
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
        $images = $request->images;
//        dd($images);
        $rules = [
            'imgsDelete' => 'array',
            'title'=> 'required',
            'institucion'=>'',
            'descripcion'=> 'required',
//            'limitTime'=> 'numeric',
//            'limitMemory'=> 'numeric|required',
            'judgeList'=> '',
            'ejemploen'=>'required',
            'ejemplosa'=>'required',
            'tags'=> 'required',
//            'inputs'=> 'required',
//            'outputs'=> 'required',
            'images'=> 'array',
            'youtube' => array('url','regex:/youtube/'),
            'github' => array('url','regex:/github|bitbucket/'),
        ];

        foreach($images as $key => $val)
        {
            $rules['images.'.$key] = 'extension:jpg,png,bmp,pdf';
        }

        return $rules;
    }
}

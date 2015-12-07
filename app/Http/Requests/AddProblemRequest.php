<?php

namespace SolutionBook\Http\Requests;


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
        $youtube = $request->all();
        $github = $request->all();
        //dd($images);
        //dd($request);
       $rules = [
            'title'=> 'required',
            'institucion'=>'',
            'descripcion'=> 'required',
            'limitTime'=> 'numeric',
            'limitMemory'=> 'numeric|required',
            'judgeList'=> '',
            'ejemploen'=>'required',
            'ejemplosa'=>'required',
            'tags'=> 'required',
            'inputs'=> 'required',
            'outputs'=> 'required',
            'images'=> 'array',
            'youtube' => 'array',
            'github' =>'array',
        ];
        foreach($youtube as $key => $val)
        {
            $rules['youtube.'.$key] = array('url','regex:/youtube/','array');
        }
        foreach($github as $key => $val)
        {
            $rules['github.'.$key] = array('url','regex:/github|bitbucket/','array');
        }
        foreach($images as $key => $val)
        {
            $rules['images.'.$key] = 'in:jpg,png,bmp,pdf';
        }

        return $rules;
    }
}
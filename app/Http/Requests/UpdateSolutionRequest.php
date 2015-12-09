<?php

namespace SolutionBook\Http\Requests;

use SolutionBook\Http\Requests\Request;

class UpdateSolutionRequest extends Request
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
        $web = $request->web;
//        dd($images);
        $rules = [
            'imgsDelete' => 'array',
            'explanation'=> 'required',
            'images'=> 'array',
            'audioFile'=> 'extension:mp3',
            'youtube' => array('url','regex:/youtube/'),
            'repositorio' => array('url','regex:/github|bitbucket/'),
        ];
        foreach($web as $key => $val)
        {
            $rules['web.'.$key] ='url';
        }
        foreach($images as $key => $val)
        {
            $rules['images.'.$key] = 'extension:jpg,jpeg,png,bmp';
        }
        return $rules;
    }
}

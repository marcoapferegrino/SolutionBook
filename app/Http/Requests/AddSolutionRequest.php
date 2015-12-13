<?php

namespace SolutionBook\Http\Requests;


class AddSolutionRequest extends Request
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

//        dd($request->all(),$request->images,$request->audioFile);
        $rules = [
            'optionsLanguages'=> 'required | in:c,c++,java,python',
            'explanation'=> 'required',
            'fileCode'=> 'required | extension:c,cpp,py,java| languajeWithFileExtension:'.$request->optionsLanguages,
            'audioFile'=> 'extension:mp3',
            'images'=> 'array',
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

<?php

namespace SolutionBook\Http\Requests;



use Carbon\Carbon;

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
        $today = Carbon::now()->toDateString();
        $minFecha=$today;
        $maxFecha=Carbon::now()->addYears(1);
        $apoyo=$request->all();
        $rules = [
            'title'=> 'required ',
            'description'=> 'required',
            'apoyo'=> 'array',
            'gallery'=>'array',
            'finishDate'=> 'required|date|after:'.$minFecha.'|before:'.$maxFecha,
            'file'    => 'extension:jpg,png,bmp,jpeg'
        ];
        foreach($apoyo['apoyo'] as $key => $val)
        {
            $rules['apoyo.'.$key] = 'extension:pdf,doc,txt,docx,bmp,jpg,png,mp3,wav';
        }
        foreach($apoyo['gallery'] as $key => $val)
        {
            $rules['gallery.'.$key] = 'extension:bmp,jpg,png,jpeg';
        }

        return $rules;
    }
}

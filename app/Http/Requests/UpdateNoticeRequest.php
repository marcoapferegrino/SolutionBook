<?php

namespace SolutionBook\Http\Requests;



use Carbon\Carbon;

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

        $today = Carbon::now()->toDateString();
        $minFecha=$today;
        $maxFecha=Carbon::now()->addYears(1);
        $apoyo=$request->all();
        $rules = [
            'title'=> 'required ',
            'description'=> 'required',
            'apoyo'=> 'array',
            'finishDate'=> 'required|date|after:'.$minFecha.'|before:'.$maxFecha,
            'file'    => 'extension:jpg,png,bmp,jpeg'
        ];
        foreach($apoyo['apoyo'] as $key => $val)
        {
            $rules['apoyo.'.$key] = 'extension:pdf,doc,docx,txt,bmp,jpg,png,mp3,wav,jpeg';
        }


        return $rules;
    }
}

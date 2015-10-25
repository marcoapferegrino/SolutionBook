<?php

namespace SolutionBook\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SolutionBook\Entities\JudgesList;

use SolutionBook\Http\Requests;
use SolutionBook\Http\Requests\AddJudgeRequest;
use SolutionBook\Http\Controllers\Controller;

class JudgesController extends Controller
{
    //
    public function addJudge(AddJudgeRequest $request)
    {
        //        dd($request);
        $name=$request->name;
        $url=$request->addressWeb;
        $facebook=$request->facebook;
        $twitter=$request->twitter;
        $image=$request->images;
        $nameI="";
        if($image!=null)
            $nameI = $image->getClientOriginalName();
        $judge=JudgesList::create([
            'name'=>$name,
            'addressWeb'=>$url,
            'facebook'=> $facebook,
            'twitter'=> $twitter,

        ]);
        $path="judges/".$judge->id."/";
        if($image!=null){
            $judge->update(['image' =>$path.$nameI,] );
            $image->move($path,$nameI);
        }
        if($request->ajax()){
            return response()->json(['success' 		=> 	true,'message' 		=> 	'<option value="'.$judge->id.'" selected="selected">'.$judge->name.'</option>']);
        }

        return redirect()->route("problem.addFormProblem");

    }
}

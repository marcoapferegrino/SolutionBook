<?php

namespace SolutionBook\Http\Controllers;

use SolutionBook\Entities\Solution;
use Illuminate\Http\Request;

use SolutionBook\Http\Requests;
use SolutionBook\Http\Controllers\Controller;

class LikesController extends Controller
{
    public function addLike($id)
    {
//        dd("votando por la solución:".$id);

        $solution = Solution::findOrFail($id);
        $solution->numLikes+=1;
        $numDislikes = $solution->dislikes;
        if($numDislikes!=0)
        {
            $solution->dislikes-=1;
        }
        $solution->save();

        $user = auth()->user();
        $user->like($solution->id);

        return redirect()->back();
    }

    public function disLike($id)
    {
        $solution = Solution::findOrFail($id);
        $solution->numLikes-=1;
        $solution->dislikes+=1;
        $solution->save();

        $user = auth()->user();
        $user->disLike($solution->id);

        return redirect()->back();

    }
}

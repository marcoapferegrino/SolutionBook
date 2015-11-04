<?php namespace SolutionBook\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


/**
 * Class Problem
 * @package SolutionBook\Entities
 */
class Problem extends Entity {


    protected $fillable = ['title', 'author', 'institution', 'description', 'numSolutions', 'limitTime', 'limitMemory', 'numWarnings', 'state', 'problemLink', 'user_id', 'judgeList_id'];

	protected $table = 'problems';


    public function user(){
        return $this->belongsTo(User::getClass());
    }


    public function judgeList()
    {
        return $this->hasOne(JudgesList::getClass());
    }

    public function tags()
    {
        return $this->hasMany(ProblemasTags::getClass());

    }

    public function warnings(){
        return $this->hasMany(Warning::getClass());
    }

    public function links(){
        return $this->hasMany(Link::getClass());
    }

    public function files(){
        return $this->hasMany(Files::getClass());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Solution
     */
    public function solutions(){
        return $this->hasMany(Solution::getClass());
    }

    private static function solutionsPreviewBase(){
        $previewSolutions = DB::table('solutions')
            ->join('users','users.id','=','solutions.user_id')
            ->join('code_solutions','code_solutions.id','=','solutions.codeSolution_id')
            ->select('users.id as userId','users.username','solutions.id','users.avatar',
                'solutions.explanation','solutions.state', 'solutions.numLikes','solutions.dislikes',
                'code_solutions.limitTime','code_solutions.limitMemory','code_solutions.language');
        return $previewSolutions;
    }
    /**
     * @return mixed
     */
    public function solutionsPreview()
    {
        $previewSolutions = self::solutionsPreviewBase();
        $previewSolutions= $previewSolutions->where('solutions.problem_id',$this->id)
            ->paginate(10);

        return $previewSolutions;
    }

    /**
     * @param $language
     * @param $restriction
     * @return solutionPreviewsOrdered
     */
    public function solutionsPreviewOrdered($language,$restriction)
    {
        $previewSolutions = self::solutionsPreviewBase();
        $previewSolutions= $previewSolutions->where('solutions.problem_id',$this->id);
        if ($language != "") {
            $previewSolutions=$previewSolutions->where('code_solutions.language',$language);
        }
        if ($restriction != "") {

            if ($restriction=="limitTime") {
                $previewSolutions = $previewSolutions->orderBy('code_solutions.limitTime', 'asc');
            }
            elseif($restriction=="limitMemory")
            {
                $previewSolutions = $previewSolutions->orderBy('code_solutions.limitMemory', 'asc');
            }
            elseif($restriction=="numLikes")
            {
                $previewSolutions = $previewSolutions->orderBy('solutions.numLikes', 'desc');
            }

        }
        return $previewSolutions->paginate(10);
    }
    public function SolutionsPerLanguage($language){

        $solutions = DB::table('solutions')
            ->join('users','users.id','=','solutions.user_id')
            ->join('code_solutions','code_solutions.id','=','solutions.codeSolution_id')
            ->select('code_solutions.language','code_solutions.created_at')
            ->where('solutions.problem_id',$this->id)
            ->where('code_solutions.language',$language)->get();


        return $solutions;

    }


}

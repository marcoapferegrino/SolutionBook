<?php namespace SolutionBook\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

/**
 * Class Problem
 * @package SolutionBook\Entities
 */
class Problem extends Entity {


    protected $fillable = ['title', 'author', 'institution', 'description', 'numSolutions', 'limitTime','share', 'limitMemory', 'numWarnings', 'state', 'problemLink', 'user_id', 'judgeList_id'];

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
                'code_solutions.limitTime','code_solutions.limitTimeString','code_solutions.limitMemory','code_solutions.language');
        return $previewSolutions;
    }
    /**
     * @return mixed
     */
    public function solutionsPreview()
    {
        $previewSolutions = self::solutionsPreviewBase();
        $previewSolutions= $previewSolutions->where('solutions.problem_id',$this->id)
            ->where('solutions.state','<>','blocked')
            ->where('solutions.state','<>','deleted')
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
        $previewSolutionsEmpty = $previewSolutions
            ->where('solutions.state','<>','blocked')
            ->where('solutions.state','<>','deleted')->get();

        if (empty($previewSolutionsEmpty)) {
           Session::flash('error', 'No hay coincidencias con esta búsqueda.');
        }

        return $previewSolutions->paginate(10);
    }
    public function SolutionsPerLanguage($language){

        $solutions = DB::table('solutions')
            ->join('users','users.id','=','solutions.user_id')
            ->join('code_solutions','code_solutions.id','=','solutions.codeSolution_id')
            ->select('code_solutions.language','code_solutions.created_at')
            ->where('solutions.problem_id',$this->id)
            ->where('code_solutions.language',$language)
            ->where('solutions.state','<>','blocked')
            ->where('solutions.state','<>','deleted')
            ->get();


        return $solutions;

    }
    public static function similarTitle($cadena){
        $sql="SELECT * FROM `problems` WHERE title like '%$cadena%' order by case when title LIKE '$cadena' then 0 when title LIKE '$cadena%' then 1 when title LIKE '%$cadena%' then 2 when title LIKE '%$cadena' then 3 else 4 end, title";
        $result= \DB::select(DB::raw($sql));
        return $result;
    }
    public static function problemasPorId($ids,$judge=null){
        $sql="";
        foreach ($ids as $key => $id) {
            # code...
            if($key==0)
                $sql.="".$id." ";
            else
                $sql.=",".$id."";

        }
        $result=Problem::whereIn('id',$ids)->orderByRaw(DB::raw('FIELD(id,'.$sql.')'))->paginate(9);
        //echo $sql;
        return $result;
    }


}

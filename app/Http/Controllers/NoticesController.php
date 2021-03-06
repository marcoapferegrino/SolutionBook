<?php
namespace SolutionBook\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psy\Exception\ErrorException;
use SolutionBook\Entities\Files;
use SolutionBook\Entities\Notice;
use SolutionBook\Entities\Warning;
use SolutionBook\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\QueryException;
use SolutionBook\Http\Requests\AddNoticeRequest;
use SolutionBook\Http\Requests\UpdateNoticeRequest;

class NoticesController extends Controller
{
    //
    public function getAddNotice()
    {
        return view('super.addNotice');
    }
    public function oneNotice($id)
    {

        try{
            $notice = Notice::getOneNoticeWithFiles($id);
            $tam= getimagesize($notice[0]->path);
            if($tam[0]>$tam[1]){
                $tam='largo';
            }
            else{
                $tam='ancho';
            }
            // dd($tam);
        }
        catch(\Exception $e){
           // dd('no hay noticia');
           return view('errors.404');
        }
        $gallery=Files::getGallery($id);
        return view('forEverybody.oneNotice',compact('notice','tam','gallery'));
    }
    public function getNotices()
    {
        $notices = Notice::getNoticesWithFiles();
        //$files=Notice::getFiles();
        $images=Notice::getGallery();

        return view('super.notices',compact('notices','images'));
    }
    public function addNotice(AddNoticeRequest $request)
    {
        $notice = Notice::create(
            array('title'=>$request->title,
                'description'=>$request->description,
                'finishDate'=>$request->finishDate,
                'user_id'=>auth()->user()->id));
        $fileImg      = $request->file('file');
        $gallery      = $request->file('gallery');
        if($fileImg==null){
            $fileImg      = 'default.jpg';
        }
        $idUser = auth()->user()->id;
        $path ='users/'.$idUser.'/';
        $pathFile = $path.'notices/'.$notice->id.'/';
        mkdir($pathFile,0775, true);///////imagenes
        if($fileImg!='default.jpg'){
            $nameFile = $fileImg->getClientOriginalName();
        }
        else{
            $nameFile =$fileImg;
        }
        $file = Files::create([
            'name' => $nameFile,
            'path' => $pathFile.$nameFile,
            'type' =>'imagenApoyo',
            'notice_id'=>$notice->id,
        ]);
        $file->save();
        if($nameFile=='default.jpg'){
            copy($nameFile,$pathFile.$nameFile);
        }
        else{
            $fileImg->move($pathFile,$nameFile);
        }
        ///////////////////////////////////////archivos
        $apoyo       = $request->file('apoyo');
        if($apoyo[0]!=null){
            $pathApoyo=$pathFile.'docs/';
            foreach($apoyo as $fileA){
                try {
                    $nameApoyo = $fileA->getClientOriginalName();
                    $ext=$fileA->guessExtension() ;  //getOriginalExtension()
                    $type='';
                    if($ext=='jpg'||$ext=='bmp'||$ext=='png'||$ext=='jpeg'){
                        $type='imagenApoyo';
                    }elseif(($ext=='mp3'||$ext=='wav'||$ext=='mpga')){
                        $type='notaVoz';
                    }elseif(($ext=='pdf')){
                        $type='pdf';
                    }elseif(($ext=='doc'||$ext=='docx'||$ext=='zip'||$ext=='txt')){
                        $type='word';
                    }
                    $fileApoyo= Files::create([
                        'name' => $nameApoyo,
                        'path' => $pathApoyo.$nameApoyo,
                        'type' => $type,
                        'notice_id'=>$notice->id,
                    ]);
                    $fileApoyo->save();
                } catch (ErrorException $e) {
                    Session::flash('error', 'No se pudo guardar ');
                }
                try {
                    //dd($pathApoyo,$nameApoyo);
                    $fileA->move($pathApoyo,$nameApoyo);
                } catch (ErrorException $e) {
                    Session::flash('error', 'No se pudo mover ');
                }
            }
        }

        if($gallery[0]!=null){

            $pathApoyo=$pathFile.'docs/';
            foreach($gallery as $fileGallery){
                $imgGallery=null;
                $nameGallery = null;
                try {
                    $nameGallery = $fileGallery->getClientOriginalName();
                    $type='imagenGallery';
                    $imgGallery= Files::create([
                        'name' => $nameGallery,
                        'path' => $pathApoyo.$nameGallery,
                        'type' => $type,
                        'notice_id'=>$notice->id,
                    ]);

                   // dd($imgGallery);
                    $imgGallery->save();
                } catch (ErrorException $ee) {
                    Session::flash('error', 'No se pudo guardar ');
                }
                try {
                  //  dd($pathApoyo,$nameApoyo);

                    $fileGallery->move($pathApoyo,$nameGallery);

                } catch (ErrorException $ee) {
                    Session::flash('error', 'No se pudo mover ');
                }
            }

        }
        Session::flash('message', 'Noticia  agregada y publicada con éxito');//msg11
        //return redirect()->action('HomeController@indexAdmin');
        return redirect()->action('NoticesController@oneNotice',$notice->id);
    }
    public function deleteNotice($id)
    {
        $notice = Notice::findOrFail($id);
        try
        {
            $files=Files::where('notice_id',$notice->id)->get()->all();
            $pathEraser = $files[0]->path;
            $pathEraser=strrev ($pathEraser );
            $aux='';
            $explode= str_split($pathEraser);
            $flag=0;
            foreach($explode as $ind=>$letter) {
                if ($letter == '/' || $letter == '\\'||$flag==1) {
                    $flag=1;
                    $aux = $aux.$letter;
                }
            }
            foreach($files as $i=>$file){
                $realFile=Files::find($file['id']);
                if($realFile->path!=null){
                    unlink($realFile->path);
                }
                $file->delete();
            }
            try{
                if(is_dir(strrev ($aux ).'docs')){
                    rmdir(strrev ($aux ).'docs');
                }
            }
            catch(ErrorException $e){
            } try{
            $notice->delete();
        }
        catch(ErrorException $e){
        } try{
            rmdir(strrev ($aux ));
        }
        catch(ErrorException $e){
        }
            Session::flash('message', 'Se ha eliminado correctamente la noticia');//msg09
        }
        catch(QueryException $e)
        {
            Session::flash('message', 'No se elimino la noticia');
        }
        return redirect()->action('NoticesController@getNotices');
    }
    public function updateNotice(UpdateNoticeRequest $request)
    {
        $fileImg      = $request->file('file');
        $apoyo        =  $request->file('apoyo');

        $imgsDelete= $request->imgsDelete;
        $idUser = auth()->user()->id;
        $gallery      = $request->file('gallery');
        $notice = Notice::find($request->id);
        $notice->title      = $request->title;
        $notice->description= $request->description;
        $notice->finishDate = $request->finishDate;
        $notice->save();
        if($imgsDelete!=null){
            foreach ($request->imgsDelete as $img ) {
                $file = Files::find($img);
                unlink($file->path);
                $file->delete();
            }
        }

        if($fileImg!=null)
        {
            $file=Files::where('notice_id',$notice->id)->get()->all();
            //   dd($file);
            if($file!=null){
                $realFile=Files::find($file[0]['id']);

                if($realFile->path!=null&& $realFile->type!='imagenGallery'){
                    unlink($realFile->path);

                }
                $nameFile = $fileImg->getClientOriginalName();
                $idUser = auth()->user()->id;
                $path ='users/'.$idUser.'/';
                $pathFile = $path.'notices/'.$notice->id.'/';
                $realFile->name=$nameFile;
                $realFile->path=$pathFile.$nameFile;
                $fileImg->move($pathFile,$nameFile);
                $realFile->save();
            }
            else{
                $nameFile = $fileImg->getClientOriginalName();
                $idUser = auth()->user()->id;
                $path ='users/'.$idUser.'/';
                $pathFile = $path.'notices/'.$notice->id.'/';
                $file = Files::create([
                    'name' => $nameFile,
                    'path' => $pathFile.$nameFile,
                    'type' =>'imagenApoyo',
                    'notice_id'=>$notice->id,
                ]);
                $file->save();
                $fileImg->move($pathFile,$nameFile);
            }
        }
        if($apoyo[0]!=null)
        {
            $files=Files::where('notice_id',$notice->id)->get()->all();
            foreach($files as $i=>$file){
                if($i!=0&& $file->type!='imagenGallery'){
                    $realFile=Files::find($file['id']);
                    if($realFile->path!=null){
                        unlink($realFile->path);
                    }
                    $file->delete();
                }
            }
            /////////////
            ///////////////////////////////////////archivos
            $apoyo       = $request->file('apoyo');
            $idUser = auth()->user()->id;
            $path ='users/'.$idUser.'/';
            $pathFile = $path.'notices/'.$notice->id.'/';
            if($apoyo[0]!=null){
                $pathApoyo=$pathFile.'docs/';
                foreach($apoyo as $fileA){
                    try {
                        $nameApoyo = $fileA->getClientOriginalName();
                        $ext=$fileA->guessExtension() ;
                        $type='';
                        if($ext=='jpg'||$ext=='bmp'||$ext=='png'||$ext=='jpeg'){
                            $type='imagenApoyo';
                        }elseif(($ext=='mp3'||$ext=='wav'||$ext=='mpga')){
                            $type='notaVoz';
                        }elseif(($ext=='pdf')){
                            $type='pdf';
                        }elseif(($ext=='doc'||$ext=='docx'||$ext=='txt'||$ext=='zip')){
                            $type='word';
                        }
                        $fileApoyo= Files::create([
                            'name' => $nameApoyo,
                            'path' => $pathApoyo.$nameApoyo,
                            'type' => $type,
                            'notice_id'=>$notice->id,
                        ]);
                        $fileApoyo->save();
                    } catch (Exception $e) {
                        Session::flash('error', 'no se pudo gruardar ');
                    }
                    try {
                        $fileA->move($pathApoyo,$nameApoyo);
                    } catch (Exception $e) {
                        Session::flash('error', 'No se pudo mover ');
                    }
                }
            }
            //////////////
        }
        $path ='users/'.$idUser.'/';
        $pathFile = $path.'notices/'.$notice->id.'/';
        ///////////////////gallery
        if($gallery[0]!=null){

            //$files=Files::where('notice_id',$notice->id)->where('type','imagenGallery')->get()->all();
            /*
            foreach($files as $i=>$file){

                    $realFile=Files::find($file['id']);
                    if($realFile->path!=null){
                        unlink($realFile->path);
                    }
                    $file->delete();

            }*/



            $pathApoyo=$pathFile.'docs/';
            foreach($gallery as $fileGallery){
                $imgGallery=null;
                $nameGallery = null;
                try {
                    $nameGallery = $fileGallery->getClientOriginalName();
                    $type='imagenGallery';
                    $imgGallery= Files::create([
                        'name' => $nameGallery,
                        'path' => $pathApoyo.$nameGallery,
                        'type' => $type,
                        'notice_id'=>$notice->id,
                    ]);

                    // dd($imgGallery);
                    $imgGallery->save();
                } catch (ErrorException $ee) {
                    Session::flash('error', 'No se pudo guardar ');
                }
                try {
                    //  dd($pathApoyo,$nameApoyo);

                    $fileGallery->move($pathApoyo,$nameGallery);

                } catch (ErrorException $ee) {
                    Session::flash('error', 'No se pudo mover ');
                }
            }

        }



        Session::flash('message','Cambios guardados'); //Msg08
        return redirect()->action('NoticesController@getNotices');
    }
}
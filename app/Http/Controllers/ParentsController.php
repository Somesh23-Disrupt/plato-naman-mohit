<?php

namespace App\Http\Controllers;
use \App;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Quiz;
use Yajra\Datatables\Datatables;
use DB;


class ParentsController extends Controller
{
     public function __construct()
    {
         $currentUser = \Auth::user();
      
      
      $this->middleware('auth');
    
    }
    
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
     public function index()
     {
       
       $user = getUserWithSlug();

      if(!checkRole(getUserGrade(7)))
      {
        prepareBlockUserMessage();
        return back();
      }

       if(!isEligible($user->slug))
        return back();
 
       $data['records']      = FALSE;
       $data['user']       = $user;
       $data['title']        = getPhrase('children');
       $data['active_class'] = 'children';
       $data['layout']       = getLayout();
       // return view('parent.list-users', $data);

        $view_name = getTheme().'::parent.list-users';
        return view($view_name, $data);     
     }

     /**
     * This method returns the datatables data to view
     * @return [type] [description]
     */
    
    public function getDatatable($slug)
    {
        $records = array();
        $user = getUserWithSlug($slug);
        
        $records = User::select(['name', 'email', 'image', 'slug', 'id','department','inst_name'])->where('parent_id', '=', $user->id)->get();
            


        return Datatables::of($records)
        ->addColumn('action', function ($records) {
         $buy_package = '';
        
          if(!isSubscribed('main',$records->slug)==1)
           // $buy_package =    '<li><a href="'.URL_SUBSCRIBE.$records->slug.'"><i class="fa fa-credit-card"></i>'.getPhrase("buy_package").'</a></li>';


            return '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                           <li><a href="'.URL_USERS_EDIT.$records->slug.'"><i class="fa fa-pencil"></i>'.getPhrase("edit").'</a></li>

                        </ul>
                    </div>';
            })
            
         ->editColumn('name', function($records)
         {
          return '<a href="'.URL_USER_DETAILS.$records->slug.'" title="'.$records->name.'">'.ucfirst($records->name).'</a>';
         })       
         ->editColumn('image', function($records){
            return '<img src="'.getProfilePath($records->image).'"  />';
        })
         ->removeColumn('slug')
         ->removeColumn('id')

        ->make();
    }

    public function childrenAnalysis()
    {
       
       $user = getUserWithSlug();

      if(!checkRole(getUserGrade(7)))
      {
        prepareBlockUserMessage();
        return back();
      }

       if(!isEligible($user->slug))
        return back();
 
       $data['records']      = FALSE;
       $data['user']       = $user;
       $data['title']        = getPhrase('children_analysis');
       $data['active_class'] = 'analysis';
       $data['layout']       = getLayout();
       // return view('parent.list-users', $data);

        $view_name = getTheme().'::parent.list-users';
        return view($view_name, $data);     
    }
    public function childdash($slug='')
    {       
          
            if(!checkRole(getUserGrade(8)))
            {
              prepareBlockUserMessage();
              return back();
            }
            
            $user=App\User::where('slug',$slug)->first();
            if(!(auth()->user()->id==$user->parent_id))
            {
              prepareBlockUserMessage();
              return back();
            }
           
            $i=0;
            
            $data['chart_data']= $this->getstudents($user);
            $data['total_marks']=0;
            $data['title']=$user->name;
            //Overall performance Report
            $resultObject = new App\QuizResult();
            $records = Quiz::join('quizresults', 'quizzes.id', '=', 'quizresults.quiz_id')
            ->select(['quiz_id', 'quizzes.title',DB::raw('Max(percentage) as percentage'), 'quizresults.user_id','quizresults.total_marks','marks_obtained','category_id'])
            ->where('quizresults.user_id', '=', $user->id)
            ->groupBy('quizresults.quiz_id')

            ->get();
            $data['tables']=$records;
            // dd($data['tables']);
            $childs=App\User::where('parent_id',10)->get();
            foreach ($childs as $child) {
             
              $name[]=$child->slug;

            }
            $data['slugs']=$name;
            foreach($data['chart_data'][3]->data->dataset as $tm)
            {
              $data['total_marks']=$data['total_marks']+$tm;
              $i=$i+1;
            }
            if($data['total_marks']==0){
              $data['avgscore']=0;
            }
            else{
              $data['avgscore']= $data['total_marks']/$i;
            }
            $data['active_class']='dashboard';
            $data['child_id']=$user->id;
            // dd($data['child_id']);
            $data['examattend']=count($data['chart_data'][3]->data->dataset);
            $data['passpercent']=$this->totalpass($user);
            // dd($data['passpercent']);
            $view_name = getTheme().'::parent.child';
            return view($view_name, $data);
    }

    public function getstudents($user)
    {
      //Overall performance Report
      $resultObject = new App\QuizResult();
      $records = $resultObject->getOverallSubjectsReport($user);
      $color_correct          = getColor('background', rand(0,999));
      $color_wrong            = getColor('background', rand(0,999));
      $color_not_attempted    = getColor('background', rand(0,999)); 
      $correct_answers        = 0;
      $wrong_answers          = 0;
      $not_answered           = 0;

      foreach($records as $record) {
          $record = (object)$record;
          $correct_answers    += $record->correct_answers;
          $wrong_answers      += $record->wrong_answers;
          $not_answered       += $record->not_answered;

     } 

      $labels = [getPhrase('correct'), getPhrase('wrong'), getPhrase('not_answered')];
      $dataset = [$correct_answers, $wrong_answers, $not_answered];
      $dataset_label[] = 'lbl';
      $bgcolor  = [$color_correct,$color_wrong,$color_not_attempted];
      $border_color = [$color_correct,$color_wrong,$color_not_attempted];
      $chart_data['type'] = 'pie'; 
      //horizontalBar, bar, polarArea, line, doughnut, pie
      $chart_data['title'] = getphrase('overall_performance');  

      $chart_data['data']   = (object) array(
              'labels'            => $labels,
              'dataset'           => $dataset,
              'dataset_label'     => $dataset_label,
              'bgcolor'           => $bgcolor,
              'border_color'      => $border_color
              );
        
        $data['chart_data'][]=(object)$chart_data;

      //Best
      //Overall performance Report
      $resultObject = new App\QuizResult();
      $records = $resultObject->getOverallQuizPerformance($user);
            $labels = [];
            $dataset = [];
            $bgcolor = [];
            $bordercolor = [];
            
            foreach($records as $record) {
                $color_number = rand(0,999);
                $record = (object)$record;
                $labels[] = $record->title;
                $dataset[] = $record->percentage;
                $bgcolor[] = getColor('background',$color_number);
                $bordercolor[] = getColor('border', $color_number);
           } 

            $labels = $labels;
            $dataset = $dataset;
            $dataset_label = getPhrase('performance').' in %';
            $bgcolor  = $bgcolor;
            $border_color = $bordercolor;
            $chart_data['type'] = 'bar'; 
            //horizontalBar, bar, polarArea, line, doughnut, pie
            $chart_data['title'] = getPhrase('best_performance_in_all_quizzes');

            $chart_data['data']   = (object) array(
                    'labels'            => $labels,
                    'dataset'           => $dataset,
                    'dataset_label'     => $dataset_label,
                    'bgcolor'           => $bgcolor,
                    'border_color'      => $border_color
                    );
                    
                    
              $data['chart_data'][]=(object)$chart_data;

             // Chart code start
             $records = array();
             $labels = [];
             $dataset = [];
             $bgcolor = [];
             $bordercolor = [];
             
             $records = Quiz::join('quizresults', 'quizzes.id', '=', 'quizresults.quiz_id')
                 ->select(['title','is_paid' ,'dueration', 'quizzes.total_marks',  \DB::raw('count(quizresults.user_id) as attempts, quizzes.slug, user_id') ])
                 ->where('user_id', '=', $user->id)
                 ->groupBy('quizresults.quiz_id')
                 ->get();
           
             $chartSettings = new App\ChartSettings();
 
             $dataset_label = getPhrase('attempts');
             foreach($records as $record) {
                 $color_number = rand(0,999);
                 $record = (object)$record;
                 $labels[] = $record->title;
                 $dataset[] = $record->attempts;
                 $bgcolor[] = getColor('background',$color_number);
                 $bordercolor[] = getColor('border', $color_number);
            }
 
             $chart_data['type'] = 'bar'; 
             //horizontalBar, bar, polarArea, line, doughnut, pie
             $chart_data['title'] = getPhrase('exam_analysis_by_attempts'); 
             $chart_data['data']   = (object) array(
                 'labels'            => $labels,
                 'dataset'           => $dataset,
                 'dataset_label'     => $dataset_label,
                 'bgcolor'           => $bgcolor,
                 'border_color'      => $bordercolor
                 );
 
                 $data['chart_data'][]=(object)$chart_data;



             $records = array();
                $labels = [];
                $dataset = [];
                $bgcolor = [];
                $bordercolor = [];
                $records = Quiz::join('quizresults', 'quizzes.id', '=', 'quizresults.quiz_id')
                    ->select(['title','is_paid' ,'dueration', 'quizresults.marks_obtained as total_marks',  \DB::raw('count(quizresults.user_id) as attempts, quizzes.slug, user_id') ])
                    ->where('user_id', '=', $user->id)
                    ->groupBy('quizresults.quiz_id')
                    ->get();
              
                $chartSettings = new App\ChartSettings();

                $dataset_label = getPhrase('Marks');
                foreach($records as $record) {
                    $color_number = rand(0,999);
                    $record = (object)$record;
                    $labels[] = $record->title;
                    $dataset[] = $record->total_marks;
                    $bgcolor[] = getColor('background',$color_number);
                    $bordercolor[] = getColor('border', $color_number);
                }

                $chart_data['type'] = 'bar'; 
                //horizontalBar, bar, polarArea, line, doughnut, pie
                $chart_data['title'] = getPhrase('exam_analysis_by_total_marks'); 
                $chart_data['data']   = (object) array(
                    'labels'            => $labels,
                    'dataset'           => $dataset,
                    'dataset_label'     => $dataset_label,
                    'bgcolor'           => $bgcolor,
                    'border_color'      => $bordercolor
                    );
                    $data['chart_data'][]=(object)$chart_data;

              return $data['chart_data'];


    }
    public function totalpass($user)
    {
      
      
        $user=$user;
      
        $tpp=[];
      
          $records = Quiz::join('quizresults', 'quizzes.id', '=', 'quizresults.quiz_id')
            ->select(['exam_status' ])
            ->where('user_id', '=', $user->id)
            ->groupBy('quizresults.quiz_id')
            ->get();
          $pass=0;
          foreach ($records as $record) {
            if($record->exam_status=='pass'){
              $pass=$pass+1;
            }
          }
          if($pass>0){
            $data['passpercent']=round(($pass/$records->count())*100,2);
          }
          else{
            $data['passpercent']=0;
          }  
          $tpp[$user->name]=$data['passpercent'];
     
      
      return $tpp;
    }
    
}

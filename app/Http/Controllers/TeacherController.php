<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App;
use App\Http\Requests;
use App\User;
use App\Quiz;
use Illuminate\Support\Str;
use App\FaqCategory;
use App\Institution;
use App\GeneralSettings as Settings;
use Image;
use ImageSettings;
use Yajra\Datatables\Datatables;
use DB;
use Illuminate\Support\Facades\Hash;
use Excel;
use Input;
use File;
use App\OneSignalApp;
use Exception;

class TeacherController extends Controller
{

  public $excel_data = array();
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
     public function toplist()
     {
        
        $data['records']      = App\ExamTopper::where('percentage', '>=', 50)->get();
        $data['layout']      = getLayout();
        $data['active_class'] = 'users';
        $data['heading']      = getPhrase('toplist');
        $data['title']        = getPhrase('toplist');
            $no=0;
           $data['chart_data']=[];
          if (checkRole(['owner'])) {
              $users=App\User::where('role_id',5)->get();
          }else{
            $users=App\User::where('inst_id',auth()->user()->inst_id)->where('role_id',5)->get();
          }
          $pass=[];
          foreach ($users as $user) {
            $data['chart_data'][]=(object)$this->topper($user);
          }
            foreach($data['chart_data'] as $d){
              $no=$d->data->percent;
              if ($no>=90) {
                $pass[]=$d->data->id;
              }
            }   
            foreach($data['chart_data'] as $d){
              $no=$d->data->percent;
                if(count($pass)<10){
                  if ($no>=50) {
                    $pass[]=$d->data->id;
                  }
                }
              }
            
          $data['records']      = App\User::whereIn('id', $pass)->get();
          
        // return view('users.list-users', $data);
                 $view_name = getTheme().'::teacher.list';
        return view($view_name, $data);
     }
     public function passlist($role = 'teacher')
     {
      
            $no=0;
            $data['chart_data']=[];
          if (checkRole(['owner'])) {
              $users=App\User::where('role_id',5)->get();
          }else{
            $users=App\User::where('inst_id',auth()->user()->inst_id)->where('role_id',5)->get();
          }
          $pass=[];
          foreach ($users as $user) {
            $data['chart_data'][]=(object)$this->topper($user);
          }
            foreach($data['chart_data'] as $d){
              $no=$d->data->percent;
              if ($no>=50) {
                $pass[]=$d->data->id;
              }
            }   
          
          $data['records']      = App\User::whereIn('id', $pass)->get();
        
        $data['layout']      = getLayout();
        $data['active_class'] = 'users';
        $data['heading']      = getPhrase('passlist');
        $data['title']        = getPhrase('passlist');
        // return view('users.list-users', $data);
                 $view_name = getTheme().'::teacher.list';
        return view($view_name, $data);
     }
     public function faqs()
     {
        
        if(checkRole(['parent'])){
          $childs=App\User::where('parent_id',auth()->user()->id)->get();
              foreach ($childs as $child) {
              
                $name[]=$child->slug;

              }
              $data['slugs']=$name;
         }
        $data['active_class']       = 'faqs';
        $data['title']              = getPhrase('faqs');
        $data['layout']=getLayout();
        
        $categories = FaqCategory::where('status',1)->get();
        $data['categories'] = $categories;
        
        // return view('site.faqs',$data);
        $view_name = getTheme().'::teacher.faqs';
        return view($view_name, $data);
     }

     public function topper($user)
     {
          $user =$user;
          //Overall performance Report
          $dataset=0;
          $i=0;
          $resultObject = new App\QuizResult();
          $records = $resultObject->getOverallQuizPerformance($user);
          foreach($records as $record) {
            $record = (object)$record;
            $i++;
            $dataset = $record->percentage+$dataset;
            } 
          if ($dataset>0) {
              $dataset=$dataset/$i;
          }else{
            $dataset=$dataset;
          }
          
          $chart_data['data']   = (object) array(
            'id'=>$user->id,
            'percent'=>round($dataset,0),
             
            );
           
          return $chart_data;
     }


      public function secdetails($slug)
      {

              
        // dd($slug);
            if(!checkRole(getUserGrade(6)))
            {
              prepareBlockUserMessage();
              return back();
            }
            if ( strval($slug) !== strval(intval($slug)) ) {
              prepareBlockUserMessage();
              return redirect("dashboard");
            }
            $teachsec=auth()->user()->section_name;
            $len=strlen($teachsec);
            // dd(Str::limit($teachsec,2));
            $slugstr=App\User::select(['section_name'])->where('section_id',$slug)->first()->section_name;
            
            // dd(Str::limit($slugstr,2));
            // dd(!(Str::limit($slugstr,2)==$teachgrade));
            if ($len==3) {
              $teachgrade=Str::limit($teachsec,2);
              if (!(Str::limit($slugstr,2)==$teachgrade)) {
                prepareBlockUserMessage();
                return redirect("dashboard");
              }
            }elseif($len==2){
              $teachgrade=Str::limit($teachsec,1);
              if (!(Str::limit($slugstr,1)==$teachgrade)) {
                prepareBlockUserMessage();
                return redirect("dashboard");
              }
            }else{
                prepareBlockUserMessage();
                return redirect("dashboard");
            }
              $userbyinst=App\User::where('inst_id',auth()->user()->inst_id)->where('section_id',$slug)->where('role_id',5)->pluck('id');
                    
                    
              $records = Quiz::join('quizresults', 'quizzes.id', '=', 'quizresults.quiz_id')->where('exam_status','pass')->whereIn('user_id',$userbyinst)
                ->select(['quiz_id', 'quizzes.category_id','quizzes.total_marks','quizzes.title','quizresults.exam_status',DB::raw('count("") as tp'),DB::raw('round(avg(marks_obtained),2) as avgmarks'), 'quizresults.user_id'])
              ->groupBy('quizresults.quiz_id')
              ->get();
              $data['tables']=$records;


           //all pass students accross quizes

                  
           $dataset = [];
           $labels = [];
           $bgcolor = [];
           $border_color = [];
           $test=['rgba(196, 219, 250, 1)','rgba(52, 132, 240, 1)','rgba(70, 75, 147, 1)'];
           foreach($records as $record)
           {
               $color_number = rand(0,999);
               $labels[] = ucfirst($record->title);
               $dataset[] = $record->tp;

               $border_color[] = 'rgb(247,247,247)';
           }
           for ($i=0; $i < 3; $i++) {
             $bgcolor[] = $test[$i];
           }

           
           $dataset_label[] = 'lbl';
           $chart_data['type'] = 'pie';
           //horizontalBar, bar, polarArea, line, doughnut, pie
           $chart_data['data']   = (object) array(
                   'labels'            => $labels,
                   'dataset'           => $dataset,
                   'dataset_label'     => $dataset_label,
                   'bgcolor'           => $bgcolor,
                   'border_color'      => $border_color
                   );
         
                   $chart_data['title'] = getPhrase('Overall Performance');
                 $data['chart_data'][] = (object)$chart_data;



                   //chart
                    $labels = [];
                    $dataset = [];
                    $bgcolor = [];
                    $bordercolor = [];
                   
                      
                    // dd($userbyinst);
                    $records = Quiz::join('quizresults', 'quizzes.id', '=', 'quizresults.quiz_id')
                          ->select(['quiz_id', 'quizzes.title',DB::raw('Avg(percentage) as percentage'), 'quizresults.user_id'])
                          ->groupBy('quizzes.title')
                          ->whereIn('user_id',$userbyinst)
                          ->get();
                    
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
                    $dataset_label = getPhrase('avg_percent');
                    $bgcolor  = $bgcolor;
                    $border_color = $bordercolor;
                    $chart_data['type'] = 'bar';
                    //horizontalBar, bar, polarArea, line, doughnut, pie
                    $chart_data['title'] = getPhrase('Avg. Percent across Subjects');

                    $chart_data['data']   = (object) array(
                            'labels'            => $labels,
                            'dataset'           => $dataset,
                            'dataset_label'     => $dataset_label,
                            'bgcolor'           => $bgcolor,
                            'border_color'      => $border_color
                            );
                            
                    $data['chart_data'][] = (object)$chart_data;



                    $labels = [];
                    $dataset = [];
                    $bgcolor = [];
                    $bordercolor = [];
                    
                    
                    
                    // dd($userbyinst);
                    $records = Quiz::join('quizresults', 'quizzes.id', '=', 'quizresults.quiz_id')
                          ->select(['quiz_id', 'quizzes.title',DB::raw('Avg(marks_obtained) as percentage'), 'quizresults.user_id'])
                          ->groupBy('quizzes.title')
                          ->whereIn('user_id',$userbyinst)
                          ->get();
                    
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
                    $dataset_label = getPhrase('avg_marks');
                    $bgcolor  = $bgcolor;
                    $border_color = $bordercolor;
                    $chart_data['type'] = 'bar';
                    //horizontalBar, bar, polarArea, line, doughnut, pie
                    $chart_data['title'] = getPhrase('Avg. Marks across Subjects');

                    $chart_data['data']   = (object) array(
                            'labels'            => $labels,
                            'dataset'           => $dataset,
                            'dataset_label'     => $dataset_label,
                            'bgcolor'           => $bgcolor,
                            'border_color'      => $border_color
                            );
                      $data['chart_data'][] = (object)$chart_data;


              $sections=App\User::select(['section_id'])->where('role_id',5)->where('inst_id',auth()->user()->inst_id)->distinct()->pluck('section_id');
              // dd($sections);
              $data['sections']= $sections;
        
              $data['title']=App\User::select(['section_name'])->where('section_id',$slug)->first()->section_name;
              $data['active_class']       = 'section';
              
              $view_name = getTheme().'::teacher.sec-detail';
              return view($view_name, $data);

      }

}

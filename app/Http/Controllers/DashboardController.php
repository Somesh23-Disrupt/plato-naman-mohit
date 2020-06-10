<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App;
use Auth;
use App\User;
use App\Institution;
use App\Quiz;
use SMS;
use DB;
use Artisan;

// use Illuminate\Support\Facades\App;

class DashboardController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function index()
    {
        $data['active_class']   = 'dashboard';
        /**
         * Check the role of user
         * Redirect the user as per the eligiblity
         */

        $user = getUserRecord();
        $data['layout']         = getLayout();
        $data['title']          = getPhrase('dashboard');
        $role = getRole();
        if ($role=='admin') {

              Artisan::call('view:clear');

              $tnps=0;
              $data['tppforteach']=0;
              $data['passpercent']=$this->totalpass();
              // dd($data['passpercent']);
              foreach ($data['passpercent'] as $per) {
                // dd($per);
                $data['tppforteach']=$per['per']+$data['tppforteach'];

              }
              // dd($data['tppforteach']);
              if ($data['tppforteach']>0) {
                $data['tppforteach']=round($data['tppforteach']/count($data['passpercent']),2);
                // dd($data['tppforteach']);
              }
              else{
                $data['tppforteach']=0;
              }
             $roles = App\Role::whereNotIn('id',[1,2,6])->get()->pluck('id');
             $dataset = [];
             $labels = [];
             $bgcolor = [];
             $border_color = [];
             $test=['rgba(196, 219, 250, 1)','rgba(52, 132, 240, 1)','rgba(70, 75, 147, 1)'];
             foreach($roles as $key => $value)
             {
                $color_number = rand(0,999);
                $labels[] = ucfirst(getRoleData($value));
                $dataset[] = App\User::where('role_id', '=', $value)->where('inst_id',auth()->user()->inst_id)->get()->count();

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
           
                    $chart_data['title'] = getPhrase('User Statistics');
           $data['chart_data'][] = (object)$chart_data;
           
           $data['chart_heading']         = getPhrase('user_statistics');
            $avgscacrquizes=0;
           $data['payments_chart_data'] = (object)$this->getPaymentStats();
          //  dd($data['payments_chart_data']->data->dataset);
           foreach($data['payments_chart_data']->data->dataset as $d){
             $avgscacrquizes=$d+$avgscacrquizes;
           }
           if (count($data['payments_chart_data']->data->dataset)>0) {
             
           $data['avgscacrquizes']=$avgscacrquizes/count($data['payments_chart_data']->data->dataset);
          }else{
            $data['avgscacrquizes']=0;
          }
          //  $data['payments_monthly_data'] = (object)$this->getPaymentMonthlyStats();
          //  $data['demanding_quizzes'] = (object)$this->getDemandingQuizzes();
          //  $data['demanding_paid_quizzes'] = (object)$this->getDemandingQuizzes('paid');
           $data['layout']        = getLayout();
            $data['right_bar_data']     = array('chart_data' => $data['chart_data'] );
           $data['ids'] = array('myChart0' );
           $data['chart_data'][]=(object)$this->scorebysub();
           //Code Table in Admin dashboard

           $sec_inst=App\User::select(['section_id'])->where('role_id',3)->where('inst_id',auth()->user()->inst_id)->distinct()->pluck('section_id');
          //  dd($sec_inst);
              $records = Quiz::select(['title', 'category_id', 'start_date'])->get()->sortByDesc('start_date');
              $data['tables']=$records;
             
            $view_name = getTheme().'::admin.dashboard';

            return view($view_name, $data);
        }
        if ($role=='owner') {

              Artisan::call('view:clear');

            $roles = App\Role::whereNotIn('id',[1])->pluck('id');
            $dataset = [];
            $labels = [];
            $bgcolor = [];
            $border_color = [];
            $test=['rgba(196, 219, 250, 1)','rgba(52, 132, 240, 1)','rgba(41, 75, 147, 1)'];
            foreach($roles as $key => $value)
            {
                $color_number = rand(0,999);
                $labels[] = ucfirst(getRoleData($value));
                $dataset[] = App\User::where('role_id', '=', $value)->get()->count();

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

              $data['chart_data'][] = (object)$chart_data;
              $data['chart_heading']         = getPhrase('user_statistics');
              $data['demanding_quizzes'] = (object)$this->getDemandingQuizzes();
              $data['demanding_paid_quizzes'] = (object)$this->getDemandingQuizzes('paid');

                $data['layout']        = getLayout();

            //   $data['right_bar']          = FALSE;

            // $data['right_bar_path']     = 'common.right-bar-chart';
            $data['right_bar_data']     = array('chart_data' => $data['chart_data'] );
                $data['ids'] = array('myChart0' );

                $institution=Institution::select(['institution_name','id'])->get();
                $data['institutions']=$institution;



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

                // return view('admin.dashboard', $data);


            $view_name = getTheme().'::owner.dashboard';

            return view($view_name, $data);
        }
        else if ($role=='teacher') {
              Artisan::call('view:clear');


              $data['tppforteach']=0;
              $tnps=0;
              $data['passpercent']=$this->totalpass();
              // dd($data['passpercent']);
              foreach ($data['passpercent'] as $per) {
                
                if ($per['per']>=50) {
                  $tnps=$tnps+1;
                }
                $data['tppforteach']=$per['per']+$data['tppforteach'];
              }
              if ($data['tppforteach']>0) {
                $data['tppforteach']=round($tnps/count($data['passpercent'])*100,2);
              }
              else{
                $data['tppforteach']=0;
              }
              $data['tnps']=$tnps;
              $data['avg']= $this->gettingavgscore()->avg;
              $data['avgsection']=getUserWithSlug()->section_name;
//Going to work on table in teachers dashboard
              $stdbysec=App\User::where('section_id',auth()->user()->section_id)->where('role_id',5)->pluck('id');
              $records = Quiz::join('quizresults', 'quizzes.id', '=', 'quizresults.quiz_id')->where('exam_status','pass')->whereIN('user_id',$stdbysec)
                ->select(['quiz_id', 'quizzes.category_id','quizzes.total_marks','quizzes.title','quizresults.exam_status',DB::raw('count("") as tp'),DB::raw('round(avg(marks_obtained),2) as avgmarks'), 'quizresults.user_id'])
              ->groupBy('quizresults.quiz_id')
              ->get();
              $data['tables']=$records;


              // return view('admin.dashboard', $data);
              //dd(App\User::where('teacher_id', '=', $user->id)->get());
              // $data['chart_data']=$this->getstudents();
              
              $data['chart_data'][]=(object)$this->scorebysub();
              $data['chart_data'][]=(object)$this->marksbysub();



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
              
          
                $sections=App\User::select(['section_id'])->where('role_id',5)->where('inst_id',auth()->user()->inst_id)->distinct()->pluck('section_id');
                        // dd($sections);
                        $data['sections']= $sections;
              $view_name = getTheme().'::teacher.dashboard';
              return view($view_name, $data);
        }

         else if($role == 'parent')
        {

            $data['passpercent']=$this->totalpass();
            $data['tnps']= $data['passpercent'];
            $user                   = getUserWithSlug();
            $data['user']           = $user;
            $data['childs_names']=$this->gettingavgscore()->names;
            $data['childs_totals']=$this->gettingavgscore()->totals;
            $data['chart_data']=$this->getstudents();
            $childs=App\User::where('parent_id',10)->get();
            $i=0;
            $name=[];
            $new=[];
            foreach ($childs as $child) {
              $dash[]=(object)$this->examanalysisbytotalmarks($child);
              $t['atemp']=count($dash[$i]->data->dataset);
              $t['name']=$child->name;

              $i++;
              $new[]=$t;
              $name[]=$child->slug;

            }
            $data['slugs']=$name;
            // dd($data['slugs']);
            // dd($new);
            // $data['chart_data'][] = (object)$this->examanalysisbytotalmarks();
            $data['examattends']=$new;
            // dd($data['examattends']);
            $view_name = getTheme().'::parent.dashboard';
            return view($view_name, $data);
        }
        else if($role == 'student' )
        {
            $i=0;
            $data['chart_data'][] = (object)$this->OverallperformanceReport();
            $data['chart_data'][] = (object)$this->bestperformanceinallquizzes();
            $data['chart_data'][] = (object)$this->examanalysisbyattempts();
            $data['chart_data'][] = (object)$this->examanalysisbytotalmarks();
            $data['total_marks']=0;
            $user = Auth::user();
            //Overall performance Report
            $data['passpercent']=$this->totalpass();
            $data['tnps']= $data['passpercent'];
            $data['tnps']=$data['tnps'][0];
            // dd($data['tnps']);
            $resultObject = new App\QuizResult();
            $records = Quiz::join('quizresults', 'quizzes.id', '=', 'quizresults.quiz_id')
            ->select(['quiz_id', 'quizzes.title',DB::raw('Max(percentage) as percentage'), 'quizresults.user_id','quizresults.total_marks','marks_obtained','category_id'])
            ->where('quizresults.user_id', '=', $user->id)
            ->groupBy('quizresults.quiz_id')

            ->get();
            $data['tables']=$records;
            // dd($data['tables']);
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
            $data['user']=$user;
            $data['examattend']=count($data['chart_data'][3]->data->dataset);
           // return view('student.dashboard', $data);
            $view_name = getTheme().'::student.dashboard';
            return view($view_name, $data);
        }

    }

     public function getLatestQuizzes()
    {
        $user = Auth::user();
        $interested_categories      = null;
        if($user->settings)
        {
          $interested_categories =  json_decode($user->settings)->user_preferences;
        }
        $quizzes = [];

        if($interested_categories) {
        if(count($interested_categories->quiz_categories))

        $quizzes         = App\Quiz::whereIn('category_id',
                                          (array) $interested_categories->quiz_categories)
      ->where('start_date','<=', date('Y-m-d'))
      ->where('end_date','>=', date('Y-m-d'))
                                ->orderBy('created_at','desc')
                                ->limit(5)
                                ->get();
        }
        else {
          $quizzes         = App\Quiz::orderBy('created_at','desc')
                                ->limit(5)
                                ->get();
        }

        return $quizzes;
    }

      public function getLatestLmsSeries()
    {
        $user = Auth::user();
        $interested_categories      = null;
        if($user->settings)
        {
          $interested_categories =  json_decode($user->settings)->user_preferences;
        }
        $series = [];

        if($interested_categories) {
        if(count($interested_categories->lms_categories))

        $series         = App\LmsSeries::whereIn('lms_category_id',
                                          (array) $interested_categories->lms_categories)
                                ->orderBy('created_at','desc')
                                ->limit(5)
                                ->get();
        }
        else {
          $series         = App\LmsSeries::orderBy('created_at','desc')
                                ->limit(5)
                                ->get();
        }

        return $series;
    }

   public function getPaymentStats()
    {
        // $paymentObject = new App\Payment();
        //     $payment_data = (object)$paymentObject->getSuccessFailedCount();
            $sections=App\User::select('section_id')->where('inst_id',auth()->user()->inst_id)->where('role_id',5)->distinct('section_id')->get()->pluck('section_id');
            // dd($sections);
             $payment_dataset =[];
             $payment_labels = [];
            
            
            foreach ($sections as $section) {
              // dd($section);
             $percent=0;

              $users=App\User::select(['id','section_name'])->where('inst_id',auth()->user()->inst_id)->where('role_id',5)->where('section_id',$section)->get();
              // dd($users);
              foreach($users as $user){
                $records = Quiz::join('quizresults', 'quizzes.id', '=', 'quizresults.quiz_id')
                ->select(['quiz_id', 'quizzes.title',DB::raw('Max(marks_obtained) as percentage'), 'quizresults.user_id'])
                ->where('quizresults.user_id', '=', $user->id)
                ->groupBy('quizresults.quiz_id')
                ->get();
                // dd($records);
                
                foreach ($records as $record) {
                  $percent=$record->percentage+$percent;
                }
                // dd($percent);
                if($records->count()>0){
                  $percent=$percent/($records->count());
                }
                // dd($percent);
                
                
              }
              // dd($percent);
              $payment_dataset[] = round($percent/(App\User::where('section_id',$section)->where('role_id',5)->get()->count()),2);
              // dd($payment_dataset);
              $payment_labels[] = getPhrase('Class ').$user->section_name;
              
              // dd($payment_dataset);
                
                
                
                
            }
            // dd($payment_labels);
            // $payment_dataset = [$payment_data->success_count, $payment_data->cancelled_count, $payment_data->pending_count];
            // $payment_labels = [getPhrase('success'), getPhrase('cancelled'), getPhrase('pending')];
            $payment_dataset_labels = [getPhrase('total')];

            $payment_bgcolor = ['rgba(41, 75, 147, 1)','rgba(196, 219, 250, 1)','rgba(52, 132, 240, 1)'];
            $payment_border_color = [getColor('background',4),getColor('background',9),getColor('background',18)];

          $payments_stats['data']    = (object) array(
                                        'labels'            => $payment_labels,
                                        'dataset'           => $payment_dataset,
                                        'dataset_label'     => $payment_dataset_labels,
                                        'bgcolor'           => $payment_bgcolor,
                                        'border_color'      => $payment_border_color
                                        );
           $payments_stats['type'] = 'bar';
             $payments_stats['title'] = getPhrase('Total Performance');

           return $payments_stats;
    }
     /**
     * This method returns the overall monthly summary of the payments made with status success
     * @return [type] [description]
     */
    public function getPaymentMonthlyStats()
    {

          $paymentObject = new App\Payment();
            $payment_data = (object)$paymentObject->getSuccessMonthlyData();


            $payment_dataset = [];
            $payment_labels = [];
            $payment_dataset_labels = [getPhrase('total')];
            $payment_bgcolor = [];
            $payment_border_color = [];


            foreach($payment_data as $record)
            {
              $color_number = rand(0,999);;
              $payment_dataset[] = $record->total;
              $payment_labels[]  = $record->month;
              $payment_bgcolor[] = getColor('',$color_number);
              $payment_border_color[] = getColor('background', $color_number);

            }

          $payments_stats['data']    = (object) array(
                                        'labels'            => $payment_labels,
                                        'dataset'           => $payment_dataset,
                                        'dataset_label'     => $payment_dataset_labels,
                                        'bgcolor'           => $payment_bgcolor,
                                        'border_color'      => $payment_border_color
                                        );
           $payments_stats['type'] = 'line';
           $payments_stats['title'] = getPhrase('payments_reports_in').' '.getCurrencyCode();

           return $payments_stats;
    }

    public function getDemandingQuizzes($type='')
    {
      $quizResultObject = new App\QuizResult();
      $usage = $quizResultObject->getQuizzesUsage($type);

        $summary_dataset = [];
            $summary_labels = [];
            $summary_dataset_labels = [getPhrase('total')];
            $summary_bgcolor = [];
            $summary_border_color = [];


            foreach($usage as $record)
            {
              $summary_dataset[] = $record->total;
              $summary_labels[]  = $record->quiz_title;
              $summary_border_color[] = 'rbg(255,255,255)';

            }
            $test=['rgba(196, 219, 250, 1)','rgba(52, 132, 240, 1)','rgba(41, 75, 147, 1)','rgba(14, 77, 146, 0.3)','rgba(16, 52, 166, 0.8)','rgba(17, 30, 108, 0.5)'];
             for ($i=0; $i < 6; $i++) {
               $summary_bgcolor[] = $test[$i];
             }





          $quiz_stats['data']    = (object) array(
                'labels'            => $summary_labels,
                'dataset'           => $summary_dataset,
                'dataset_label'     => $summary_dataset_labels,
                'bgcolor'           => $summary_bgcolor,
                'border_color'      => $summary_border_color
                );
           $quiz_stats['type'] = 'doughnut';
           $quiz_stats['title'] = getPhrase('demanding_quizzes');
           if($type!='')
           $quiz_stats['title'] = getPhrase('demanding').' '.$type.' '.getPhrase('quizzes');

           return $quiz_stats;
    }

    public function testLanguage($value='')
    {

      dd( $language_phrases = (array) session('language_phrases'));

      $tr = new TranslateClient(); // Default is from 'auto' to 'en'
      $tr->setSource('en'); // Translate from English
      $tr->setTarget('te'); // Translate to Georgian
      echo $tr->translate('Hello World');


     //  $url = urlencode("https://www.googleapis.com/language/translate/v2?q=Select Role&target=hi&source=en&key=AIzaSyAhYkPKPhQ0MA4iWuU0HuoDUZqQKLU16yY");
     //  $returned_content =  json_decode(file_get_contents($url), true);
     // dd($returned_content);
    }
    public function examanalysisbyattempts()
    {
      $user = Auth::user();
            $data['active_class']       = 'analysis';
            $data['title']              = getPhrase('exam_analysis_by_attempts');
            $data['user']               = $user;
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

            return $chart_data;
    }
    public function examanalysisbytotalmarks($user='')
    {

      if(checkRole(['parent'])||checkRole(['admin'])){
        $user=$user;
      }else{
        $user = auth()->user();

      }

      $data['active_class']       = 'dashboard';
      $data['title']='Dashboard';
      $data['user']               = $user;
      // Chart code start
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
          return $chart_data;
    }
    public function OverallperformanceReport()
    {
      $user = Auth::user();
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

        return $chart_data;

    }
    public function bestperformanceinallquizzes()
    {
      $user = Auth::user();
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
            return $chart_data;
    }
    public function gettingavgscore()
    {
      $totalbystd=[];
      $avg=0;
      $data=[];
      $name=[];
      if(checkRole(['parent'])){
        $users=App\User::where('parent_id',getUserWithSlug()->id)->get();
      }else{
        $users=App\User::where('section_name',getUserWithSlug()->section_name)
        ->where('department',auth()->user()->department)->get();
      }

      foreach ($users as $user) {
        $records = array();
        $total=0;
        $i=0;
        $dataset = [];
        $records = Quiz::join('quizresults', 'quizzes.id', '=', 'quizresults.quiz_id')
            ->select(['title','is_paid' ,'dueration', 'quizresults.marks_obtained as total_marks',  \DB::raw('count(quizresults.user_id) as attempts, quizzes.slug, user_id') ])
            ->where('user_id', '=', $user->id)
            ->groupBy('quizresults.quiz_id')
            ->get();
        $dataset_label = getPhrase('Marks');
        foreach($records as $record) {
            $i=$i+1;
            $record = (object)$record;
            $dataset[] = $record->total_marks;
            $total= $record->total_marks+$total;
            }

            $name[]=$user->name;
              if($total>0){
                $avg=round($total/$i,0)+$avg;
                $totalbystd[]=round($total/$i,2);
              }else{
                $totalbystd[]=$total;
              }

            }
            if($avg>0){
                $data['avg']=$avg/$users->count();
              }else{
                $data['avg']=0;
              }


              $data['data']   = (object) array(
                'avg'            => $data['avg'],
                'totals'   =>$totalbystd ,
                'names'     => $name,
                );
         return $data['data'] ;
    }
    public function getstudents()
    {
          $user                   = getUserWithSlug();
          $data['user']           = $user;
          if(checkRole(['parent']))
          {
            $id='parent_id';
          }
          else{
            $id='section_id';
          }
          $data['chart_data']=[];
        if(App\User::where('section_name',$user->section_name)->where('role_id',5)->get()->count()>0){
          if (checkRole(['teacher'])) {
            $users=App\User::where('section_name',$user->section_name)->where('role_id',5)->get();
          }else{
            $users=App\User::where($id, '=', $user->id)->get();
          }

          foreach ($users as $user) {
                $data['user']               = $user;
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
                $chart_data['title'] = getPhrase('exam_analysis_by_attempts').' '.getPhrase('For').' '.getPhrase($user->name);
                $chart_data['data']   = (object) array(
                    'labels'            => $labels,
                    'dataset'           => $dataset,
                    'dataset_label'     => $dataset_label,
                    'bgcolor'           => $bgcolor,
                    'border_color'      => $bordercolor
                    );

                $data['chart_data'][]=(object)$chart_data;


              $data['active_class']       = 'dashboard';
              $data['title']='Dashboard';
              $data['user']               = $user;
              // Chart code start
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
              $chart_data['title'] = getPhrase('exam_analysis_by_total_marks').' '.getPhrase('For').' '.getPhrase($user->name);
              $chart_data['data']   = (object) array(
                  'labels'            => $labels,
                  'dataset'           => $dataset,
                  'dataset_label'     => $dataset_label,
                  'bgcolor'           => $bgcolor,
                  'border_color'      => $bordercolor
                  );

                $data['chart_data'][]=(object)$chart_data;


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
                $dataset_label = 'lbl';
                $bgcolor  = [$color_correct,$color_wrong,$color_not_attempted];
                $border_color = [$color_correct,$color_wrong,$color_not_attempted];
                $chart_data['type'] = 'pie';
                //horizontalBar, bar, polarArea, line, doughnut, pie
                $chart_data['title'] = getphrase('overall_performance').' '.getPhrase('For').' '.getPhrase($user->name);

                $chart_data['data']   = (object) array(
                        'labels'            => $labels,
                        'dataset'           => $dataset,
                        'dataset_label'     => $dataset_label,
                        'bgcolor'           => $bgcolor,
                        'border_color'      => $border_color
                        );

                  $data['chart_data'][]=(object)$chart_data;


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
                        $chart_data['title'] = getPhrase('best_performance_in_all_quizzes').' '.getPhrase('For').' '.getPhrase($user->name);

                        $chart_data['data']   = (object) array(
                                'labels'            => $labels,
                                'dataset'           => $dataset,
                                'dataset_label'     => $dataset_label,
                                'bgcolor'           => $bgcolor,
                                'border_color'      => $border_color
                                );

                                $data['chart_data'][]=(object)$chart_data;
          }
        }
          return $data['chart_data'];
    }
    public function totalpass()
    {
      if(checkRole('teacher')){
          $users=App\User::where('role_id',5)
          ->where('section_id',getUserWithSlug()->section_id)
          
          ->select('id','name')->get();
      }
      if(checkRole('admin')){
        $users=App\User::where('inst_id',getUserWithSlug()->inst_id)->where('role_id',5)
        ->select('id','name')->get();
      }
      if(checkRole('parent')){
        $users=App\User::where('parent_id',getUserWithSlug()->id)->select('id','name')->get();
      }
      if(checkRole('student')){
        $users=App\User::where('id',getUserWithSlug()->id)->select('id','name')->get();
      }
      $tpp=0;
      $t=[];
      // $sum=0;
      foreach ($users as $user) {
          $records = Quiz::join('quizresults', 'quizzes.id', '=', 'quizresults.quiz_id')
            ->select(['quizresults.total_marks as total_marks','marks_obtained' ])
            ->where('user_id', '=', $user->id)
            ->groupBy('quizresults.quiz_id')
            ->get();

          // dd($records);
          $tpp=0;
          foreach ($records as $record) {

            $percent=($record->marks_obtained/$record->total_marks)*100;
            $tpp= $percent+$tpp;
            // $data['name']=$name;
            // $data['percent']=$tpp;

          }
          if(count($records)<=0 || $tpp<=0){
            $data['per']=0;
          }else{
            $data['per']=round($tpp/count($records),2);
          }

          $data['name']=$user->name;
          $t[]=$data;
          // dd($data);
      }
      // dd($t);
      return $t;
    }

    public function scorebysub()
    {
      $labels = [];
      $dataset = [];
      $bgcolor = [];
      $bordercolor = [];
      if (checkRole(['teacher'])) {
        $userbyinst=App\User::where('inst_id',auth()->user()->inst_id)->where('section_id',auth()->user()->section_id)->where('role_id',5)->pluck('id');
      }else{
        $userbyinst=App\User::where('inst_id',auth()->user()->inst_id)->where('role_id',5)->pluck('id');
      }
      
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
      
      return $chart_data;
       
    }
    public function marksbysub()
    {
      $labels = [];
      $dataset = [];
      $bgcolor = [];
      $bordercolor = [];
      if (checkRole(['teacher'])) {
        $userbyinst=App\User::where('inst_id',auth()->user()->inst_id)->where('section_id',auth()->user()->section_id)->where('role_id',5)->pluck('id');
      }else{
        $userbyinst=App\User::where('inst_id',auth()->user()->inst_id)->where('role_id',5)->pluck('id');
      }
      
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
      
      return $chart_data;
       
    }

}

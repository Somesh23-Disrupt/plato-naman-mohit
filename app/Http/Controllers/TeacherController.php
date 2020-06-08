<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App;
use App\Http\Requests;
use App\User;
use App\Quiz;
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
    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App;
use Auth;
use App\Http\Requests;
use App\User;
use App\GeneralSettings as Settings;
use App\QuizResult;
use App\Quiz;
use App\QuestionBank;

use Image;
use ImageSettings;
use Yajra\Datatables\Datatables;
use DB;
use Illuminate\Support\Facades\Hash;

use Input;

class ReportsController extends Controller
{
    public function __construct()
    {
         $currentUser = \Auth::user();

         $this->middleware('auth');

    }

    public function viewExamAnswers($exam_slug, $result_slug)
    {

    	$exam_record = Quiz::getRecordWithSlug($exam_slug);
    	if($isValid = $this->isValidRecord($exam_record))
        	return redirect($isValid);

         $result_record = QuizResult::getRecordWithSlug($result_slug);
         $user_details   = App\User::where('id','=',$result_record->user_id)->get()->first();

        if($isValid = $this->isValidRecord($result_record))
        	return redirect($isValid);



        $prepared_records        = (object) $exam_record
                                    ->prepareQuestions($exam_record->getQuestions(),'examcomplted');
                                    // dd($result_record);
        $data['questions']       = $prepared_records->questions;
        $data['subjects']        = $prepared_records->subjects;
                    //  dd( $result_slug);

        $data['exam_record']        = $exam_record;
        $data['result_record']      = $result_record;
        $data['user_details']        = $user_details;
        $data['active_class']       = 'analysis';
        $data['title']              = $exam_record->title.' '.getPhrase('answers');
        $data['layout']             = getLayout();
    	// return view('student.exams.results.answers', $data);
        $sections=App\User::select(['section_id'])->where('role_id',5)->where('inst_id',auth()->user()->inst_id)->distinct()->pluck('section_id');
        // dd($sections);
        $data['sectionsforteach']= $sections;

         $view_name = getTheme().'::student.exams.results.answers';
        return view($view_name, $data);
    }

    public function getPercentage($total, $goal)
    {
        return ($total / $goal) * 100;
    }

    public function updatescore(Request $request,$exam_slug, $result_slug)
    {

        $exam_record = Quiz::getRecordWithSlug($exam_slug);
    	if($isValid = $this->isValidRecord($exam_record))
        	return redirect($isValid);

         $record = QuizResult::getRecordWithSlug($result_slug);

        if($isValid = $this->isValidRecord($record))
        	return redirect($isValid);
        $record->marks_obtained = $request->updated_marks;
        $total_marks_obtained=(array)json_decode($request->updated_marks);
        $record->percentage = $this->getPercentage($total_marks_obtained['total'], $exam_record->total_marks);
        $record->total_marks_obtained=$total_marks_obtained['total'];
        $exam_status = 'pending';
        if($record->percentage >= $exam_record->pass_percentage)
            $exam_status = 'pass';
        else
            $exam_status = 'fail';

        $record->exam_status = $exam_status;
        $record->save();
        flash('success','record_updated_successfully', 'success');
    	return redirect(URL_RESULTS_VIEW_ANSWERS.$exam_slug."/".$result_slug);
    }



    public function isValidRecord($record)
    {
    	if ($record === null) {

    		flash('Ooops...!', getPhrase("page_not_found"), 'error');
   			return $this->getRedirectUrl();
		}

		return FALSE;
    }

    public function getReturnUrl()
    {
    	return URL_STUDENT_EXAM_CATEGORIES;
    }
}

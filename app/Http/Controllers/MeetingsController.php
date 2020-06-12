<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use \App;

use App\Meeting;
use Yajra\Datatables\Datatables;
use DB;
use Auth;
use App\User;
use dawood\PhpScreenRecorder\ScreenRecorder;

class MeetingsController extends Controller
{
     public function __construct()
    {
    	$this->middleware('auth');
    }

    /**
     * Course listing method
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
      if(!checkRole(getUserGrade(3)))
      {
          if(!checkRole(getUserGrade(7))){
            prepareBlockUserMessage();
            return back();
        }
      }

        $data['active_class']       = 'meetings';
        $data['title']              = getPhrase('meetings');
        $data['layout']              = getLayout();
    	// return view('meetings.list', $data);
      $sections=App\User::select(['section_id'])->where('role_id',5)->where('inst_id',auth()->user()->inst_id)->distinct()->pluck('section_id');
        // dd($sections);
        $data['sectionsforteach']= $sections;
          $view_name = getTheme().'::meetings.list';
        return view($view_name, $data);
    }

    /**
     * This method returns the datatables data to view
     * @return [type] [description]
     */
    public function getDatatable($slug = '')
    {

        if(!checkRole(getUserGrade(3)))
        {
            if(!checkRole(getUserGrade(7))){
              prepareBlockUserMessage();
              return back();
          }
        }

        $records = array();


            if(checkRole(['owner'])){
              $records = Meeting::select(['title','slug','section_id', 'valid_from', 'valid_to',  'id','slug'  ])
              ->orderBy('updated_at', 'desc')->get();
            }
            else if(checkRole(['student'])){
                $records = Meeting::where('inst_id',Auth::user()->inst_id)->select(['title','slug', 'valid_from', 'valid_to',  'id','slug' ])
                ->where('section_id',Auth::user()->section_id)
                ->orderBy('updated_at', 'desc')->get();
            }
            else{
              $records = Meeting::where('inst_id',Auth::user()->inst_id)->select(['title','slug','section_id', 'valid_from', 'valid_to',  'id','slug' ])
              ->where('record_updated_by',Auth::user()->id)
              ->orderBy('updated_at', 'desc')->get();
            }


        return Datatables::of($records)
        ->addColumn('action', function ($records) {

          $link_data = '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="'.URL_MEETINGS_EDIT.$records->slug.'"><i class="fa fa-pencil"></i>'.getPhrase("edit").'</a></li>';

                           $temp = '';
                           if(checkRole(getUserGrade(3))) {
                    $temp .= ' <li><a href="javascript:void(0);" onclick="deleteRecord(\''.$records->slug.'\');"><i class="fa fa-trash"></i>'. getPhrase("delete").'</a></li>';
                      }

                    $temp .='</ul></div>';

                    $link_data .=$temp;
            return $link_data;
            })
        ->editColumn('title',function($records)
        {
              return '<a href="'.URL_MEETINGS_VIEW.$records->slug.'">'.$records->title.'</a>';
        })
        ->editColumn('section_id', function($records) {
            return User::select('section_name')->where('section_id',$records->section_id)->pluck('section_name')->first();
        })
        ->editColumn('status', function($records)
        {
            return ($records->status == 'Active') ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>';
        })
        ->removeColumn('id')

        ->make();
    }

    /**
     * This method loads the create view
     * @return void
     */
    public function create()
    {
      if(!checkRole(getUserGrade(3)))
      {
        prepareBlockUserMessage();
        return back();
      }
    	$data['record']         	= FALSE;
    	$data['active_class']       = 'meetings';
     	$data['title']              = getPhrase('add_meeting');
     	$data['layout']              = getLayout();
        $data['sections']           = array_pluck(User::where('inst_id',Auth::user()->inst_id)->whereNotNull('section_id')->distinct()->get(),'section_name','section_id');

    	// return view('meetings.add-edit', $data);
      $sections=App\User::select(['section_id'])->where('role_id',5)->where('inst_id',auth()->user()->inst_id)->distinct()->pluck('section_id');
      // dd($sections);
      $data['sectionsforteach']= $sections;
         $view_name = getTheme().'::meetings.add-edit';
        return view($view_name, $data);
    }

    /**
     * This method loads the edit view based on unique slug provided by user
     * @param  [string] $slug [unique slug of the record]
     * @return [view with record]
     */
    public function edit($slug)
    {
      if(!checkRole(getUserGrade(3)))
      {
        prepareBlockUserMessage();
        return back();
      }

    	$record = Meeting::getRecordWithSlug($slug);
    	if($isValid = $this->isValidRecord($record))
    		return redirect($isValid);

    	$data['record']       		= $record;
    	$data['active_class']     	= 'meetings';
    	$data['settings']       	= FALSE;
      	$data['title']            	= getPhrase('edit_meeting');
      	$data['layout']             = getLayout();
        $data['sections']           = array_pluck(User::where('inst_id',Auth::user()->inst_id)->whereNotNull('section_id')->distinct()->get(),'section_name','section_id');

    	// return view('meetings.add-edit', $data);
      $sections=App\User::select(['section_id'])->where('role_id',5)->where('inst_id',auth()->user()->inst_id)->distinct()->pluck('section_id');
      // dd($sections);
      $data['sectionsforteach']= $sections;
           $view_name = getTheme().'::meetings.add-edit';
        return view($view_name, $data);
    }

    /**
     * Update record based on slug and reuqest
     * @param  Request $request [Request Object]
     * @param  [type]  $slug    [Unique Slug]
     * @return void
     */
    public function update(Request $request, $slug)
    {
      if(!checkRole(getUserGrade(3)))
      {
        prepareBlockUserMessage();
        return back();
      }

    	$record = Meeting::getRecordWithSlug($slug);
		 $rules = [
        'title'          	=> 'bail|required|max:50' ,

         'valid_from'      	=> 'bail|required',
         'valid_to'      	=> 'bail|required',
            ];
         /**
        * Check if the title of the record is changed,
        * if changed update the slug value based on the new title
        */
       $name = $request->title;
        if($name != $record->title)
            $record->slug = $record->makeSlug($name);

       //Validate the overall request
       $this->validate($request, $rules);

        $record->title          	= $name;
        $record->valid_from			= $request->valid_from;
        $record->valid_to			= $request->valid_to;
        $record->inst_id		= Auth::user()->inst_id;
        $record->section_id				= $request->section_id;
        $record->short_description		= $request->short_description;
        $record->description		= $request->description;
       	$record->record_updated_by 	= Auth::user()->id;
        $record->save();
        flash('success','record_updated_successfully', 'success');
    	return redirect(URL_MEETINGS);
    }

    /**
     * This method adds record to DB
     * @param  Request $request [Request Object]
     * @return void
     */
    public function store(Request $request)
    {
      if(!checkRole(getUserGrade(3)))
      {
        prepareBlockUserMessage();
        return back();
      }

	    $rules = [
         'title'          	=> 'bail|required|max:50' ,

         'valid_from'      	=> 'bail|required' ,
         'valid_to'      	=> 'bail|required' ,
            ];
        $this->validate($request, $rules);
        $record = new Meeting();
      	$name  						=  $request->title;
		$record->title 				= $name;
       	$record->slug               = $record->makeSlug($name, TRUE);
        $record->valid_from			= $request->valid_from;
        $record->inst_id		    = Auth::user()->inst_id;
        $record->valid_to			= $request->valid_to;
        $record->section_id			= $request->section_id;
        $record->short_description	= $request->short_description;
        $record->description		= $request->description;
       	$record->record_updated_by 	= Auth::user()->id;

        $record->save();
        flash('success','record_added_successfully', 'success');
    	return redirect(URL_MEETINGS);
    }

    /**
     * Delete Record based on the provided slug
     * @param  [string] $slug [unique slug]
     * @return Boolean
     */
    public function delete($slug)
    {
      if(!checkRole(getUserGrade(3)))
      {
        prepareBlockUserMessage();
        return back();
      }
      /**
       * Delete the questions associated with this quiz first
       * Delete the quiz
       * @var [type]
       */
        $record = Meeting::where('slug', $slug)->first();
        if(!env('DEMO_MODE')) {
            $record->delete();
        }

        $response['status'] = 1;
        $response['message'] = getPhrase('record_deleted_successfully');
        return json_encode($response);
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
    	return URL_MEETINGS;
    }

    public function usersList()
    {

        $data['active_class']       = 'meetings';
        $data['title']              = getPhrase('meetings');
        $data['layout']              = getLayout();
        $date = date('Y-m-d');
        $data['meetings']  	= Meeting::where('inst_id',Auth::user()->inst_id)->where('valid_from', '<=', $date)
        											->where('valid_to', '>=', $date)->paginate(getRecordsPerPage());

    	// return view('meetings.users-list', $data);

            if(checkRole(['parent'])){
              $childs=App\User::where('parent_id',auth()->user()->id)->get();
                  foreach ($childs as $child) {

                    $name[]=$child->slug;

                  }
                  $data['slugs']=$name;
            }
            $sections=App\User::select(['section_id'])->where('role_id',5)->where('inst_id',auth()->user()->inst_id)->distinct()->pluck('section_id');
        // dd($sections);
        $data['sectionsforteach']= $sections;
           $view_name = getTheme().'::meetings.users-list';
        return view($view_name, $data);
    }

    public function display($slug)
    {
        $record = Meeting::getRecordWithSlug($slug);
        if($isValid = $this->isValidRecord($record))
            return redirect($isValid);

        $data['active_class']       = 'meetings';
        $data['title']              = $record->title;
        $data['layout']             = getLayout();
        $data['meeting']       = $record;

        // return view('meetings.details', $data);
        $sections=App\User::select(['section_id'])->where('role_id',5)->where('inst_id',auth()->user()->inst_id)->distinct()->pluck('section_id');
        // dd($sections);
        $data['sectionsforteach']= $sections;
           $view_name = getTheme().'::meetings.details';
        return view($view_name, $data);
    }


    public function record(){
                $screenRecorder=new ScreenRecorder();
                $screenRecorder->setScreenSizeToCapture(1280,720);
                $options=['-show_region'=>'1'];
                $screenRecorder->setOptions($options);
                $screenRecorder->startRecording('public/recordings/'.'myVideo');
                //sleep(5+2);//doing random stuff
                //when done stop recording
                $screenRecorder->stopRecording(0);

                //dd("video is saved at :".$screenRecorder->getVideo().'"'.PHP_EOL);


    }
}

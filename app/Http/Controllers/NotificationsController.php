<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use \App;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Google_Client;
use App\User;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;

use App\Notification;
use Yajra\Datatables\Datatables;
use DB;
use Auth;

class NotificationsController extends Controller
{

    protected $client;

    public function __construct()
    {   $this->middleware('auth');
        $client = new Google_Client();
        $client->setAuthConfig('public/client_secret.json');
        $client->addScope(Google_Service_Calendar::CALENDAR);

        $guzzleClient = new \GuzzleHttp\Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false)));
        $client->setHttpClient($guzzleClient);
        $this->client = $client;
    }
    

    public function oauth()
    {
        session_start();

        $rurl = action('NotificationsController@oauth');
        $this->client->setRedirectUri($rurl);
        if (!isset($_GET['code'])) {
            $auth_url = $this->client->createAuthUrl();
            $filtered_url = filter_var($auth_url, FILTER_SANITIZE_URL);
            return redirect($filtered_url);
        } else {
            $this->client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $this->client->getAccessToken();
            return redirect(URL_NOTIFICATIONS);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    


    /**
     * Course listing method
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
      if(!checkRole(getUserGrade(3)))
      {
        prepareBlockUserMessage();
        return back();
      }

        $data['active_class']       = 'notifications';
        $data['title']              = getPhrase('notifications');
        $data['layout']              = getLayout();
    	// return view('notifications.list', $data);
      $sections=App\User::select(['section_id'])->where('role_id',5)->where('inst_id',auth()->user()->inst_id)->distinct()->pluck('section_id');
      // dd($sections);
      $data['sectionsforteach']= $sections;
          $view_name = getTheme().'::notifications.list';
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
        prepareBlockUserMessage();
        return back();
      }

        $records = array();


            if(checkRole(['owner'])){
              $records = Notification::select(['title', 'canceled','valid_from', 'valid_to', 'url', 'id','slug' ])
              ->orderBy('updated_at', 'desc');
            }
            else{
              $records = Notification::where('inst_id',Auth::user()->inst_id)->select(['title', 'canceled','valid_from', 'valid_to',  'url', 'id','slug' ])
              ->orderBy('updated_at', 'desc');
            }


        return Datatables::of($records)
        ->addColumn('action', function ($records) {

          $link_data = '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="'.URL_ADMIN_NOTIFICATIONS_EDIT.$records->slug.'"><i class="fa fa-pencil"></i>'.getPhrase("edit").'</a></li>';

                           $temp = '';
                           if(checkRole(getUserGrade(3))) {
                             if($records->canceled==1){
                           $temp .= ' <li><a href="javascript:void(0);" onclick="deleteRecord(\''.$records->slug.'\');"><i class="fa fa-trash"></i>'. getPhrase("delete").'</a></li>';
                          }else{
                            $temp .= ' <li><a href="javascript:void(0);" onclick="deleteRecord(\''.$records->slug.'\');"><i class="fa fa-trash"></i>'. getPhrase("delete").'</a></li> <li><a href="javascript:void(0);" onclick="cancelRecord(\''.$records->slug.'\');"><i class="fa fa-ban"></i>'. getPhrase("cancel").'</a></li>';
                          }
                      }

                    $temp .='</ul></div>';

                    $link_data .=$temp;
            return $link_data;
            })
        ->editColumn('canceled', function($records)
        {
            return ($records->canceled == 0) ? '<p class="text-success">'.getPhrase('active').'</p>' : '<p class="text-danger">'.getPhrase('canceled').'</p>';
        })
        ->removeColumn('id')
        ->removeColumn('slug')

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
    	$data['active_class']       = 'notifications';
     	$data['title']              = getPhrase('add_notification');
     	$data['layout']              = getLayout();
    	// return view('notifications.add-edit', $data);
      $sections=App\User::select(['section_id'])->where('role_id',5)->where('inst_id',auth()->user()->inst_id)->distinct()->pluck('section_id');
      // dd($sections);
      $data['sectionsforteach']= $sections;
         $view_name = getTheme().'::notifications.add-edit';
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

    	$record = Notification::getRecordWithSlug($slug);
    	if($isValid = $this->isValidRecord($record))
    		return redirect($isValid);

    	$data['record']       		= $record;
    	$data['active_class']     	= 'notifications';
    	$data['settings']       	= FALSE;
      	$data['title']            	= getPhrase('edit_notification');
      	$data['layout']             = getLayout();
    	// return view('notifications.add-edit', $data);
      $sections=App\User::select(['section_id'])->where('role_id',5)->where('inst_id',auth()->user()->inst_id)->distinct()->pluck('section_id');
      // dd($sections);
      $data['sectionsforteach']= $sections;
           $view_name = getTheme().'::notifications.add-edit';
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

    	$record = Notification::getRecordWithSlug($slug);
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
        $record->url				= $request->url;
        $record->short_description		= $request->short_description;
        $record->description		= $request->description;
       	$record->record_updated_by 	= Auth::user()->id;
        $record->save();
            


        flash('success','record_updated_successfully', 'success');
    	return redirect(URL_ADMIN_NOTIFICATIONS);
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

         session_start();
       $startDateTime = str_replace(' ','T',$request->valid_from);
        $endDateTime = str_replace(' ','T',$request->valid_to);


        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $this->client->setAccessToken($_SESSION['access_token']);
            $service = new Google_Service_Calendar($this->client);

            $calendarId = 'primary';
            $event = new Google_Service_Calendar_Event([
                'summary' => $request->title,
                'description' => $request->description,
                'start' => array(
                  'dateTime' => $startDateTime,
                  'timeZone' => 'Asia/Kolkata',
                ),
                'end' => array(
                  'dateTime' =>$endDateTime,
                  'timeZone' => 'Asia/Kolkata',
                ),
                'reminders' => ['useDefault' => true],
            ]);
            // dd($event);
            $results = $service->events->insert($calendarId, $event);
            if (!$results) {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
            }
           

        }  
         else {
            return redirect()->route('oauthCallback');
        }
        $record = new Notification();
      	$name  						=  $request->title;
		    $record->title 				= $name;
       	$record->slug 				= $record->makeSlug($name);
        $record->valid_from			= $request->valid_from;
        $record->inst_id		= Auth::user()->inst_id;
        $record->valid_to			= $request->valid_to;
        $record->url				= $request->url;
        $record->short_description	= $request->short_description;
        $record->description		= $request->description;
       	$record->record_updated_by 	= Auth::user()->id;
        

        $record->save();

       
        flash('success','record_added_successfully', 'success');
    	return redirect(URL_ADMIN_NOTIFICATIONS);
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
        $record = Notification::where('slug', $slug)->first();
        if(!env('DEMO_MODE')) {
            $record->delete();
        }

        


        $response['status'] = 1;
        $response['message'] = getPhrase('record_deleted_successfully');
        return json_encode($response);
    }

    public function cancel($slug)
    {
      $record = Notification::where('slug', $slug)->first();
      $record->canceled=1;

      $record->save();
        session_start();
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $this->client->setAccessToken($_SESSION['access_token']);
            $service = new Google_Service_Calendar($this->client);
          
            $calendarId = 'primary';

            $results = $service->events->listEvents($calendarId);
           
            foreach ($results as $key ) {
                
                if ($key->summary==$record->title) {
                  $eventId=$key->id;
                }
              }
            $service->events->delete('primary', $eventId);

        } else {
            return redirect('oauth');
        }
        $response['status'] = 1;
        $response['message'] = getPhrase('Event_canceled');
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
    	return URL_ADMIN_NOTIFICATIONS;
    }

    public function usersList()
    {

        $data['active_class']       = 'notifications';
        $data['title']              = getPhrase('notifications');
        $data['layout']              = getLayout();
        $date = date('Y-m-d');
        $data['notifications']  	= Notification::where('inst_id',Auth::user()->inst_id)->where('valid_from', '<=', $date)
        											->where('valid_to', '>=', $date)->paginate(getRecordsPerPage());

    	// return view('notifications.users-list', $data);

            if(checkRole(['parent'])){
              $childs=App\User::where('parent_id',auth()->user()->id)->get();
                  foreach ($childs as $child) {

                    $name[]=$child->slug;

                  }
                  $data['slugs']=$name;
            }
           $view_name = getTheme().'::notifications.users-list';
        return view($view_name, $data);
    }

    public function display($slug)
    {
        $record = Notification::getRecordWithSlug($slug);
        if($isValid = $this->isValidRecord($record))
            return redirect($isValid);

        $data['active_class']       = 'notifications';
        $data['title']              = $record->title;
        $data['layout']             = getLayout();
        $data['notification']       = $record;

        // return view('notifications.details', $data);
        $sections=App\User::select(['section_id'])->where('role_id',5)->where('inst_id',auth()->user()->inst_id)->distinct()->pluck('section_id');
        // dd($sections);
        $data['sectionsforteach']= $sections;
           $view_name = getTheme().'::notifications.details';
        return view($view_name, $data);
    }
}

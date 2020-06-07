<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App;
use App\Http\Requests;
use App\User;
use Cache;
use App\Section;
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
use Auth;

class UsersController extends Controller
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
     public function index($role = 'student')
     {
        if(!checkRole(getUserGrade(2)))
        {
          if(!checkRole(getUserGrade(8)))
          {
            prepareBlockUserMessage();
            return back();
          }
        }
      
        $data['records']      = FALSE;
        $data['layout']      = getLayout();
        $data['active_class'] = 'users';
        $data['heading']      = getPhrase('users');
        $data['title']        = getPhrase('users');
        // return view('users.list-users', $data);

         $view_name = getTheme().'::users.list-users';
        return view($view_name, $data);
     }


    /**
     * This method returns the datatables data to view
     * @return [type] [description]
     */

    public function getDatatable($slug = '')
    {
        $records = array();

        if($slug=='')
        {

             $records = User::join('roles', 'users.role_id', '=', 'roles.id')
            ->select(['users.name', 'email', 'image', 'roles.display_name','login_enabled','role_id',
              'slug', 'users.id', 'users.updated_at'])
            ->orderBy('users.updated_at', 'desc')
            ->where('users.institute_id','=', Auth::user()->institute_id)
            ->get();

        }
        else {

            $role = App\Role::getRoleId($slug);

            $records = User::join('roles', 'users.role_id', '=', 'roles.id', 'roles.id', '=', $role->id)
            ->select(['name',  'image', 'email','roles.display_name','login_enabled','role_id','slug', 'users.updated_at'])
             ->orderBy('users.updated_at', 'desc')
             ->where('users.institute_id','=', Auth::user()->institute_id)
             ->get();

        }

        return Datatables::of($records)
        ->addColumn('action', function ($records) {
          $link_data = '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                           <li><a href="'.URL_USERS_EDIT.$records->slug.'"><i class="fa fa-pencil"></i>'.getPhrase("edit").'</a></li>';
          if(getRoleData($records->role_id)=='student')
          {

             $link_data .= ' <li><a href="'.URL_USERS_SETTINGS.$records->slug.'"><i class="fa fa-spinner"></i>'.getPhrase("add_categories").'</a></li>';

            $link_data .= ' <li><a href="'.URL_USERS_UPDATE_PARENT_DETAILS.$records->slug.'"><i class="fa fa-user"></i>'.getPhrase("update_parent").'</a></li>';
          }
                         $temp='';

                        //Show delete option to only the owner user
                        if (checkRole(getUserGrade(1)) && $records->id!=\Auth::user()->id)   {

                         $temp = '<li><a href="javascript:void(0);" onclick="deleteRecord(\''.$records->slug.'\');"><i class="fa fa-trash"></i>'. getPhrase("delete").'</a></li>';


                          $temp .= '<li><a href="javascript:void(0);" onclick="accountStatus(\''.$records->slug.'\');"><i class="fa fa-check-circle-o"></i>'. getPhrase("status").'</a></li>';

                         }

                        $temp .='</ul> </div>';
                        $link_data .= $temp;
            return $link_data;
            })
          ->addColumn('user_status', function($records){
                 
             if(App\User::find($records->id)->isOnline()) {
                $status='<i class="fa fa-check text-success">Online</i>' ;}
             else{ 
              $status='<i class="fa fa-times text-danger">Offline</i>';}
               return $status;
            })
         ->editColumn('name', function($records) {
          if(getRoleData($records->role_id)=='student')
            return '<a href="'.URL_USER_DETAILS.$records->slug.'">'.ucfirst($records->name).'</a>';

          return ucfirst($records->name);
        })        
         ->editColumn('image', function($records){
            return '<img src="'.getProfilePath($records->image).'"  />';
        })
         ->editColumn('role_id', function($records){
            return App\Role::where('id',$records->role_id)->first()->display_name;
        })
        ->editColumn('inst_name', function($records){
          return strtoupper($records->inst_name);
        })
        ->editColumn('department', function($records){
          return strtoupper($records->department);
        })

        ->editColumn('login_enabled', function($records){

            return ($records->login_enabled == 1) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>';
        })


        ->removeColumn('role_id')
        ->removeColumn('id')
        ->removeColumn('slug')
        ->removeColumn('updated_at')
        // ->addAction('action',['printable' => false])

        ->make();
    }



     /**
      * Show the form for creating a new resource.
      *
      * @return Response
      */
     public function create()
     {
        // dd( (Auth::user()->section_id==NULL) );
        if((checkRole(getUserGrade(6)) && (Auth::user()->section_id==NULL) ) && !(checkRole(getUserGrade(2)))  )
        {
          prepareBlockUserMessage();
          return back();
        }
        
       if(checkRole(getUserGrade(7))){
             prepareBlockUserMessage();
             return back();
          }
       
        $data['record']       = FALSE;
        $data['active_class'] = 'users';
        
        // $data['roles']        = $this->getUserRoles();
        $roles  = \App\Role::select('display_name', 'id','name')->get();
        if(checkRole(['teacher'])){

          $parents = \App\User::where('role_id',6)
          ->select('id','name')->get();
          $all_parent = [];
          
            foreach($parents as $parent)
            { 
                $all_parent[$parent->id] = $parent->name;
            }
            $data['parents']        = $all_parent;
            
        }
        foreach($roles as $role)
        {
          
           if(!checkRole(getUserGrade(1))) {

            if(!(strtolower($role->name) == 'admin' || strtolower($role->name) =='owner'))
              $final_roles[$role->id] = $role->display_name;
          }
          else 
           $final_roles[$role->id] = $role->display_name;
        }
        $data['roles']        = $final_roles;
        $final_roles = [];

        $data['title']        = getPhrase('add_user');
        if(checkRole(['parent']))
          $data['active_class'] = 'children';
        $data['layout']       = getLayout();

        // return view('users.add-edit-user', $data);
        $data['sections']=User::select('section_name')->where('institute_id',Auth::user()->institute_id)->distinct()->pluck('section_name');
         $view_name = getTheme().'::users.add-edit-user';
        return view($view_name, $data);
     }

     /**
      * This method returns the roles based on the user type logged in
      * @param  [type] $roles [description]
      * @return [type]        [description]
      */
     public function getUserRoles()
     {
        $roles                = \App\Role::pluck('display_name', 'id');

        return array_where($roles, function ($key, $value) {
          if(!checkRole(getUserGrade(1))) {
            if(!($value == 'Admin' || $value =='Owner'))
              return $value;
          }
          else
            return $value;
        });
     }

     /**
      * Store a newly created resource in storage.
      *
      * @return Response
      */
     public function store(Request $request )
     {
        $columns = array(
        'name'  => 'bail|required|max:20|',
        'username' => 'bail|required|unique:users,username',
        'email' => 'bail|required|unique:users,email',
        //'inst_name'=>'bail|required|max:20|',
        'image' => 'bail|mimes:png,jpg,jpeg|max:2048',
        'password'=> 'bail|required|min:5',
        'password_confirmation'=>'bail|required|min:5|same:password',
        );
        //dd($request->role_id);
        if(checkRole(getUserGrade(1)))
          $columns['role_id']  = 'bail|required';



        $this->validate($request,$columns);


        if(checkRole(getUserGrade(2)))
            $role_id = getRoleData('teacher');
        else
            $role_id = getRoleData('student');


        $user               = new User();
        $name               = $request->name;
        $user->name         = $name;
        $user->email        = $request->email;
        $user->institute_id = Auth::user()->institute_id;
        $user->inst_name    = Auth::user()->inst_name;
        if(checkRole(getUserGrade(6))){
            $user->section_id   = Auth::user()->section_id;
            $user->section_name = Auth::user()->section_name;
        }
        else if(checkRole(getUserGrade(2))){
            if($request->section){
                $sect_id=User::select('section_id')
                            ->where('institute_id',Auth::user()->institute_id)
                            ->where('section_name',$request->section)->pluck('section_id')->first();

                if($sect_id==NULL){
                    $sect_id=User::select('section_id')
                                ->orderBy('section_id','asc')
                                ->pluck('section_id')
                                ->last()+1;
                }
                $user->section_id   = $sect_id;
                $user->section_name = $request->section ;
            }
        }
        $password           = $request->password;
        $user->password     = bcrypt($password);


        if(checkRole(['parent']))
          $user->parent_id = getUserWithSlug()->id;

        $user->role_id        = $role_id;
        $user->login_enabled  = 1;
        $slug = $user::makeSlug($name);
        $user->username = $request->username;
        $user->slug           = $slug;
        $user->phone        = $request->phone;
        $user->address      = $request->address;

        $user->activation_code = str_random(30);
        $link = URL_USERS_CONFIRM.$user->activation_code;

        $user->save();


        if(!env('DEMO_MODE')) {
           $user->roles()->attach($user->role_id);
          $this->processUpload($request, $user);
        }
        $message = getPhrase('record_added_successfully_with_password ').' '.$password;
        $exception = 0;
       try{
       if(!env('DEMO_MODE')) {
        $user->notify(new \App\Notifications\NewUserRegistration( $user, $user->email, $password, $link ) );

        }
       //$this->sendPushNotification($user);
     }
     catch(Exception $ex)
     {
        $message = getPhrase('record_added_successfully_with_password ').' '.$password;
        $message .= getPhrase('\ncannot_send_email_to_user, please_check_your_server_settings');
        $exception = 1;
     }

      $flash = app('App\Http\Flash');
      $flash->create('Success...!', $message, 'success', 'flash_overlay',FALSE);


       if(checkRole(['parent']))
        return redirect('dashboard');

       return redirect(URL_USERS);
     }


     public function sendPushNotification($user)
     {
        if(getSetting('push_notifications', 'module')) {
          if(getSetting('default', 'push_notifications')=='pusher') {
              $options = array(
                    'name' => $user->name,
                    'image' => getProfilePath($user->image),
                    'slug' => $user->slug,
                    'role' => getRoleData($user->role_id),
                );

            pushNotification(['owner','admin'], 'newUser', $options);
          }
          else {
            $this->sendOneSignalMessage('New Registration');
          }
        }
     }

     /**
      * This method sends the message to admin via One Signal
      * @param  string $message [description]
      * @return [type]          [description]
      */
     public function sendOneSignalMessage($new_message='')
     {
        $gcpm = new OneSignalApp();
      $message = array(
             "en" => $new_message,
             "title" => 'New Registration',
             "icon" => "myicon",
             "sound" => "default"
            );
          $data = array(
            "body" => $new_message,
             "title" => "New Registration",
          );

          $gcpm->setDevices(env('ONE_SIGNAL_USER_ID'));
          $response = $gcpm->sendToAll($message,$data);
     }



     protected function processUpload(Request $request, User $user)
     {

       if(env('DEMO_MODE')) {
        return 'demo';
       }

         if ($request->hasFile('image')) {

          $imageObject = new ImageSettings();

          $destinationPath      = $imageObject->getProfilePicsPath();
          $destinationPathThumb = $imageObject->getProfilePicsThumbnailpath();

          $fileName = $user->id.'.'.$request->image->guessClientExtension();
          ;
          $request->file('image')->move($destinationPath, $fileName);
          $user->image = $fileName;

          Image::make($destinationPath.$fileName)->fit($imageObject->getProfilePicSize())->save($destinationPath.$fileName);

          Image::make($destinationPath.$fileName)->fit($imageObject->getThumbnailSize())->save($destinationPathThumb.$fileName);
          $user->save();
        }
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
      return URL_USERS;
    }

     /**
      * Display the specified resource.
      *
      *@param  unique string  $slug
      * @return Response
      */
     public function show($slug)
     {
        //
     }



     /**
      * Show the form for editing the specified resource.
      *
      * @param  unique string  $slug
      * @return Response
      */
     public function edit($slug)
     {
        $record = User::where('slug', $slug)->get()->first();
        if($isValid = $this->isValidRecord($record))
         return redirect($isValid);
       /**
        * Validate the non-admin user wether is trying to access other user profile
        * If so return the user back to previous page with message
        */

        if(!isEligible($slug))
          return back();


        /**
         * Make sure the Admin or staff cannot edit the Admin/Owner accounts
         * Only Owner can edit the Admin/Owner profiles
         * Admin can edit his own account, in that case send role type admin on condition
         */
        
     $UserOwnAccount = FALSE;
     if(\Auth::user()->id == $record->id)
      $UserOwnAccount = TRUE;
    
      if(!$UserOwnAccount)  {
        $current_user_role = getRoleData($record->role_id);

        if((($current_user_role=='admin' || $current_user_role == 'owner') ))
        {
          if(!checkRole(getUserGrade(1))) {
            prepareBlockUserMessage();
            return back();
          }
        }
      }

        $data['record']             = $record;
        // dd('hrere');
        // $data['roles']              = $this->getUserRoles();
        if(checkRole(['teacher'])){

          $parents = \App\User::where('role_id',6)
          ->select('id','name')->get();
          $all_parent = [];
          
            foreach($parents as $parent)
            { 
                $all_parent[$parent->id] = $parent->name;
            }
            $data['parents']        = $all_parent;
            
        }
        $roles                = \App\Role::select('display_name', 'id','name')->get();
        $final_roles = [];
        foreach($roles as $role)
        {
          
           if(!checkRole(getUserGrade(1))) {

            if(!(strtolower($role->name) == 'admin' || strtolower($role->name) =='owner'))
              $final_roles[$role->id] = $role->display_name;
          }
          else 
           $final_roles[$role->id] = $role->display_name;
        }
        $data['roles']        = $final_roles;
         

        if($UserOwnAccount && checkRole(['admin']))
          $data['roles'][getRoleData('admin')] = 'Admin';

        $data['active_class']       = 'users';
        $data['title']              = getPhrase('edit_user');
        $data['layout']             = getLayout();
        $data['sections']=User::select('section_name')->where('institute_id',Auth::user()->institute_id)->distinct()->pluck('section_name');

        // dd($data);
        // return view('users.add-edit-user', $data);

            $view_name = getTheme().'::users.add-edit-user';
        return view($view_name, $data);
     }



     /**
      * Update the specified resource in storage.
      *
      * @param  int  $id
      * @return Response
      */
     public function update(Request $request, $slug)
     {
        $record     = User::where('slug', $slug)->get()->first();
        $validation = [
        'name'      => 'bail|required|max:20|',
        'email'     => 'bail|required|unique:users,email,'.$record->id,
        //'inst_name'      => 'bail|required|max:20|,inst_name,'.$record->inst_id,
        'image'     => 'bail|mimes:png,jpg,jpeg|max:2048',
        ];

        if(!isEligible($slug))
          return back();

        //if(checkRole(getUserGrade(2)))
          //$validation['role_id'] = 'bail|required|integer';


        $this->validate($request, $validation);

        $name = $request->name;
        //$inst_name = $request->inst_name;
        $previous_role_id = $record->role_id;
         if($name != $record->name)
            $record->slug = $record::makeSlug($name);

        $record->name = $name;
        $record->email = $request->email;
        //$record->inst_name = $inst_name;

        if(checkRole(getUserGrade(2)))
            $role_id = getRoleData('teacher');
        else
            $role_id = getRoleData('student');

        if(checkRole(getUserGrade(6))){
            $record->section_id   = Auth::user()->section_id;
            $record->section_name = Auth::user()->section_name;

        }
        else if(checkRole(getUserGrade(2))){
            $sect_id=NULL;
            if($request->section){
                $sect_id=User::select('section_id')
                                ->where('institute_id',Auth::user()->institute_id)
                                ->where('section_name',$request->section)->pluck('section_id')->first();

                if($sect_id==NULL){
                    $sect_id=User::select('section_id')
                                    ->orderBy('section_id','asc')
                                    ->pluck('section_id')
                                    ->last()+1;
                }
            }
            $record->section_id   = $sect_id;
            $record->section_name = $request->section ;
        }



       $record->phone = $request->phone;
       $record->address = $request->address;
       $record->save();
       if($request->password) {
          $password       = $request->password;
          $record->password = bcrypt($password);
          $record->save();
          $record->notify(new \App\Notifications\PasswordChanged($record,$record->email,$password));
       }

        if(checkRole(getUserGrade(2)))
        {
          /**
           * Delete the Roles associated with that user
           * Add the new set of roles
           */
         if(!env('DEMO_MODE')) {
          DB::table('role_user')
          ->where('user_id', '=', $record->id)
          ->where('role_id', '=', $previous_role_id)
          ->delete();
         $record->roles()->attach($request->role_id);
       }
        }
        if(!env('DEMO_MODE')) {
          $this->processUpload($request, $record);
        }
        flash('success','record_updated_successfully', 'success');
        // return redirect('users/edit/'.$record->slug);
        if(checkRole(getUserGrade(2)))
        return redirect(URL_USERS);
       return redirect(URL_USERS_EDIT.$record->slug);
      }



     /**
      * Remove the specified resource from storage.
      *
      * @param  unique string  $slug
      * @return Response
      */
    /**
     * Delete Record based on the provided slug
     * @param  [string] $slug [unique slug]
     * @return Boolean
     */
    public function delete($slug)
    {
         if(!checkRole(getUserGrade(2)))
        {
          prepareBlockUserMessage();
          return back();
        }

        $record = User::where('slug', $slug)->first();

        /**
         * Check if any exams exists with this category,
         * If exists we cannot delete the record
         */
           if(!env('DEMO_MODE')) {
           $imageObject = new ImageSettings();
          $destinationPath      = $imageObject->getProfilePicsPath();
          $destinationPathThumb = $imageObject->getProfilePicsThumbnailpath();

            $this->deleteFile($record->image, $destinationPath);
            $this->deleteFile($record->image, $destinationPathThumb);
            $record->delete();
          }
            $response['status'] = 1;
            $response['message'] = getPhrase('record_deleted_successfully');
            return json_encode($response);
    }

    public function deleteFile($record, $path, $is_array = FALSE)
    {
       if(env('DEMO_MODE')) {
        return ;
       }

        $files = array();
        $files[] = $path.$record;
        File::delete($files);
    }


    public function listUsers($role_name)
    {
      $role = App\Role::getRoleId($role_name);

      $users = User::where('role_id', '=', $role->id)->get();

      $users_list =  array();

      foreach ($users as $key => $value) {
        $r = array('id'=>$value->id, 'text' => $value->name, 'image' => $value->image);
            array_push($users_list, $r);
      }
      return json_encode($users_list);
    }

    public function details($slug)
    {
        $record     = User::where('slug', $slug)->get()->first();

        if($isValid = $this->isValidRecord($record))
         return redirect($isValid);

       /**
        * Validate the non-admin user wether is trying to access other user profile
        * If so return the user back to previous page with message
        */

        if(!isEligible($slug))
          return back();

        $data['record']      = $record;


         $user = $record;
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

            $data['chart_data'][] = (object)$chart_data;

            //Best scores in each quizzes
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
            $dataset_label = getPhrase('performance');
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
            $data['chart_data'][] = (object)$chart_data;

        $data['ids'] = array('myChart0', 'myChart1');
        $data['title']        = getPhrase('user_details');
        $data['layout']        = getLayout();
         $data['active_class'] = 'users';
        if(checkRole(['parent']))
          $data['active_class'] = 'children';
      //   $data['right_bar']          = TRUE;
      // $data['right_bar_path']     = 'student.exams.right-bar-performance-chart';
      // $data['right_bar_data']     = array('chart_data' => $data['chart_data']);

        // return view('users.user-details', $data);

            $view_name = getTheme().'::users.user-details';
        return view($view_name, $data);
    }

    /**
     * This method will show the page for change password for user
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function changePassword($slug)
    {

       $record = User::where('slug', $slug)->get()->first();
        if($isValid = $this->isValidRecord($record))
         return redirect($isValid);
       /**
        * Validate the non-admin user wether is trying to access other user profile
        * If so return the user back to previous page with message
        */

        if(!isEligible($slug))
          return back();

        $data['record']             = $record;
        $data['active_class']       = 'profile';
        $data['title']              = getPhrase('change_password');
        $data['layout']             = getLayout();
        // return view('users.change-password.change-view', $data);

               $view_name = getTheme().'::users.change-password.change-view';
        return view($view_name, $data);
    }
    /**
     * This method updates the password submitted by the user
     * @param  Request $request [description]
     * @return [type]           [description]
     */
     public function updatePassword(Request $request)
    {

        $this->validate($request, [
            'old_password' => 'required',
            'password'     => 'required|confirmed',
        ]);

        $credentials = $request->only(
            'old_password', 'password', 'password_confirmation'
        );
        $user = \Auth::user();


        if (Hash::check($credentials['old_password'], $user->password)){
            $password = $credentials['password'];
            $user->password = bcrypt($password);
            $user->save();
            flash('success','password_updated_successfully', 'success');
            return redirect(URL_USERS_CHANGE_PASSWORD.$user->slug);

        }else {

            flash('Oops..!','old_and_new_passwords are not same', 'error');
            return redirect()->back();
       }
  }

  /**
    * Display a Import Users page
    *
    * @return Response
    */
     public function importUsers($role = 'student')
     {
        if(!checkRole(getUserGrade(3)))
        {
          prepareBlockUserMessage();
          return back();
        }
        $data['records']      = FALSE;
        $data['active_class'] = 'users';
        $data['heading']      = getPhrase('users');
        $data['title']        = getPhrase('import_users');
        $data['layout']        = getLayout();
        // return view('users.import.import', $data);

           $view_name = getTheme().'::users.import.import';
        return view($view_name, $data);
     }

     public function readExcel(Request $request)
     {

        $columns = array(
        'excel'  => 'bail|required',
        );
        $this->validate($request,$columns);

       if(!checkRole(getUserGrade(2)))
        {
          prepareBlockUserMessage();
          return back();
        }
       $success_list = [];
       $failed_list = [];

       try{
        if(Input::hasFile('excel')){
          $path = Input::file('excel')->getRealPath();
          $data = Excel::load($path, function($reader) {
          })->get();
          $user_record = array();
          $users =array();
          $isHavingDuplicate = 0;
          if(!empty($data) && $data->count()){
            
            foreach ($data as $key => $value) {

              foreach($value as $record)
              {
                unset($user_record);
            
                $user_record['username'] = $record->username;
                $user_record['name'] = $record->name;
                $user_record['email'] = $record->email;

                $user_record['password'] = $record->password;
                $user_record['phone'] = $record->phone;
                $user_record['address'] = $record->address;
                $user_record['role_id'] = STUDENT_ROLE_ID;

                $user_record = (object)$user_record;
                $failed_length = count($failed_list);
                if($this->isRecordExists($record->username, 'username'))
                {

                  $isHavingDuplicate = 1;
                  $temp = array();
                 $temp['record'] = $user_record;
                 $temp['type'] ='Record already exists with this name';
                 $failed_list[$failed_length] = (object)$temp;
                  continue;
                }

                if($this->isRecordExists($record->email, 'email'))
                {
                  $isHavingDuplicate = 1;
                  $temp = array();
                 $temp['record'] = $user_record;
                 $temp['type'] ='Record already exists with this email';
                 $failed_list[$failed_length] = (object)$temp;
                  continue;
                }
               
                $users[] = $user_record;
               
              }
            
            }
              if($this->addUser($users))
                  $success_list = $users;
          }
        }
       
       
     
       $this->excel_data['failed'] = $failed_list;
       $this->excel_data['success'] = $success_list;

       flash('success','record_added_successfully', 'success');
       $this->downloadExcel();

     }

     catch( Exception $e)
     {
       if(getSetting('show_foreign_key_constraint','module'))
       {

          flash('oops...!',$e->errorInfo, 'error');
       }
       else {
          flash('oops...!','improper_sheet_uploaded', 'error');
       }

       return back();
     }

        // URL_USERS_IMPORT_REPORT
       $data['failed_list']   =   $failed_list;
       $data['success_list']  =    $success_list;
       $data['records']      = FALSE;
       $data['layout']      = getLayout();
       $data['active_class'] = 'users';
       $data['heading']      = getPhrase('users');
       $data['title']        = getPhrase('report');
      
       // return view('users.import.import-result', $data);

         $view_name = getTheme().'::users.import.import-result';
        return view($view_name, $data);
 
     }

public function getFailedData()
{
  return $this->excel_data;
}

public function downloadExcel()
{
    Excel::create('users_report', function($excel) {
      $excel->sheet('Failed', function($sheet) {
      $sheet->row(1, array('Reason','Name', 'Username','Email','Password','Phone','Address'));
      $data = $this->getFailedData();
      $cnt = 2;
      // dd($data['failed']);
      foreach ($data['failed'] as $data_item) {
        $item = $data_item->record;
        $sheet->appendRow($cnt++, array($data_item->type, $item->name, $item->username, $item->email, $item->password, $item->phone, $item->address));
      }
    });

    $excel->sheet('Success', function($sheet) {
      $sheet->row(1, array('Name', 'Username','Email','Password','Phone','Address'));
      $data = $this->getFailedData();
      $cnt = 2;
      foreach ($data['success'] as $data_item) {
        $item = $data_item;
        $sheet->appendRow($cnt++, array($item->name, $item->username, $item->email, $item->password, $item->phone, $item->address));
      }

    });

    })->download('xlsx');

    return TRUE;
}
     /**
      * This method verifies if the record exists with the email or user name
      * If Exists it returns true else it returns false
      * @param  [type]  $value [description]
      * @param  string  $type  [description]
      * @return boolean        [description]
      */
     public function isRecordExists($record_value, $type='email')
     {
        return User::where($type,'=',$record_value)->get()->count();
     }

     public function addUser($users)
     {
      foreach($users as $request) {
        $user           = new User();
        $name           = $request->name;
        $user->name     = $name;
        $user->email    = $request->email;
        //$inst_name           = $request->inst_name;
        $user->username    = $request->username;
        $user->password = bcrypt($request->password);

        $user->role_id        = $request->role_id;
        $user->login_enabled  = 1;
        $user->slug           = $user::makeSlug($name);
        $user->phone        = $request->phone;
        $user->address      = $request->address;

        $user->activation_code = str_random(30);
        $link = URL_USERS_CONFIRM.$user->activation_code;

        $user->save();

        $user->roles()->attach($user->role_id);

        if(!env('DEMO_MODE')) {
            try {

              $user->notify(new \App\Notifications\NewUserRegistration( $user, $user->email, $request->password, $link ) );

              
            } catch(Exception $e) {
              // dd($e->getMessage());
            }
        }

      }
       return true;
     }

  /**
   * This method shows the user preferences based on provided user slug and settings available in table.
   * @param  [type] $slug [description]
   * @return [type]       [description]
   */
  public function settings($slug)
  {
       $record = User::where('slug', $slug)->first();
       
        if($isValid = $this->isValidRecord($record))
         return redirect($isValid);
       /**
        * Validate the non-admin user wether is trying to access other user profile
        * If so return the user back to previous page with message
        */
       
        if(!isEligible($slug))
          return back();
        

        /**
         * Make sure the Admin or staff cannot edit the Admin/Owner accounts
         * Only Owner can edit the Admin/Owner profiles
         * Admin can edit his own account, in that case send role type admin on condition
         */
        
     $UserOwnAccount = FALSE;
     if(\Auth::user()->id == $record->id)
      $UserOwnAccount = TRUE;
    
      if(!$UserOwnAccount)  {
        $current_user_role = getRoleData($record->role_id);

        if((($current_user_role=='admin' || $current_user_role == 'owner') ))
        {
          if(!checkRole(getUserGrade(1))) {
            prepareBlockUserMessage();
            return back();
          }
        }

      } 



       $data['record']            = $record;
       $data['quiz_categories']   = App\QuizCategory::get();
       $data['lms_category']      = App\LmsCategory::get();

       // dd($data);
       $data['layout']       = getLayout();
       $data['active_class'] = 'users';
       $data['heading']      = getPhrase('account_settings');
       $data['title']        = getPhrase('account_settings');
      // flash('success','record_added_successfully', 'success');
       // return view('users.account-settings', $data);

        $view_name = getTheme().'::users.account-settings';
        return view($view_name, $data);

} 
  
  /**
   * This method updates the user preferences based on the provided categories
   * All these settings will be stored under Users table settings field as json format
   * @param  Request $request [description]
   * @param  [type]  $slug    [description]
   * @return [type]           [description]
   */
  public function updateSettings(Request $request, $slug)
  {
        $record = User::where('slug', $slug)->first();
       
        if($isValid = $this->isValidRecord($record))
         return redirect($isValid);
       /**
        * Validate the non-admin user wether is trying to access other user profile
        * If so return the user back to previous page with message
        */
       
        if(!isEligible($slug))
          return back();
        

        /**
         * Make sure the Admin or staff cannot edit the Admin/Owner accounts
         * Only Owner can edit the Admin/Owner profiles
         * Admin can edit his own account, in that case send role type admin on condition
         */
        
     $UserOwnAccount = FALSE;
     if(\Auth::user()->id == $record->id)
      $UserOwnAccount = TRUE;
    
      if(!$UserOwnAccount)  {
        $current_user_role = getRoleData($record->role_id);

        if((($current_user_role=='admin' || $current_user_role == 'owner') ))
        {
          if(!checkRole(getUserGrade(1))) {
            prepareBlockUserMessage();
            return back();
          }
        }
      }

    $options = [];
    if($record->settings)
    {
      $options =(array) json_decode($record->settings)->user_preferences;
      
    }

    $options['quiz_categories'] = [];
    $options['lms_categories']  = [];
    if($request->has('quiz_categories')) {
    foreach($request->quiz_categories as $key => $value)
      $options['quiz_categories'][] = $key;
    }
    if($request->has('lms_categories')) {
      foreach($request->lms_categories as $key => $value)
        $options['lms_categories'][] = $key;
    }
    
    $record->settings = json_encode(array('user_preferences'=>$options));
    
    $record->save();
  
    flash('success','record_updated_successfully', 'success');
     return back();
  }  

  
  public function viewParentDetails($slug)
  {
     if(!checkRole(getUserGrade(4)))
        {
          prepareBlockUserMessage();
          return back();
        }

       $record = User::where('slug', '=', $slug)->first();
       
       if($isValid = $this->isValidRecord($record))
         return redirect($isValid);

       $data['layout']       = getLayout();
       $data['active_class'] = 'users';
       $data['record']       = $record;

       $data['heading']      = getPhrase('parent_details');
       $data['title']        = getPhrase('parent_details');
       // return view('users.parent-details', $data); 

         $view_name = getTheme().'::users.parent-details';
        return view($view_name, $data);   
  }

  public function updateParentDetails(Request $request, $slug)
  {
     
     if(!checkRole(getUserGrade(4)))
        {
          prepareBlockUserMessage();
          return back();
        }

    
    $user                   = User::where('slug', '=', $slug)->first();
        $role_id = getRoleData('parent');
        $message = '';
        $hasError = 0;
        
        DB::beginTransaction();
        if($request->account == 0)
        {
            //User is not having an account, create it and send email
            //Update the newly created user ID to the current user parent record
            $parent_user = new User();
            $parent_user->name = $request->parent_name;
            $parent_user->username = $request->parent_user_name;
            $parent_user->role_id = $role_id;
            $parent_user->slug = $parent_user::makeSlug($request->parent_user_name);
            $parent_user->email = $request->parent_email;
            $parent_user->password = bcrypt('password');
          
        try{
            $parent_user->save();
            $parent_user->roles()->attach($role_id);
            $user->parent_id = $parent_user->id;
            $user->save();
            
            sendEmail('registration', array('user_name'=>$user->name, 'username'=>$user->username, 'to_email' => $user->email, 'password'=>$parent_user->password));

            DB::commit();
            $message = 'record_updated_successfully';
        }
        catch(Exception $ex){
            DB::rollBack();
            $hasError = 1;
            $message = $ex->getMessage();
        }
    }
        if($request->account == 1)
        {
            try{
             $user->parent_id =  $request->parent_user_id;
             $user->save();
             DB::commit();
            }
            catch(Exception $ex)
            {
                $hasError = 1;
                DB::rollBack();
                $message = $ex->getMessage();
            }
        }
        if(!$hasError)
            flash('success',$message, 'success');
        else 
            flash('Ooops',$message, 'error');
        return back();
  }


  public function getParentsOnSearch(Request $request)
  {
        $term = $request->search_text;
        $role_id = getRoleData('parent');
        $records = App\User::
            where('name','LIKE', '%'.$term.'%')
            ->orWhere('username', 'LIKE', '%'.$term.'%')
            ->orWhere('phone', 'LIKE', '%'.$term.'%')
            ->groupBy('id')  
            ->havingRaw('role_id='.$role_id)
            ->select(['id','role_id','name', 'username', 'email', 'phone'])
            ->get();
            return json_encode($records);
  }




   /**
     * Course listing method
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function SubscribedUsers()
    {
        if(!checkRole(getUserGrade(2)))
        {
          prepareBlockUserMessage();
          return back();
        }

        $data['active_class']       = 'users';
        $data['title']              = getPhrase('subscribed_users');
      // return view('exams.quizcategories.list', $data);

         $view_name = getTheme().'::users.subscribeduser';
        return view($view_name, $data);
    }

    /**
     * This method returns the datatables data to view
     * @return [type] [description]
     */
    public function SubscribersData()
    {

      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }

        $records = array();

        
        $records = App\UserSubscription::select(['email', 'created_at'])
                                     ->orderBy('updated_at', 'desc');
             

        return Datatables::of($records)
        ->make();

   }





    public function changeStatus($slug)
    {
        if(!checkRole(getUserGrade(1)))
        {
          prepareBlockUserMessage();
          return back();
        }
        
        $record = User::where('slug', $slug)->first();
       
        /**
         * Check if any exams exists with this category, 
         * If exists we cannot delete the record
         */
          if(!env('DEMO_MODE')) {
                

            $previous_status = $record->login_enabled;     
            if ($previous_status)
              $record->login_enabled = 0;
            else
              $record->login_enabled = 1;

            $record->save();


            $message = getPhrase('account_status_changed_successfully').' ';


              try {
                $user = getUserRecord($record->id);

                $user->notify(new \App\Notifications\AccountStatusNotification($user,$user->email));

                $message .= getPhrase('email_sent_to_user');

              } catch(Exception $e) {

                $message .= getPhrase('email_not_sent_to_user');
              }

          }


            $response['status'] = 1;
            $response['message'] = $message;
            return json_encode($response);
    }

}

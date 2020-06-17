<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App;
use Twilio\Rest\Client;
use Auth;
use App\User;
use App\Institution;
use App\Quiz;
use App\UserSubscription;
use SMS;
use DB;
use Artisan;

// use Illuminate\Support\Facades\App;

class DevHomeController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function index()
    {
        if(!checkRole(getUserGrade(1)))
        {
          prepareBlockUserMessage();
          return back();
        }

          $data['active_class'] = 'Dev';
          $data['layout']       = getLayout();
          $data['title']        = getPhrase('Dev');
          $data['users']        = User::where('login_enabled',0)->where('role_id',2)->where('is_verified',1)->get();
           $view_name = getTheme().'::dev.home';
          return view($view_name, $data);
    }


    public function users()
    {
        if(!checkRole(getUserGrade(1)))
        {
          prepareBlockUserMessage();
          return back();
        }

          $data['active_class'] = 'Dev';
          $data['layout']       = getLayout();
          $data['title']        = getPhrase('Dev');
          $data['users']        = UserSubscription::all();
          // return view('feedbacks.list', $data);
           $view_name = getTheme().'::dev.users';
          return view($view_name, $data);
    }


    public function profile()
    {
        if(!checkRole(getUserGrade(1)))
        {
          prepareBlockUserMessage();
          return back();
        }

          $data['active_class'] = 'Dev';
          $data['layout']       = getLayout();
          $data['title']        = getPhrase('Dev');
      	  // return view('feedbacks.list', $data);
           $view_name = getTheme().'::dev.profile';
          return view($view_name, $data);
    }


    public function acceptRequest(Request $request){
        if(!checkRole(getUserGrade(1)))
        {
          prepareBlockUserMessage();
          return back();
        }

        $user = User::getRecordWithSlug($request->slug);
        $user->login_enabled = 1;
        $password       = str_random(6);
        $user->password       = bcrypt($password);
        $user->save();

        try
        {
            if (!env('DEMO_MODE')) {

             $user->notify(new \App\Notifications\NewUserAccepted($user,$user->email,$password));
            }

        }
        catch(Exception $ex)
        {

        }
        return redirect(URL_DEV_DASHBOARD);
    }


}

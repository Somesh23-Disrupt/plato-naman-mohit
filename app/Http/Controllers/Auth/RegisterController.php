<?php

namespace App\Http\Controllers\Auth;


use App\User;
use App\Institution;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
         return Validator::make($data, [
            'username' => 'required|max:255|unique:users',
            'name' => 'required|max:255',
            'inst_name' => 'required|max:255|min:3',
            'department' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }
	
	public function getRegister( $role = 'user' )
	{
        $data['active_class']   = 'register';
		$data['title'] 	= getPhrase('register');

         $rechaptcha_status    = getSetting('enable_rechaptcha','recaptcha_settings');
         $data['rechaptcha_status']  = $rechaptcha_status;

		// return view('auth.register', $data);
           $view_name = getTheme().'::auth.register';
        return view($view_name, $data);
	}

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function postRegister(Request $request)
     {
        
        $rechaptcha_status    = getSetting('enable_rechaptcha','recaptcha_settings');

        if ( $rechaptcha_status  == 'yes') {

           $columns = array(
                        'name'     => 'bail|required|max:20|',
                        'username' => 'bail|required|unique:users,username',
                        'inst_name'     => 'bail|required|max:255|min:3|exists:institutions,institution_name',
                        'department'     => 'bail|required|max:200|',
                        'email'    => 'bail|required|unique:users,email',
                        'password' => 'bail|required|min:5',
                        'password_confirmation'=>'bail|required|min:5|same:password',
                        'g-recaptcha-response' => 'required|captcha',
                        );
       

                      $messsages = array(
                            'inst_name'=>'Institution Does Not Exists',
                          'g-recaptcha-response.required'=>'Please Select Captcha',
                   
                     );

               $this->validate($request,$columns,$messsages);

            }
             else {

                $columns = array(
                            'name'     => 'bail|required|max:20|',
                            'username' => 'bail|required|unique:users,username',
                            'inst_name'     => 'bail|required|max:200|min:3|exists:institutions,institution_name',
                            'department'     => 'bail|required|max:20|',
                            'email'    => 'bail|required|unique:users,email',
                            'password' => 'bail|required|min:5',
                            'password_confirmation'=>'bail|required|min:5|same:password',
                            );
                 $messsages = array(
                                'inst_name.exists'=>'Institution Does Not Exists',
                       
                         );
           
                  $this->validate($request,$columns,$messsages);

            }
        
        


        $role_id = STUDENT_ROLE_ID;
        if ($request->is_student==1)
            $role_id = PARENT_ROLE_ID;


        $user           = new User();

        // Logic For Institution Id

        // if ($institution=Institution::where('institution_name',$request->inst_name)->first()) {
            $institution=Institution::where('institution_name',$request->inst_name)->first();
            $user->inst_id=$institution->id;
            $user->inst_name= $institution->institution_name;
        // }else{
        //     $institution= new Institution;
        //     $institution->institution_name=$request->inst_name;
        //     $institution->save();
        //     $user->inst_id=$institution->id;
            
        // }


        $name           = $request->name;
        
        $user->name     = $name;
        $user->username = $request->username;
        
        $user->department=$request->department;
        $user->email    = $request->email;
        $password       = $request->password;
        $user->password       = bcrypt($password);
        $user->role_id        = $role_id;
        $user->teacher_id        = 0;

        $slug = $user::makeSlug($name);
        $user->slug           = $slug;


        $user->activation_code = str_random(30);
        //$link = URL_USERS_CONFIRM.$user->activation_code;

        $user->login_enabled  = 1;
           
        $user->save();

       
        $user->roles()->attach($user->role_id);

      /*  try 
        {
            if (!env('DEMO_MODE')) {

             $user->notify(new \App\Notifications\NewUserRegistration($user,$user->email,$password, $link ));
            }

        }
        catch(Exception $ex)
        {
         
        }*/
        flash('success','You_have_registered_successfully!', 'overlay');
        return redirect( URL_USERS_LOGIN );
     }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
		$name = $data['first_name'] . ' ' . $data['last_name'];
		$user    = new User();
        if ($institution=Institution::where('institution_name',$data['inst_name'])->first()) {
            $user->inst_id=$institution->id;
        }else{
            $institution= new Institution;
            $institution->institution_name=$data['inst_name'];
            $institution->save();
            $user->inst_id=$institution->id;
        }
		$user->name     = $name;
        $user->first_name     = $data['first_name'];
        $user->last_name    = $data['last_name'];
        $user->inst_name    = $data['inst_name'];
        $user->department   = $data['department'];
		$user->email     = $data['email'];
        $user->password = bcrypt($data['password']);
        if( $data['role'] == 'vendor' ) {
			$user->role_id  = VENDOR_ROLE_ID;
		} else {
			$user->role_id  = USER_ROLE_ID;
		}
        $user->slug     = $user->makeSlug($user->name);
		$user->confirmation_code = str_random(30);
		//$link = URL_USERS_CONFIRM.'/'.$user->confirmation_code;
		$user->save();
		$user->roles()->attach($user->role_id);
		try{
        sendEmail('registration', array('user_name'=>$user->email, 'username'=>$user->email, 'to_email' => $user->email, 'password'=>$data['password']));
          }
         catch(Exception $ex)
        {
            
        }
		flash('Success','You Have Registered Successfully.', 'success');
		return $user;
    }
	
	/**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function register(Request $request)
    {
		$data = array(
			'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'inst_name' => $request->inst_name,
            'department' => $request->department,
			'email' => $request->email,
			'password' => $request->password,
			'role' => $request->role,			
		);
		$name = $data['first_name'] . ' ' . $data['last_name'];
		$user    = new User();
		$user->name     = $name;
        if ($institution=Institution::where('institution_name',$request->inst_name)->first()) {
            $user->inst_id=$institution->id;
        }else{
            $institution= new Institution;
            $institution->institution_name=$request->inst_name;
            $institution->save();
            $user->inst_id=$institution->id;
        }
        $user->first_name     = $data['first_name'];
        $user->last_name    = $data['last_name'];
        $user->inst_name    = $data['inst_name'];
        $user->department   = $data['department'];
		$user->email     = $data['email'];
        $user->password = bcrypt($data['password']);
        if( $data['role'] == 'vendor' ) {
			$user->role_id  = VENDOR_ROLE_ID;
		} else {
			$user->role_id  = USER_ROLE_ID;
		}
        $user->slug     = $user->makeSlug($user->name);
		$user->confirmation_code = str_random(30);
		//$link = URL_USERS_CONFIRM . '/' . $user->confirmation_code;
		$user->save();
		$user->roles()->attach($user->role_id);
		try{
        sendEmail('registration', array('user_name'=>$user->email, 'username'=>$user->email, 'to_email' => $user->email, 'password'=>$data['password']));
          }
         catch(Exception $ex)
        {
            
        }
		flash('success','You Have Registered Successfully.', 'success');
		return redirect( URL_USERS_LOGIN );
    }




    public function studentOnlineRegistration()
    {
        return view('auth.student-online-registration');
    }
}

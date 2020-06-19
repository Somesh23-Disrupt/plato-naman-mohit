<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Routing\Controller;
use \App;
use DB;
use App\User;
use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Notifications\WebPushNotification;
use Notification;


class MessagesController extends Controller
{

     public function __construct()
    {
        $this->middleware('auth');


    }

     /**
     * Show all of the message threads to the user.
     *
     * @return mixed
     */
    public function index()
    {


        if(!getSetting('messaging', 'module'))
        {
            pageNotFound();
            return back();
        }
        $currentUserId = Auth::user()->id;
        // All threads, ignore deleted/archived participants
        // $threads = Thread::getAllLatest()->get();

        // All threads that user is participating in
        $threads = Thread::forUser($currentUserId)->latest('updated_at')->paginate(getRecordsPerPage());
        // All threads that user is participating in, with new messages
        // $threads = Thread::forUserWithNewMessages($currentUserId)->latest('updated_at')->get();
        $data['title']        = getPhrase('create_message');
        $data['active_class'] = 'messages';
        $data['currentUserId']= $currentUserId;
        $data['threads'] 	  = $threads;
        $data['layout']       = getLayout();

        // return view('messaging-system.index', $data);
        $sections=App\User::select(['section_id'])->where('role_id',5)->where('inst_id',auth()->user()->inst_id)->distinct()->pluck('section_id');
        // dd($sections);
        $data['sectionsforteach']= $sections;
         $view_name = getTheme().'::messaging-system.index';
        return view($view_name, $data);
    }
    /**
     * Shows a message thread.
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        if(!getSetting('messaging', 'module'))
        {
            pageNotFound();
            return back();
        }

        try {
            $thread = Thread::findOrFail($id);

        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');
            return redirect('messages');
        }
        // show current user in list if not a current participant
        // $users = User::whereNotIn('id', $thread->participantsUserIds())->get();
        // don't show the current user in list
        $userId = Auth::user()->id;
        $thread_participants = $thread->participants()->get();
        $is_member = 0;
        foreach($thread_participants as $tp)
        {
            if($tp->user_id == $userId) {
                $is_member = 1;
                break;
            }
        }


        if(!$is_member)
        {
            pageNotFound();
            return back();
        }

        $participants = $thread->participantsUserIds($userId);

        $users = User::whereNotIn('id', $participants)->get();

        $thread->markAsRead($userId);

        $data['title']        = getPhrase('messages');
        $data['active_class']        = 'messages';
        $data['thread'] 	= $thread;
        $data['users']  = $users;
        $data['layout'] 	= getLayout();

        // return view('messaging-system.show', $data);
        $sections=App\User::select(['section_id'])->where('role_id',5)->where('inst_id',auth()->user()->inst_id)->distinct()->pluck('section_id');
        // dd($sections);
        $data['sectionsforteach']= $sections;
          $view_name = getTheme().'::messaging-system.show';
        return view($view_name, $data);
        // return view('messenger.show', compact('thread', 'users'));
    }
    /**
     * Creates a new message thread.
     *
     * @return mixed
     */
    public function create()
    {
        if(!getSetting('messaging', 'module'))
        {
            pageNotFound();
            return back();
        }
        if (checkRole(['parent'])) {
            $query = User::where('id', '!=', Auth::id())->where('parent_id',auth()->user()->id);
        }elseif(checkRole(['owner'])){
            $query = User::where('id', '!=', Auth::id());
        }
        elseif (checkRole(['teacher'])) {
            $query = User::where('id', '!=', Auth::id())->where('teacher_id',auth()->user()->id);
        }{
            $query = User::where('id', '!=', Auth::id())->where('inst_id',auth()->user()->inst_id);
        }


       if(getSetting('messaging_system_for','messaging_system')=='admin')
       {
            // If the loggedin user is admin
            // List all the users
             if(!checkRole(getUserGrade(2)))
            {

                $admin_role = getRoleData('admin');
                $owner_role = getRoleData('owner');

                $query->where('role_id', '=', $admin_role)
                  ->orWhere('role_id', '=', $owner_role);
            }

       }

        $users = $query->get();

          $data['title']        = getPhrase('send_message');
        $data['active_class']        = 'messages';
        // $data['currentUserId'] 	= $currentUserId;
        $data['users']  = $users;
        $data['layout'] 	= getLayout();

        // return view('messaging-system.create', $data);
        $sections=App\User::select(['section_id'])->where('role_id',5)->where('inst_id',auth()->user()->inst_id)->distinct()->pluck('section_id');
        // dd($sections);
        $data['sectionsforteach']= $sections;
          $view_name = getTheme().'::messaging-system.create';
        return view($view_name, $data);
        // return view('messenger.create', compact('users'));
    }
     public function store()
    {
        if(!getSetting('messaging', 'module'))
        {
            pageNotFound();
            return back();
        }

        $input = Input::all();
        $participant=[];
        if (Input::has('recipients') || Input::has('sectionrecipients') ) {
            if(Input::has('recipients'))
            $participants=$input['recipients'];
            $sectionrecipients =$input['sectionrecipients'];

            foreach ($sectionrecipients as $key => $value) {
                if($value!=""){
                    $participants[]=User::where('section_id',$value)
                                    ->where('id','!=',Auth::user()->id)
                                    ->orWhere('inst_id',$value)
                                    ->where('id','!=',Auth::user()->id)->pluck('id');
                }

            }
            $participants=array_flatten($participants);
        }
        else{
             flash('Oops...!','please select the recipients', 'overlay');
             return redirect(URL_MESSAGES_CREATE);
        }
        $thread = Thread::create(
            [
                'subject' => $input['subject'],
            ]
        );
        // Message
        Message::create(
            [
                'thread_id' => $thread->id,
                'user_id'   => Auth::user()->id,
                'body'      => $input['message'],
            ]
        );
        // Sender
        Participant::create(
            [
                'thread_id' => $thread->id,
                'user_id'   => Auth::user()->id,
                'last_read' => new Carbon,
            ]
        );
        // Recipients
        if ($participants) {
            $thread->addParticipant($participants);
        }
        return redirect(URL_MESSAGES);
    }

    /**
     * Adds a new message to a current thread.
     *
     * @param $id
     * @return mixed
     */
    public function update(Request $request,$id)
    {

        if(!getSetting('messaging', 'module'))
        {
            pageNotFound();
            return back();
        }

        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');
            return redirect('messages');
        }
        $thread->activateAllParticipants();
        // Message
        Message::create(
            [
                'thread_id' => $thread->id,
                'user_id'   => Auth::id(),
                'body'      => $request->message,
            ]
        );
        // Add replier as a participant
        $participant = Participant::firstOrCreate(
            [
                'thread_id' => $thread->id,
                'user_id'   => Auth::user()->id,
            ]
        );
        $participant->last_read = new Carbon;
        $participant->save();
        $users=$users=User::whereIn('id',DB::table('messenger_participants')->where('thread_id',$id)->pluck('user_id'))
                ->where('id','!=',Auth::user()->id)
                ->get();
        $body=Auth::user()->name .': '.$request->message;
        $title=$thread->subject;
        $action= '/messages'.'/'.$id;//"/messages"."/".$id;
        Notification::send($users,new WebPushNotification($title, $body,'Reply', $action));

        // Recipients
        if (Input::has('recipients')) {
            $thread->addParticipants(Input::get('recipients'));
        }
        //return redirect('messages/' . $id);
        $msg='sent';
        return response()->json(array('msg'=> $msg), 200);
    }

    public function getmsg($id){
        $count = Auth::user()->newThreadsCount();
        $msg="";
        if($count > 0 ){
            $msg = '<div class="message-sender">
                <div class="media">
                    <a class="pull-left" href="#">
                        <img src="'.getProfilePath(Auth::user()->image).'" alt="image" class="img-circle">
                    </a>
                    <div class="media-body">
                        <h5 class="media-heading"><b>name-ajax</b></h5>
                        <p>'.$id.'</p>
                        <div class="text-muted"><small>ajax-created_at</small></div>
                    </div>
                </div>
            </div>';
        }

        return response()->json(array('msg'=> $msg), 200);
    }


}

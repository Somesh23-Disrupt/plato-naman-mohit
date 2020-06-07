<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Institution;
use Yajra\Datatables\Datatables;
use App\User;
use App\Blog;
use Illuminate\Support\Collection;
use Yajra\DataTables\EloquentDataTable;

class InstitutionController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function index($layout_type = '')
    {   
         if(!checkRole(getUserGrade(1)))
        {
          prepareBlockUserMessage();
          return back();
        }
        
        $institution=Institution::select(['institution_name','id'])->get();
        $data['institutions']=$institution;
        $data['records']      = FALSE;
        $data['layout']      = getLayout();
        $data['active_class'] = 'institutions';
        $data['heading']      =  getPhrase('Institutions');
        $data['title']        = getPhrase('Institutions');
        $view_name = getTheme().'::institution.index';
        return view($view_name, $data);

    }
    public function student($slug)
    {   
         if(!checkRole(getUserGrade(1)))
        {
          prepareBlockUserMessage();
          return back();
        }
        $institution=User::where('inst_name',$slug)->where('role_id',5)->get();
        $data['institutions']=$institution;
        $data['records']      = FALSE;
        $data['layout']      = getLayout();
        $data['active_class'] = 'users';
        $data['heading']      =  getPhrase('Students');
        $data['title']        = getPhrase('Students');
        $view_name = getTheme().'::institution.user';
        return view($view_name, $data);

    }
    public function admin($slug)
    {   
         if(!checkRole(getUserGrade(1)))
        {
          prepareBlockUserMessage();
          return back();
        }
        $institution=User::where('inst_name',$slug)->where('role_id',2)->get();
        $data['institutions']=$institution;
        $data['records']      = FALSE;
        $data['layout']      = getLayout();
        $data['active_class'] = 'users';
        $data['heading']      =  getPhrase('Admins');
        $data['title']        = getPhrase('Admins');
        $view_name = getTheme().'::institution.user';
        return view($view_name, $data);

    }
    
    public function teacher($slug)
    {   
         if(!checkRole(getUserGrade(1)))
        {
          prepareBlockUserMessage();
          return back();
        }
        $institution=User::where('inst_name',$slug)->where('role_id',7)->get();
        $data['institutions']=$institution;
        $data['records']      = FALSE;
        $data['layout']      = getLayout();
        $data['active_class'] = 'users';
        $data['heading']      =  getPhrase('Teachers');
        $data['title']        = getPhrase('Teachers');
        $view_name = getTheme().'::institution.user';
        return view($view_name, $data);

    }
    public function parent($slug)
    {   
         if(!checkRole(getUserGrade(1)))
        {
          prepareBlockUserMessage();
          return back();
        }
        $institution=User::where('inst_name',$slug)->where('role_id',6)->get();
        $data['institutions']=$institution;
        $data['records']      = FALSE;
        $data['layout']      = getLayout();
        $data['active_class'] = 'users';
        $data['heading']      =  getPhrase('Parents');
        $data['title']        = getPhrase('Parents');
        $view_name = getTheme().'::institution.user';
        return view($view_name, $data);

    }  



  
}

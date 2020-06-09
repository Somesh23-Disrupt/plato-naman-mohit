@extends('layouts.parent.parentlayout')
@section('header_scripts')
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
	<link href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css" type="text/css">

@endsection

@section('content')


<div id="page-wrapper">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<ol class="breadcrumb">

<li>{{ $title}}</li>
</ol>
</div>
</div>
{{-- 

@if(session()->has('exam_id') && $quiz_data)

   @if($is_purchased && $quiz_data->is_paid == 1 )

    <div class="alert alert-success">
      <strong>{{ ucwords($quiz_data->title)}}</strong> &nbsp;&nbsp; <a onclick="startMyExam()" href="javascript:void(0);" class="btn btn-primary btn-sm">{{getPhrase('click_here_to_take_exam')}}</a>
    </div> 

    @elseif( $quiz_data->is_paid == 0 )

      <div class="alert alert-success">
      <strong>{{ ucwords($quiz_data->title)}}</strong> &nbsp;&nbsp; <a onclick="startMyExam()" href="javascript:void(0);" class="btn btn-primary btn-sm">{{getPhrase('click_here_to_take_exam')}}</a>
    </div> 

    @endif

@endif

@if(session()->has('series_quiz_slug') &&  $series_exam_link )
   

     <div class="alert alert-success">
      <strong>{{ ucwords($series_quiz_data->title)}}</strong> &nbsp;&nbsp; <a onclick="startMySeriesExam()" href="javascript:void(0);" class="btn btn-primary btn-sm">{{getPhrase('click_here_to_take_exam')}}</a>
    </div> 

@endif --}}


    <!-- <div class="row">
      <div class="col-md-4 col-sm-6">
        <div class="media state-media box-ws">
          <div class="media-left">
            <a href="{{URL_STUDENT_EXAM_CATEGORIES}}"><div class="state-icn bg-icon-info"><i class="fa fa-list-alt"></i></div></a>
          </div>
          <div class="media-body">
            <h4 class="card-title">{{ count(App\User::getUserSeleted('categories'))}}</h4>
            <a href="{{URL_STUDENT_EXAM_CATEGORIES}}">{{ getPhrase('quiz_categories')}}</a>
          </div>
        </div>
      </div> -->
       {{-- <div class="col-md-4 col-sm-6">
        <div class="media state-media box-ws">
          <div class="media-left">
            <a href="{{ URL_STUDENT_EXAM_ALL }}"><div class="state-icn bg-icon-pink"><i class="fa fa-desktop"></i></div></a>
          </div>
          <div class="media-body">
            <h4 class="card-title">{{ App\User::getUserSeleted('quizzes',$child_id) }}</h4>
            <a href="{{ URL_STUDENT_EXAM_ALL }}">{{ getPhrase('quizzes')}}</a>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-6">
        <div class="media state-media box-ws">
          <div class="media-left">
            <div class="state-icn bg-icon-pink"><i class="fa fa-desktop"></i></div>
          </div>
          <div class="media-body">
            <h4 class="card-title">{{ $examattend }}</h4>
            {{ getPhrase('Exam Attended')}}
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-6">
        <div class="media state-media box-ws">
          <div class="media-left">
            <a href="{{ URL_STUDENT_LMS_CATEGORIES }}"><div class="state-icn bg-icon-purple"><i class="fa fa-tv"></i></div></a>
          </div>
          <div class="media-body">
            <h4 class="card-title">{{ App\User::getUserSeleted('lms_categories') }}</h4>
            <a href="{{ URL_STUDENT_LMS_CATEGORIES }}">LMS {{ getPhrase('categories')}}</a>
          </div>
        </div>
      </div> 
      <div class="col-md-3 col-sm-6">
        <div class="media state-media box-ws">
          <div class="media-left">
            <a href="{{URL_SUBJECTS}}"><div class="state-icn bg-icon-success"><i class="fa fa-book"></i></div></a>
          </div>
          <div class="media-body">
            <h4 class="card-title">{{ App\Subject::get()->count()}}</h4>
            <a href="{{URL_SUBJECTS}}">{{ getPhrase('subjects')}}</a>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="media state-media box-ws">
          <div class="media-left">
            <div class="state-icn bg-icon-orange"><i class="fa fa-question-circle"></i></div>
          </div>
          <div class="media-body">
            <h4 class="card-title">{{ $passpercent[$title] }}</h4>
            {{ getPhrase('total pass percentage')}}
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="media state-media box-ws">
          <div class="media-left">
            <a href=""><div class="state-icn bg-icon-orange"><i class="fa fa-question-circle"></i></div></a>
          </div>
          <div class="media-body">
            <h4 class="card-title">{{round($avgscore,2) }}</h4>
            <a href="">{{ getPhrase('average Score in All quizzes')}}</a>
          </div>
        </div>
      </div>  --}}

      <div class="col-md-12">  				  
        <div class="panel panel-primary dsPanel">				   				    
          <div class="panel-body" >
			<table class="table table-striped table-bordered datatable" id="datatable" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>{{ getPhrase('Test Name')}}</th>
						<th>{{ getPhrase('Subject')}}</th>
						<th>{{ getPhrase('Total_Marks')}}</th>
						<th>{{ getPhrase('Scored Marks')}}</th>
						<th>{{ getPhrase('Percentage')}}</th>
					</tr>
				</thead>
				@foreach($tables as $table)
				 
					<tr>
            <td>{{App\QuizCategory::find($table->category_id)->category}}</td>
            <td>{{$table->title}}</td>
            <td>{{$table->total_marks}}</td>		
            <td>{{$table->marks_obtained}}</td>
            <td>{{round(($table->marks_obtained/$table->total_marks)*100,2)}}</td>
					</tr>
			
				@endforeach
			</table>
		</div>
			</div>
</div>
  
    

    <?php $ids=[];?>
    @for($i=0; $i<count($chart_data); $i++)
    <?php 
    $newid = 'myChart'.$i;
    $ids[] = $newid; ?>

    <div class="col-md-6">  				  
      <div class="panel panel-primary dsPanel">				   				    
        <div class="panel-body" >



    <canvas id="{{$newid}}" width="100" height="60"></canvas>					
      </div>				
        </div>				
    </div>

    @endfor	
          
    </div>
    </div>
    <!-- /.container-fluid -->
    </div>
<!-- /#page-wrapper -->

@stop

@section('footer_scripts')
@include('common.chart', array($chart_data,'ids' =>$ids,'scale'=>TRUE));
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>

<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#datatable').DataTable({
				dom: 'Bfrtip',
	            buttons: [
				            'copy', 'csv', 'excel', 'pdf', 'print'

				        ],
				
			});
        });
    </script>
 


@stop
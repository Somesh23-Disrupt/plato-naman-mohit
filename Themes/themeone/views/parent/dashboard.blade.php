@extends('layouts.parent.parentlayout')
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
				 <div class="row">
			
	<?php $data=App\User::getUserSeleted('quizzes');
		// dd($data);
		?>
	@foreach ($data as $dat)
		{{-- {{dd($dat)}} --}}
	
	<div class="col-md-4 col-sm-6">
 		<div class="media state-media box-ws">
 			<div class="media-left">
 				<a href="{{URL_STUDENT_EXAM_CATEGORIES}}"><div class="state-icn bg-icon-info"><i class="fa fa-list-alt"></i></div></a>
 			</div>
 			<div class="media-body">
 				<h4 class="card-title">{{ count($dat['lmscats'])-1}}</h4>
				<a href="{{URL_STUDENT_EXAM_CATEGORIES}}">{{ getPhrase('lms_categories_for_').getPhrase($dat['lmscats']['name'])}}</a>
 			</div>
 		</div>
	 </div> 
	 <div class="col-md-4 col-sm-6">
		<div class="media state-media box-ws">
			<div class="media-left">
				<div class="state-icn bg-icon-pink"><i class="fa fa-desktop"></i></div>
			</div>
			<div class="media-body">
				<h4 class="card-title">{{ $dat['quiz']['quiz'] }}</h4>
			   {{ getPhrase('quizzes_for_').getPhrase($dat['quiz']['name'])}}</a>
			</div>
		</div>
	</div>    
	@endforeach
	@foreach ($examattends as $examattend)
		{{-- {{dd($examattend)}} --}}
	
	 <div class="col-md-4 col-sm-6">
        <div class="media state-media box-ws">
          <div class="media-left">
            <div class="state-icn bg-icon-pink"><i class="fa fa-desktop"></i></div>
          </div>
          <div class="media-body">
            <h4 class="card-title">{{ $examattend['atemp'] }}</h4>
            {{ getPhrase('Exam Attended By ').getPhrase($examattend['name'])}}
          </div>
        </div>
      </div>
	@endforeach
	@foreach ($tnps as $tnp)
		{{-- {{dd($tnp)}} --}}
	
	 <div class="col-md-4 col-sm-6">
        <div class="media state-media box-ws">
          <div class="media-left">
            <div class="state-icn bg-icon-pink"><i class="fa fa-desktop"></i></div>
          </div>
          <div class="media-body">
            <h4 class="card-title">{{ $tnp['per'] }}</h4>
            {{ getPhrase('Average Pass Percentage for ').getPhrase($tnp['name'])}}
          </div>
        </div>
      </div>
	@endforeach
	 <!-- <div class="col-md-3 col-sm-6">
		<div class="media state-media box-ws">
		<div class="media-left">
			<a href="{{URL_SUBJECTS}}"><div class="state-icn bg-icon-success"><i class="fa fa-book"></i></div></a>
		</div>
		<div class="media-body">
			<h4 class="card-title">{{ App\Subject::get()->count()}}</h4>
			<a href="{{URL_SUBJECTS}}">{{ getPhrase('subjects')}}</a>
		</div>
		</div>
	</div> -->
	{{-- <div class="col-md-3 col-sm-6">
		<div class="media state-media box-ws">
		<div class="media-left">
			<div class="state-icn bg-icon-orange"><i class="fa fa-question-circle"></i></div>
		</div>
		<div class="media-body">
			<h4 class="card-title">{{ $tppforteach }}</h4>
			{{ getPhrase('Total Pass Percentage')}}
		</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-6">
		<div class="media state-media box-ws">
			<div class="media-left">
				<div class="state-icn bg-icon-purple"><i class="fa fa-users"></i></div>
			</div>
			<div class="media-body">
				<h4 class="card-title">{{ $tnps }}</h4>
				{{ getPhrase('Total Pass Children')}}
			</div>
		</div>
	</div> --}}

 	<div class="col-md-4 col-sm-6">
 		<div class="media state-media box-ws">
 			<div class="media-left">
 				<a href="{{URL_PARENT_CHILDREN}}"><div class="state-icn bg-icon-purple"><i class="fa fa-user-circle"></i></div></a>
 			</div>
 			<div class="media-body">
 				<h4 class="card-title">{{ App\User::where('parent_id', '=', $user->id)->get()->count()}}</h4>
				<a href="{{URL_PARENT_CHILDREN}}">{{ getPhrase('children')}}</a>
 			</div>
 		</div>
 	</div>
	@for($i=0; $i<count($childs_names);$i++)
	<div class="col-md-4 col-sm-6">
 		<div class="media state-media box-ws">
 			<div class="media-left">
 				<div class="state-icn bg-icon-purple"><i class="fa fa-user-circle"></i></div></a>
 			</div>
 			<div class="media-body">
 				<h4 class="card-title">{{ $childs_totals[$i]}}</h4>
				{{ getPhrase('avg_score_of ').getPhrase($childs_names[$i])}}
 			</div>
 		</div>
 	</div>
 	@endfor
	 

				 
				</div>
				
<div class="row">

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
  
@endsection

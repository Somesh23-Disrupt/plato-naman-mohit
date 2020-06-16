@extends('layouts.admin.adminlayout')
@section('header_scripts')
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">

@endsection

@section('content')

<div id="page-wrapper">
			<div class="container-fluid">
			<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">

							<li><i class="fa fa-home"></i> {{ $title}}</li>
						</ol>
					</div>
				</div>

				 <div class="row">
				 	<div class="col-md-3 col-sm-6">
				 		<div class="media state-media box-ws">
				 			<div class="media-left">
				 				<a href="{{URL_USERS}}"><div class="state-icn bg-icon-info"><i class="fa fa-users"></i></div></a>
				 			</div>
				 			<div class="media-body">
				 				<h4 class="card-title">{{ App\User::where('inst_id',auth()->user()->inst_id)->where('role_id',5)->count()}}</h4>
								<a href="{{URL_USERS}}">{{ getPhrase('Students')}}</a>
				 			</div>
				 		</div>
				 	</div>
				 	<div class="col-md-3 col-sm-6">
				 		<div class="media state-media box-ws">
				 			<div class="media-left">
				 				<a href="{{URL_USERS}}"><div class="state-icn bg-icon-info"><i class="fa fa-users"></i></div></a>
				 			</div>
				 			<div class="media-body">
				 				<h4 class="card-title">{{ App\User::where('inst_id',auth()->user()->inst_id)->where('role_id',3)->count()}}</h4>
								<a href="{{URL_USERS}}">{{ getPhrase('teachers')}}</a>
				 			</div>
				 		</div>
				 	</div>
					<!-- <div class="col-md-3 col-sm-6">
				 		<div class="media state-media box-ws">
				 			<div class="media-left">
				 				<a href="{{URL_QUIZ_CATEGORIES}}"><div class="state-icn bg-icon-pink"><i class="fa fa-list-alt"></i></div></a>
				 			</div>
				 			<div class="media-body">
				 				<h4 class="card-title">{{ App\QuizCategory::get()->count()}}</h4>
								<a href="{{URL_QUIZ_CATEGORIES}}">{{ getPhrase('quiz_categories')}}</a>
				 			</div>
				 		</div>
				 	</div> -->
				 	<div class="col-md-3 col-sm-6">
				 		<div class="media state-media box-ws">
				 			<div class="media-left">
				 				<a href="{{URL_QUIZZES}}"><div class="state-icn bg-icon-purple"><i class="fa fa-desktop"></i></div></a>
				 			</div>
				 			<div class="media-body">
				 				<h4 class="card-title">{{ App\Quiz::get()->count()}}</h4>
								<a href="{{URL_QUIZZES}}">{{ getPhrase('quizzes')}}</a>
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

				 	 {{-- <div class="col-md-3 col-sm-6">
				 		<div class="media state-media box-ws">
				 			<div class="media-left">
				 				<a href="{{URL_TOPICS}}"><div class="state-icn bg-icon-purple"><i class="fa fa-list"></i></div></a>
				 			</div>
				 			<div class="media-body">
				 				<h4 class="card-title">{{ App\Topic::get()->count() }}</h4>
								<a href="{{URL_TOPICS}}">{{ getPhrase('topics')}}</a>
				 			</div>
				 		</div>
				 	</div> --}}


				 	 <div class="col-md-3 col-sm-6">
				 		<div class="media state-media box-ws">
				 			<div class="media-left">
				 				<a href="{{URL_QUIZ_QUESTIONBANK}}"><div class="state-icn bg-icon-orange"><i class="fa fa-question-circle"></i></div></a>
				 			</div>
				 			<div class="media-body">
				 				<h4 class="card-title">{{ App\QuestionBank::get()->count() }}</h4>
								<a href="{{URL_QUIZ_QUESTIONBANK}}">{{ getPhrase('questions')}}</a>
				 			</div>
				 		</div>
					 </div>
					 <div class="col-md-3 col-sm-6">
						<div class="media state-media box-ws">
							<div class="media-left">
								<a href="{{URL_QUIZ_QUESTIONBANK}}"><div class="state-icn bg-icon-orange"><i class="fa fa-question-circle"></i></div></a>
							</div>
							<div class="media-body">
								<h4 class="card-title">{{App\User::select('section_id')->where('role_id',5)->where('inst_id',Auth::user()->inst_id)->distinct('section_id')->get()->count()
								 }}</h4>
							   <a href="">{{ getPhrase('section')}}</a>
							</div>
						</div>
					</div>
					{{-- <div class="col-md-3 col-sm-6">
				 		<div class="media state-media box-ws">
				 			<div class="media-left">
				 				<a href="{{URL_EXAM_SERIES}}"><div class="state-icn bg-icon-orange"><i class="fa fa-question-circle"></i></div></a>
				 			</div>
				 			<div class="media-body">
				 				<h4 class="card-title">{{ App\ExamSeries::all()->count() }}</h4>
								<a href="{{URL_EXAM_SERIES}}">{{ getPhrase('Exam Series')}}</a>
				 			</div>
				 		</div>
				 	</div> --}}
					<!-- <div class="col-md-3 col-sm-6">
				 		<div class="media state-media box-ws">
				 			<div class="media-left">
				 				<a href=""><div class="state-icn bg-icon-orange"><i class="fa fa-question-circle"></i></div></a>
				 			</div>
				 			<div class="media-body">
				 				<h4 class="card-title">{{ App\ExamTopper::where('percentage','>=',50)->count() }}</h4>
								<a href="">{{ getPhrase('Topper Students')}}</a>
				 			</div>
				 		</div>
				 	</div> -->
				 	{{-- <div class="col-md-3 col-sm-6">
				 		<div class="media state-media box-ws">
				 			<div class="media-left">
				 				<a href=""><div class="state-icn bg-icon-orange"><i class="fa fa-question-circle"></i></div></a>
				 			</div>
				 			<div class="media-body">
				 				<h4 class="card-title">{{ App\User::where('inst_id',auth()->user()->inst_id)->where('role_id'37)->where('login_enabled',1)->count() }}</h4>
								<a href="">{{ getPhrase('Active Teachers')}}</a>
				 			</div>
				 		</div>
				 	</div> --}}
				 	<div class="col-md-3 col-sm-6">
				 		<div class="media state-media box-ws">
				 			<div class="media-left">
				 				<a href=""><div class="state-icn bg-icon-orange"><i class="fa fa-question-circle"></i></div></a>
				 			</div>
				 			<div class="media-body">
				 				<h4 class="card-title">{{ round($avgscacrquizes, 2)}}</h4>
								<a href="">{{ getPhrase('Avg Score across quizzes')}}</a>
				 			</div>
				 		</div>
				 	</div>
					 <div class="col-md-3 col-sm-6">
						<div class="media state-media box-ws">
							<div class="media-left">
								<div class="state-icn bg-icon-orange"><i class="fa fa-question-circle"></i></div>
							</div>
							<div class="media-body">
								<h4 class="card-title">{{ $tppforteach }}</h4>
								<a>{{ getPhrase('Avg Pass Percentage')}}</a>
							</div>
						</div>
					</div>

				 	 <!-- <div class="col-md-3 col-sm-6">
				 		<div class="media state-media box-ws">
				 			<div class="media-left">
				 				<a href="{{URL_SUBSCRIBED_USERS}}"><div class="state-icn bg-icon-blue"><i class="fa fa-users"></i></div></a>
				 			</div>
				 			<div class="media-body">
				 				<h4 class="card-title">{{  App\UserSubscription::get()->count() }}</h4>
								<a href="{{URL_SUBSCRIBED_USERS}}">{{ getPhrase('subscribed_users')}}</a>
				 			</div>
				 		</div>
				 	</div>

				 		 <div class="col-md-3 col-sm-6">
				 		<div class="media state-media box-ws">
				 			<div class="media-left">
				 				<a href="{{URL_THEMES_LIST}}"><div class="state-icn bg-icon-pink"><i class="fa fa-fw fa-th-large" ></i> </div></a>
				 			</div>
				 			<div class="media-body">
				 				<h4 class="card-title">{{ App\SiteTheme::get()->count() }}</h4>
								<a href="{{URL_THEMES_LIST}}">{{ getPhrase('themes')}}</a>
				 			</div>
				 		</div>
				 	</div>
 -->
				</div>

			<!-- /.container-fluid -->

 	<!-- <div class="col-md-6">
  				  <div class="panel panel-primary dsPanel">
				    <div class="panel-heading"><i class="fa fa-pie-chart"></i> {{getPhrase('quizzes_usage')}}</div>
				    <div class="panel-body" >
				    	<canvas id="demanding_quizzes" width="100" height="60"></canvas>
				    </div>
				  </div>
				</div>


				<div class="col-md-6">
  				  <div class="panel panel-primary dsPanel">
				    <div class="panel-heading"><i class="fa fa-pie-chart"></i> {{getPhrase('paid_quizzes_usage')}}</div>
				    <div class="panel-body" >
				    	<canvas id="demanding_paid_quizzes" width="100" height="60"></canvas>
				    </div>
				  </div>
				</div>
			</div> -->
			<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary dsPanel">
				  <div class="panel-body" >
					<table class="table table-striped table-bordered datatable" id="datatable" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>{{ getPhrase('Test Name')}}</th>
								<th>{{ getPhrase('Subject')}}</th>
								<th>{{ getPhrase('Section')}}</th>
								<th>{{ getPhrase('Test Teacher')}}</th>
								<th>{{ getPhrase('Test Conducted')}}</th>
							</tr>
						</thead>
						@foreach($tables as $table)

								<tr>

									<td>{{App\QuizCategory::find($table->category_id)->category}}</td>
									<td>{{$table->title}}</td>
									<?php $id=App\QuizCategory::find($table->category_id)->section_id ?>
									<td>{{App\User::select(['section_name'])->where('section_id',$id)->first()->section_name}}</td>
									@if(App\User::select(['name'])->where('section_id',$id)->where('role_id',3)->count()>0)
									<td>{{App\User::select(['name'])->where('section_id',$id)->where('role_id',3)->first()->name}}</td>
									@else
									<td></td>
									@endif
									<td>{{$table->start_date}}</td>
								</tr>

						@endforeach
						</table>
					</div>
				</div>
			</div>
			</div>
			<div class="row">

				<div class="col-md-6 col-lg-5">
  				  <div class="panel panel-primary dsPanel">
				    <div class="panel-heading"><i class="fa fa-bar-chart-o"></i> {{getPhrase('Total Performance')}}</div>
				    <div class="panel-body" >
				    	<canvas id="payments_chart" width="100" height="75"></canvas>
				    </div>
				  </div>
				</div>
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


				<!-- <div class="col-md-6 col-lg-4">
  				  <div class="panel panel-primary dsPanel">
				    <div class="panel-heading"><i class="fa  fa-line-chart"></i> {{getPhrase('payment_monthly_statistics')}}</div>
				    <div class="panel-body" >
				    	<canvas id="payments_monthly_chart" width="100" height="60"></canvas>
				    </div>
				  </div>
				</div> -->






	</div>
</div>
		<!-- /#page-wrapper -->

@stop

@section('footer_scripts')
@include('common.chart', array('chart_data'=>$payments_chart_data,'ids' =>array('payments_chart'), 'scale'=>TRUE))
 @include('common.chart', array($chart_data,'ids' =>$ids));
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>


    <script>
        $(document).ready( function () {
            $('#datatable').DataTable({

			});
        });
    </script>


@stop

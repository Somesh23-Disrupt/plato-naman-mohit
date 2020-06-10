@extends('layouts.teacher.teacherlayout')
@section('header_scripts')
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
	<link href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css" type="text/css">

@endsection
@section('sectiondetails')
<li {{ isActive($active_class, 'section') }}>

    <a data-toggle="collapse" data-target="#section"><i class="fa fa-fw fa-tv" ></i>
    Sections </a>
		<ul id="section" class="collapse sidemenu-dropdown">
			@foreach ($sections as $section)
			
		
				<li><a href="{{URL_SECDETAILS.'/'.$section }}"> <i class="fa fa-fw fa-random"></i>{{ App\User::select(['section_name'])->where('section_id',$section)->first()->section_name }}</a></li>
				
			@endforeach
		</ul>
	</li>

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

			</div> 
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary dsPanel">
						  <div class="panel-body" >
							<table class="table table-striped table-bordered datatable" id="datatable" id="example" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>{{ getPhrase('Test Name')}}</th>
										<th>{{ getPhrase('Subject')}}</th>
										<th>{{ getPhrase('Total Marks')}}</th>
										<th>{{ getPhrase('Avg Marks')}}</th>
										<th>{{ getPhrase('pass_student')}}</th>
									</tr>
								</thead>
								@foreach($tables as $table)
									
										<tr>
											<td>{{App\QuizCategory::find($table->category_id)->category}}</td>
											<td>{{$table->title}}</td>
											<?php $id=App\QuizCategory::find($table->category_id)->section_id ?>
											<td>{{$table->total_marks}}</td>
											<td>{{$table->avgmarks}}</td>
											<td>{{$table->tp}}</td>
										</tr>
									
								@endforeach
								</table>
							</div>
						</div>
					</div>
					</div>
					
			<!-- /.container-fluid -->
 <!-- <div class="row"> -->

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
			<!--  <div class="row">

				<div class="col-md-6 col-lg-5">
  				  <div class="panel panel-primary dsPanel">
				    <div class="panel-heading"><i class="fa fa-bar-chart-o"></i> {{getPhrase('Avg_Score')}}</div>
				    <div class="panel-body" >
				    	<canvas id="payments_chart" width="100" height="60"></canvas>
				    </div>
				  </div>
				</div> 
				

				<div class="col-md-6 col-lg-4">
  				  <div class="panel panel-primary dsPanel">
				    <div class="panel-heading"><i class="fa  fa-line-chart"></i> {{getPhrase('payment_monthly_statistics')}}</div>
				    <div class="panel-body" >
				    	<canvas id="payments_monthly_chart" width="100" height="60"></canvas>
				    </div>
				  </div>
				</div> -->
								
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
</div>
		<!-- /#page-wrapper -->

@stop

@section('footer_scripts')
	@include('common.chart', array($chart_data,'ids' =>$ids));
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

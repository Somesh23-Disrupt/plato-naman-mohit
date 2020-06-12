@extends('layouts.teacher.teacherlayout')
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
							 
							<li><i class="fa fa-home"></i> <a href="{{URL_USERS_DASHBOARD}}">{{ $title}}</a></li>
						</ol>
					</div>
				</div>
			
				
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary dsPanel">
							<div class="panel-heading">
						 
								<h1>{{ $table_title }}</h1>
							</div>
						  <div class="panel-body" >
							<table class="table table-striped table-bordered datatable" id="datatable" id="example" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>{{ getPhrase('Student Name')}}</th>
										<th>{{ getPhrase('Section')}}</th>
										<th>{{ getPhrase('Obtained Marks')}}</th>
										<th>{{ getPhrase('Total Marks')}}</th>
										<th>{{ getPhrase('Result')}}</th>
									</tr>
								</thead>
								@foreach($tables as $table)
									
										<tr>
                                        <td><a href="{{URL_RESULTS_VIEW_ANSWERS.$table->quiz_slug.'/'.$table->result_slug}}">{{ucfirst(App\User::findOrFail($table->user_id)->name)}}</a></td>
											<td>{{App\User::findOrFail($table->user_id)->section_name}}</td>
										    <td>{{$table->marks_obtained}}</td>
										    <td>{{$table->total_marks}}</td>
										    <td>{{$table->result}}</td>
										</tr>
									
								@endforeach
								</table>
							</div>
						</div>
					</div>
					</div>
					
	
		<!-- /#page-wrapper -->

@stop

@section('footer_scripts')
	
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
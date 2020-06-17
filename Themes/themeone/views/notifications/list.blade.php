@extends($layout)
@section('header_scripts')
<link href="{{CSS}}ajax-datatables.css" rel="stylesheet">
@stop
@section('content')


<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							<li>{{ $title }}</li>
						</ol>
					</div>
				</div>

				<!-- /.row -->
				<div class="panel panel-custom">
					<div class="panel-heading">

						<div class="pull-right messages-buttons">
							<a href="{{URL_ADMIN_NOTIFICATIONS_ADD}}" class="btn  btn-primary button" >{{ getPhrase('create')}}</a>
						</div>

						<h1>{{ $title }}</h1>
					</div>
					<div class="panel-body packages">
						<div>
						<table class="table table-striped table-bordered datatable" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>{{ getPhrase('title')}}</th>
									<th>{{ getPhrase('status')}}</th>
									<th>{{ getPhrase('start_date')}}</th>
									<th>{{ getPhrase('end_date')}}</th>
									<th>{{ getPhrase('url')}}</th>
									<th>{{ getPhrase('action')}}</th>
								</tr>
							</thead>

						</table>
						</div>

					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
@endsection


@section('footer_scripts')

 @include('common.datatables', array('route'=>URL_ADMIN_NOTIFICATIONS_GETLIST, 'route_as_url' => TRUE))
 @include('common.deletescript', array('route'=>URL_ADMIN_NOTIFICATIONS_DELETE))
 <script>



	function cancelRecord(slug) {

	swal({

		  title: "{{getPhrase('are_you_sure want to cancel')}}?",

		  type: "warning",

		  showCancelButton: true,

		  confirmButtonClass: "btn-danger",

		  confirmButtonText: "{{getPhrase('yes')}}!",

		  cancelButtonText: "{{getPhrase('no')}}!",

		  closeOnConfirm: false,

		  closeOnCancel: false

		},

		function(isConfirm) {

		  if (isConfirm) {

		  	  var token = '{{ csrf_token()}}';

		  	route = '{{URL_ADMIN_NOTIFICATIONS_CANCEL}}'+slug;  

		    $.ajax({

		        url:route,

		        type: 'post',

		        data: {_method: 'delete', _token :token},

		        success:function(msg){



		        	result = $.parseJSON(msg);
                    
		        	if(typeof result == 'object')

		        	{

		        		status_message = '{{getPhrase('canceled')}}';

		        		status_symbox = 'success';

		        		status_prefix_message = '';

		        		if(!result.status) {

		        			status_message = '{{getPhrase('sorry')}}';

		        			status_prefix_message = '{{getPhrase("cannot_delete_this_record_as")}}\n';

		        			status_symbox = 'info';

		        		}

		        		swal(status_message+"!", status_prefix_message+result.message, status_symbox);

		        	}

		        	else {

		        	swal("{{getPhrase('Canceled')}}!", "{{getPhrase('your_record_has_been_deleted')}}", "success");

		        	}

		        	tableObj.ajax.reload();

		        }

		    });



		  } else {

		    swal("{{getPhrase('cancelled')}}", "{{getPhrase('your_record_is_safe')}} :)", "error");

		  }

	});

	}

</script>
@stop



<script>



	function accountStatus(slug) {

	swal({

		  title: "<?php echo e(getPhrase('are_you_sure')); ?>?",

		  text: "<?php echo e(getPhrase('you_would_like_to_change_the_account_status_of_user')); ?>!",

		  type: "warning",

		  showCancelButton: true,

		  confirmButtonClass: "btn-danger",

		  confirmButtonText: "<?php echo e(getPhrase('yes')); ?>!",

		  cancelButtonText: "<?php echo e(getPhrase('no')); ?>!",

		  closeOnConfirm: false,

		  closeOnCancel: false

		},

		function(isConfirm) {

		  if (isConfirm) {

		  	  var token = '<?php echo e(csrf_token()); ?>';

		  	route = '<?php echo e($route); ?>'+slug;  

		    $.ajax({

		        url:route,

		        type: 'post',

		        data: {_method: 'delete', _token :token},

		        success:function(msg){



		        	result = $.parseJSON(msg);
                    
		        	if(typeof result == 'object')

		        	{

		        		status_message = '<?php echo e(getPhrase('changed')); ?>';

		        		status_symbox = 'success';

		        		status_prefix_message = '';

		        		if(!result.status) {

		        			status_message = '<?php echo e(getPhrase('sorry')); ?>';

		        			status_prefix_message = '<?php echo e(getPhrase("cannot_change_status_as_this_record_as")); ?>\n';

		        			status_symbox = 'info';

		        		}

		        		swal(status_message+"!", status_prefix_message+result.message, status_symbox);

		        	}

		        	else {

		        	swal("<?php echo e(getPhrase('deleted')); ?>!", "<?php echo e(getPhrase('status_has_been_changed')); ?>", "success");

		        	}

		        	tableObj.ajax.reload();

		        }

		    });



		  } else {

		    swal("<?php echo e(getPhrase('cancelled')); ?>", "<?php echo e(getPhrase('account_status_not_changed')); ?> :)", "error");

		  }

	});

	}

</script>
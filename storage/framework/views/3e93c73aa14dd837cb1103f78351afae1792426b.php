

					 <fieldset class="form-group">



						<?php echo e(Form::label('name', getphrase('name'))); ?>


						<span class="text-red">*</span>

						<?php echo e(Form::text('name', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Jack',

							'ng-model'=>'name',

							'required'=> 'true',

							'ng-pattern' => getRegexPattern("name"),

							'ng-minlength' => '2',

							'ng-maxlength' => '20',

							'ng-class'=>'{"has-error": formUsers.name.$touched && formUsers.name.$invalid}',



						))); ?>


						<div class="validation-error" ng-messages="formUsers.name.$error" >

	    					<?php echo getValidationMessage(); ?>


	    					<?php echo getValidationMessage('minlength'); ?>


	    					<?php echo getValidationMessage('maxlength'); ?>


	    					<?php echo getValidationMessage('pattern'); ?>


						</div>

					</fieldset>



					<?php

					$readonly = '';

					$username_value = null;

					if($record){

						$readonly = 'readonly="true"';

						// $username_value = $record->username;

					}



					?>

					 <fieldset class="form-group">



						<?php echo e(Form::label('username', getphrase('username'))); ?>


						<span class="text-red">*</span>

						<?php echo e(Form::text('username', $value = $username_value , $attributes = array('class'=>'form-control', 'placeholder' => 'Jack',

							'ng-model'=>'username',

							'required'=> 'true',

							 $readonly,



							'ng-minlength' => '2',

							'ng-maxlength' => '20',

							'ng-class'=>'{"has-error": formUsers.username.$touched && formUsers.username.$invalid}',



						))); ?>


						<div class="validation-error" ng-messages="formUsers.username.$error" >

	    					<?php echo getValidationMessage(); ?>


	    					<?php echo getValidationMessage('minlength'); ?>


	    					<?php echo getValidationMessage('maxlength'); ?>


	    					<?php echo getValidationMessage('pattern'); ?>


						</div>

					</fieldset>

					<?php if($record): ?>
					 <fieldset class="form-group">

						<?php $password_required = true;
						if($record)
							$password_required = false;
						?>

						<?php echo e(Form::label('password', getphrase('password'))); ?>

						<?php if(!$record): ?>

						<span class="text-red">*</span>
						<?php endif; ?>

						<?php echo e(Form::password('password', $attributes = array('class'=>'form-control', 'placeholder' => 'Enter password',

							'ng-model'=>'password',

							'required'=> $password_required,

							'ng-minlength' => '2',

							'ng-maxlength' => '20',

							'ng-class'=>'{"has-error": formUsers.password.$touched && formUsers.password.$invalid}',



						))); ?>


						<div class="validation-error" ng-messages="formUsers.password.$error" >

	    					<?php echo getValidationMessage(); ?>


	    					<?php echo getValidationMessage('minlength'); ?>


	    					<?php echo getValidationMessage('maxlength'); ?>



						</div>

					</fieldset>
					<?php endif; ?>

					 <fieldset class="form-group">

						<?php

						$readonly = '';

							if(!checkRole(getUserGrade(4)))

							$readonly = 'readonly="true"';

						if($record)

						{

							$readonly = 'readonly="true"';

						}



						?>

						<?php echo e(Form::label('email', getphrase('email'))); ?>


						<span class="text-red">*</span>

						<?php echo e(Form::email('email', $value = null, $attributes = array('class'=>'form-control', 'placeholder' => 'jack@jarvis.com',

							'ng-model'=>'email',

							'required'=> 'true',

							'ng-class'=>'{"has-error": formUsers.email.$touched && formUsers.email.$invalid}',

						 $readonly))); ?>


						 <div class="validation-error" ng-messages="formUsers.email.$error" >

	    					<?php echo getValidationMessage(); ?>


	    					<?php echo getValidationMessage('email'); ?>


						</div>

					</fieldset>

					<?php if(!$record): ?>
					 <fieldset class="form-group">
					 <?php echo e(Form::label('password', getphrase('password'))); ?>


						<span class="text-red">*</span>

						<?php echo e(Form::password('password', $attributes = array('class'=>'form-control instruction-call',

								'placeholder' => getPhrase("password"),

								'ng-model'=>'password',

								'required'=> 'true',

								'ng-class'=>'{"has-error": formUsers.password.$touched && formUsers.password.$invalid}',

								'ng-minlength' => 5

							))); ?>


						<div class="validation-error" ng-messages="formUsers.password.$error" >

							<?php echo getValidationMessage(); ?>


							<?php echo getValidationMessage('password'); ?>


						</div>


					</fieldset>

					 <fieldset class="form-group">
					 <?php echo e(Form::label('confirm_password', getphrase('confirm_password'))); ?>


						<span class="text-red">*</span>

						<?php echo e(Form::password('password_confirmation', $attributes = array('class'=>'form-control instruction-call',

								'placeholder' => getPhrase("confirm_password"),

								'ng-model'=>'password_confirmation',

								'required'=> 'true',

								'ng-class'=>'{"has-error": formUsers.password_confirmation.$touched && formUsers.password.$invalid}',

								'ng-minlength' => 5

							))); ?>


						<div class="validation-error" ng-messages="formUsers.password_confirmation.$error" >

							<?php echo getValidationMessage(); ?>


							<?php echo getValidationMessage('password'); ?>


						</div>


					</fieldset>

                  <?php endif; ?>





					<?php if(!checkRole(['parent'])): ?>

					<fieldset class="form-group">



						<?php echo e(Form::label('role', getphrase('role'))); ?>


						<span class="text-red">*</span>

						<?php $disabled = (checkRole(getUserGrade(1))) ? '' :'disabled';


						if(checkRole(getUserGrade(2)))
							$selected = getRoleData('teacher');
						else
							$selected = getRoleData('student');

						if($record)

							$selected = $record->role_id;

						?>

						<?php echo e(Form::select('role_id', $roles, $selected, ['placeholder' => getPhrase('select_role'),'class'=>'form-control', $disabled,

							'ng-model'=>'role_id',

							'value' => $selected,

							'required'=> 'true',

							'ng-class'=>'{"has-error": formUsers.role_id.$touched && formUsers.role_id.$invalid}'

						 ])); ?>


						  <div class="validation-error" ng-messages="formUsers.role_id.$error" >

	    					<?php echo getValidationMessage(); ?>




						</div>



					</fieldset>

					<?php endif; ?>

					<?php if((checkRole(getUserGrade(2)))): ?>

					<fieldset class="form-group">



						<?php echo e(Form::label('Section', 'Assign as Class teacher (Optional)')); ?>


						<span class="text-red"></span>

						<?php echo e(Form::text('section', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Section name',

							'ng-model'=>'section',

							'list'=>'section-list',

							'ng-minlength' => '2',

							'ng-maxlength' => '20'



						))); ?>


						<datalist id="section-list">
							<?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($section); ?>"/>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</datalist>

						<div class="validation-error" ng-messages="formUsers.name.$error" >





					</fieldset>

					<?php endif; ?>



					<fieldset class="form-group">



						<?php echo e(Form::label('phone', getphrase('phone'))); ?>


						<span class="text-red">*</span>

						<?php echo e(Form::text('phone', $value = null , $attributes = array('class'=>'form-control', 'placeholder' =>
						getPhrase('please_enter_10_digit_mobile_number'),

							'ng-model'=>'phone',

							'required'=> 'true',

							'ng-pattern' => getRegexPattern("phone"),

							'ng-class'=>'{"has-error": formUsers.phone.$touched && formUsers.phone.$invalid}',


						))); ?>




						<div class="validation-error" ng-messages="formUsers.phone.$error" >

	    					<?php echo getValidationMessage(); ?>


	    					<?php echo getValidationMessage('phone'); ?>


	    					<?php echo getValidationMessage('maxlength'); ?>


						</div>

					</fieldset>

					<div class="row">

						<fieldset class="form-group col-sm-6">



						<?php echo e(Form::label('address', getphrase('address'))); ?>




						<?php echo e(Form::textarea('address', $value = null , $attributes = array('class'=>'form-control','rows'=>3, 'cols'=>'15', 'placeholder' => getPhrase('please_enter_your_address'),

							'ng-model'=>'address',

							))); ?>


					</fieldset>



					<fieldset class='col-sm-6'>

						<?php echo e(Form::label('image', getphrase('image'))); ?>


						<div class="form-group row">

							<div class="col-md-6">



					<?php echo Form::file('image', array('id'=>'image_input', 'accept'=>'.png,.jpg,.jpeg')); ?>


							</div>

							<?php if(isset($record) && $record) {

								  if($record->image!='') {

								?>

							<div class="col-md-6">

								<img src="<?php echo e(getProfilePath($record->image)); ?>" />



							</div>

							<?php } } ?>

						</div>

					</fieldset>

					  </div>



						<div class="buttons text-center">

							<button class="btn btn-lg btn-success button"

							ng-disabled='!formUsers.$valid'><?php echo e($button_name); ?></button>

						</div>

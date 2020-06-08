
				    <fieldset class="form-group">
						<?php echo e(Form::label('subject_title', getphrase('subject_title'))); ?>

						<span class="text-red">*</span>
						<?php echo e(Form::text('subject_title', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Maths',
							'ng-model'=>'subject_title',
							'ng-pattern' => getRegexPattern('name'),
							'required'=> 'true',
							'ng-class'=>'{"has-error": formSubjects.subject_title.$touched && formSubjects.subject_title.$invalid}',
							'ng-minlength' => '2',
							'ng-maxlength' => '40',
						))); ?>

						<div class="validation-error" ng-messages="formSubjects.subject_title.$error" >
	    					<?php echo getValidationMessage(); ?>

	    					<?php echo getValidationMessage('pattern'); ?>

	    					<?php echo getValidationMessage('minlength'); ?>

	    					<?php echo getValidationMessage('maxlength'); ?>

						</div>
					</fieldset>

                    <fieldset class="form-group col-md-6">

						<?php echo e(Form::label('section_id', getphrase('section'))); ?>

						<span class="text-red">*</span>
						<?php echo e(Form::select('section_id', $sections, null, ['class'=>'form-control'])); ?>


					</fieldset>


					<fieldset class="form-group">

						<?php echo e(Form::label('subject_code', getphrase('subject_code'))); ?>

						<span class="text-red">*</span>
						<?php echo e(Form::text('subject_code', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'M1',
							'ng-model'=>'subject_code',
							'ng-pattern' => getRegexPattern('name'),
							'required'=> 'true',
							'ng-class'=>'{"has-error": formSubjects.subject_code.$touched && formSubjects.subject_code.$invalid}',
							'ng-minlength' => '2',
							'ng-maxlength' => '10',
						))); ?>

						<div class="validation-error" ng-messages="formSubjects.subject_code.$error" >
	    					<?php echo getValidationMessage(); ?>

	    					<?php echo getValidationMessage('pattern'); ?>

	    					<?php echo getValidationMessage('minlength'); ?>

	    					<?php echo getValidationMessage('maxlength'); ?>

						</div>
					</fieldset>




					
					
					</fieldset>
						<div class="buttons text-center">
							<button class="btn btn-lg btn-success button"
							ng-disabled='!formSubjects.$valid'><?php echo e($button_name); ?></button>
						</div>

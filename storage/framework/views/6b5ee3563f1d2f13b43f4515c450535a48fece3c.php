 					 
 					 <fieldset class="form-group">
						
						<?php echo e(Form::label('category', getphrase('category_name'))); ?>

						<span class="text-red">*</span>
						<?php echo e(Form::text('category', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('enter_category_name'),
							'ng-model'=>'category', 
							'ng-pattern' => getRegexPattern('name'),
							'ng-minlength' => '2',
							'ng-maxlength' => '60',
							'required'=> 'true', 
							'ng-class'=>'{"has-error": formCategories.category.$touched && formCategories.category.$invalid}',
							 
							))); ?>

							<div class="validation-error" ng-messages="formCategories.category.$error" >
	    					<?php echo getValidationMessage(); ?>

	    					<?php echo getValidationMessage('minlength'); ?>

	    					<?php echo getValidationMessage('maxlength'); ?>

	    					<?php echo getValidationMessage('pattern'); ?>

						</div>
					</fieldset>

                    <fieldset class="form-group col-md-6">

						<?php echo e(Form::label('section_id', getphrase('section'))); ?>

						<span class="text-red">*</span>
						<?php echo e(Form::select('section_id', $sections, null, ['class'=>'form-control'])); ?>


					</fieldset>

 					  <fieldset class="form-group" >
				   <?php echo e(Form::label('category', getphrase('image'))); ?>

				         <input type="file" class="form-control" name="catimage"
				         accept=".png,.jpg,.jpeg" id="image_input">


				    </fieldset>

				     <fieldset class="form-group" >
					<?php if($record): ?>
				   		<?php if($record->image): ?>
				         <?php $examSettings = getExamSettings(); ?>
				         <img src="<?php echo e(PREFIX.$examSettings->categoryImagepath.$record->image); ?>" height="100" width="100" >

				         <?php endif; ?>
				     <?php endif; ?>
					

				    </fieldset>

				  
					<fieldset class="form-group">
						
						<?php echo e(Form::label('description', getphrase('description'))); ?>

						
						<?php echo e(Form::textarea('description', $value = null , $attributes = array('class'=>'form-control', 'rows'=>'5', 'placeholder' => 'Description'))); ?>

					</fieldset>
						
					</fieldset>
						<div class="buttons text-center">
							<button class="btn btn-lg btn-success button"
							ng-disabled='!formCategories.category.$valid'><?php echo e($button_name); ?></button>
						</div>
		 

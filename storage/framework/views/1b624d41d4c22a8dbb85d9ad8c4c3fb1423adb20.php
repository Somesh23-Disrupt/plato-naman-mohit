
<div ng-if="question_type=='para' || question_type=='video' || question_type=='audio'">
    <div class="row">
    <fieldset class="form-group col-md-6"> 
        <?php echo e(Form::label('total_answers', getphrase('total_questions'))); ?>

	      <span class="text-red">*</span>
		<?php echo e(Form::select('total_answers',$exam_max_options , null, ['class'=>'form-control', "id"=>"total_answers", "ng-model"=>"total_answers", "ng-change" => "answersChanged(total_answers)" ,
          'required'=> 'true', 
        'ng-class'=>'{"has-error": formQuestionBank.total_answers.$touched && formQuestionBank.total_answers.$invalid}',
        ])); ?>

         <div class="validation-error" ng-messages="formQuestionBank.total_answers.$error" >
        <?php echo getValidationMessage(); ?>

        </div>
    </fieldset>
    <?php 
    // dd($record);
    $total_answers = null;
    $set_answers = array();
    if($record) {
        $set_answers = json_decode($record->answers);
        if(count($set_answers))
        {
            if(isset($set_answers[0]->total_options))
            $total_answers = $set_answers[0]->total_options;
        }
    }
         // dd($record);
    ?>
    <fieldset class="form-group col-md-6"> 
        <?php echo e(Form::label('total_options', getphrase('total_options'))); ?>

         <span class="text-red">*</span>
        <?php echo e(Form::select('total_para_options',$exam_max_options , $total_answers, ['class'=>'form-control', "id"=>"total_para_options", "ng-model"=>"total_para_options", "ng-change" => "paraOptionsChanged(total_para_options)" ,
        'required'=> 'true', 
        'ng-class'=>'{"has-error": formQuestionBank.total_para_options.$touched && formQuestionBank.total_para_options.$invalid}',
        ])); ?>

         <div class="validation-error" ng-messages="formQuestionBank.total_para_options.$error" >
        <?php echo getValidationMessage(); ?>

        </div>
    </fieldset>
    </div>

     
   
    

     

    

     

          
       
    </div>



 


</div>
@extends('layouts.sitelayout')

@section('content')

 <!--  <section class="cs-primary-bg cs-page-banner" style="margin-top:100px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="cs-page-banner-title text-center">{{getPhrase('create_a_new_account')}}</h2>
                </div>
            </div>
        </div>
    </section> -->

  <!-- Login Section -->
  <div  style="background-image: url({{IMAGES}}login-bg.png);background-repeat: no-repeat;background-color: #f8fafb">
    <div class="container">
         <div class="row cs-row" style="margin-top: 180px">

            <div class="col-md12">
                <div class="cs-box-resize-sign login-box">
                   <h4 class="text-center login-head">{{getPhrase('create_account')}}</h4>
                    <!-- Form Login/Register -->
                    	{!! Form::open(array('url' => URL_USERS_REGISTER, 'method' => 'POST', 'name'=>'formLanguage ', 'novalidate'=>'', 'class'=>"loginform", 'name'=>"registrationForm")) !!}

                        @include('errors.errors')

                        <div class="form-group">

                <label for="inst_name">{{getPhrase('institution_name')}}</label><span style="color: red;">*</span>

                {{ Form::text('inst_name', $value = null , $attributes = array('class'=>'form-control',

                        'placeholder' => getPhrase("Institution"),

                        'ng-model'=>'inst_name',

                        'ng-pattern' => getRegexPattern('name'),

                        'required'=> 'true',

                        'ng-class'=>'{"has-error": registrationForm.inst_name.$touched && registrationForm.inst_name.$invalid}',

                        'ng-minlength' => '2',

                    )) }}

        <div class="validation-error" ng-messages="registrationForm.inst_name.$error" >

            {!! getValidationMessage()!!}

            {!! getValidationMessage('minlength')!!}

            {!! getValidationMessage('pattern')!!}

        </div>

</div>


<div class="form-group">

<label for="website">{{getPhrase('website')}}</label>

{{ Form::text('website', $value = null , $attributes = array('class'=>'form-control',

        'placeholder' => getPhrase("Website"),

        'ng-model'=>'website',

        'ng-pattern' => getRegexPattern('name'),


        'ng-class'=>'{"has-error": registrationForm.website.$touched && registrationForm.website.$invalid}',

        'ng-minlength' => '4',

    )) }}

        <div class="validation-error" ng-messages="registrationForm.website.$error" >

            {!! getValidationMessage()!!}

            {!! getValidationMessage('minlength')!!}

            {!! getValidationMessage('pattern')!!}

        </div>

</div>


                        <div class="form-group">

                        	<label for="name">{{getPhrase('name')}}</label><span style="color: red;">*</span>

						   {{ Form::text('name', $value = null , $attributes = array('class'=>'form-control',

									'placeholder' => getPhrase("name"),

									'ng-model'=>'name',

									'ng-pattern' => getRegexPattern('name'),

									'required'=> 'true',

									'ng-class'=>'{"has-error": registrationForm.name.$touched && registrationForm.name.$invalid}',

									'ng-minlength' => '4',

								)) }}

									<div class="validation-error" ng-messages="registrationForm.name.$error" >

										{!! getValidationMessage()!!}

										{!! getValidationMessage('minlength')!!}

										{!! getValidationMessage('pattern')!!}

									</div>

                        </div>





                         <div class="form-group">

                          <label for="email">{{getPhrase('email')}}</label><span style="color: red;">*</span>

                        {{ Form::email('email', $value = null , $attributes = array('class'=>'form-control',

									'placeholder' => getPhrase("email"),

									'ng-model'=>'email',

									'required'=> 'true',

									'ng-class'=>'{"has-error": registrationForm.email.$touched && registrationForm.email.$invalid}',

								)) }}

							<div class="validation-error" ng-messages="registrationForm.email.$error" >

								{!! getValidationMessage()!!}

								{!! getValidationMessage('email')!!}

							</div>


                        </div>

                        <div class="form-group">



    						{{ Form::label('phone', getphrase('phone')) }}

    						<span style="color: red;">*</span>

    						{{ Form::text('phone', $value = null , $attributes = array('class'=>'form-control', 'placeholder' =>
    						getPhrase('please_enter_10_digit_mobile_number'),

    							'ng-model'=>'phone',

    							'required'=> 'true',

    							'ng-pattern' => getRegexPattern("phone"),

    							'ng-class'=>'{"has-error": registrationForm.phone.$touched && registrationForm.phone.$invalid}',


    						)) }}



    						<div class="validation-error" ng-messages="registrationForm.phone.$error" >

    	    					{!! getValidationMessage()!!}

    	    					{!! getValidationMessage('phone')!!}

    	    					{!! getValidationMessage('maxlength')!!}

    						</div>

    					</div>


                        <div class="form-group">



    						{{ Form::label('country', getphrase('country')) }}

    						<span style=" color:red;">*</span>


    						{{Form::select('country', ['India'=>'India'], 'India' ,['class'=>'form-control',

    							'ng-model'=>'country',

    							'value' => 'India',

    							'required'=> 'true',

    							'ng-class'=>'{"has-error": registrationForm.country.$touched && registrationForm.country.$invalid}'

    						 ])}}

    						  <div class="validation-error" ng-messages="registrationForm.country.$error" >

    	    					{!! getValidationMessage()!!}



    						</div>



    					</div>



                        <div class="form-group">

                          <label for="countstudent">{{getPhrase('Number of students you wish to bring online')}}</label><span style="color: red;">*</span>

                         {{ Form::number('countstudent', $value = null , $attributes = array('class'=>'form-control',

								'placeholder' => getPhrase("Number of Students"),

								'ng-model'=>'countstudent',

								'required'=> 'true',

								'ng-class'=>'{"has-error": registrationForm.countstudent.$touched && registrationForm.countstudent.$invalid}',


							)) }}

						<div class="validation-error" ng-messages="registrationForm.countstudent.$error" >

							{!! getValidationMessage()!!}

							{!! getValidationMessage('minlength')!!}

							{!! getValidationMessage('pattern')!!}

						</div>

						</div>

                        <div class="form-group">



						{{ Form::label('description', getphrase('description')) }}



						{{ Form::textarea('description', $value = null , $attributes = array('class'=>'form-control','rows'=>3, 'cols'=>'15', 'placeholder' => getPhrase('please_provide_a_short_description'),

							'ng-model'=>'description',

							)) }}

					</div>




                         <div class="form-group">

                             @if($rechaptcha_status == 'yes')




				          <div class="col-md-12 form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}" style="margin-top: 15px">



		                                {!! app('captcha')->display() !!}



                               </div>


                             @endif


                        </div>

                      	<div class="text-center mt-2">
                      		<button type="submit" class="btn button btn-primary btn-lg" ng-disabled='!registrationForm.$valid'>{{getPhrase('register_now')}}</button>
                      	</div>

                    </form>
                    <!-- Form Login/Register -->
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Login Section -->

@stop



@section('footer_scripts')

	@include('common.validations')
		     	{{-- <script src="{{JS}}recaptcha.js"></script> --}}
		     		<script src='https://www.google.com/recaptcha/api.js'></script>



@stop

 <!-- NAVIGATION -->
    <nav class="navbar navbar-default pw-navbar-default navbar-fixed-top">
        <!-- /TOP BAR -->
        <div class="cs-topbar">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{URL_HOME }}"><img src="{{IMAGE_PATH_SETTINGS.getSetting('site_logo', 'site_settings')}}" alt="logo" class="cs-logo" class="img-responsive" style="height: 40px;"></a>
                </div>

                <ul class="nav navbar-nav navbar-right" style="margin-top: 5px;">
                    @if(Auth::check())

                    <li><a href="{{PREFIX}}" class="cs-nav-btn visible-lg"> {{getPhrase('dashboard')}}</a></li>
                    <li><a href="{{URL_USERS_LOGOUT}}" class="cs-nav-btn visible-lg"> {{getPhrase('logout')}}</a></li>
                    @else

                    @if(env('DEMO_MODE'))
                    <li><a href="https://codecanyon.net/item/Platooes-online-learning-and-examination-system/19361996" class="cs-nav-btn visible-lg yellow-buy" style="border-radius: 50px; background-color:#ff9800;"> {{getPhrase('Buy_Now')}}</a></li>
                    @endif
                    <!--
                    <li><a href="{{URL_USERS_REGISTER}}" class="cs-nav-btn visible-lg"> {{getPhrase('create_account')}}</a></li>
                    <li><a href="{{URL_USERS_LOGIN}}" class="cs-nav-btn cs-responsive-menu"><span>{{getPhrase('sign_in')}}</span><i class="icon icon-User " aria-hidden="true"></i></a></li>-->
                    @endif
                </ul>
            </div>
        </div>
        <!-- /TOP BAR -->
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle offcanvas-toggle pull-right" data-toggle="offcanvas" data-target="#js-bootstrap-offcanvas" style="float:left;">
                    <span class="sr-only">Toggle navigation</span>
                    <span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </span>
                </button>
            </div>

        </div>
    </nav>
    <!-- /NAVIGATION -->

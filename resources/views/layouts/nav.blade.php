<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            University Admission System
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav ml-auto">
            
                                


                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    @if (Auth::user()->role == 'user')
                        <!-- Role:Student Links -->
                        <li class="nav-item {{ Route::currentRouteName() == 'status' ? 'active' : '' }}">
                            <a class="nav-link" href="/status">Application Status</a>
                        </li>
                        <li class="nav-item {{ (Route::currentRouteName() == 'application.build' || Route::currentRouteName() == 'acade' || Route::currentRouteName() == 'personal') ? 'active' : '' }}">
                            <a class="nav-link" href="/applications/create">My Application</a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'apply' ? 'active' : '' }}">
                            <a class="nav-link" href="/apply">Apply Programme</a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'fileView' ? 'active' : '' }}">
                            <a class="nav-link" href="/fileView">File Upload</a>
                        </li> 
                    @elseif (Auth::user()->role == 'officer')
                        <!-- Role:officer Links -->
                        <li class="nav-item {{ Route::currentRouteName() == 'manage' ? 'active' : '' }}">
                            <a class="nav-link" href="/manage">Application Manage</a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'interviewManage' ? 'active' : '' }}">
                            <a class="nav-link" href="/interviewManage">Interview Manage</a>
                        </li> 
                    @elseif (Auth::user()->role == 'admin')
                        <li class="nav-item {{ Route::currentRouteName() == 'userManage' ? 'active' : '' }}">
                            <a class="nav-link" href="/userManage">User Manage</a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'programmeManage' ? 'active' : '' }}">
                            <a class="nav-link" href="/programmeManage">Programme Manage</a>
                        </li>
                        <!--<li class="nav-item {{ Route::currentRouteName() == 'createOfficer' ? 'active' : '' }}">
                            <a class="nav-link" href="/createOfficer">Create Officer</a>
                        </li>-->

                    @endif

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                    
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    
                @endguest
            </ul>
        </div>
    </div>
</nav>
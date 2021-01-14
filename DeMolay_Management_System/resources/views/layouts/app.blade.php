<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <?php

    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;

    if (Auth::user() == null) {
    } else {
        $chapterDesc = DB::table('chapters')
            ->select('description')
            ->where('jurisdiction_id', Auth::user()->jurisdiction_id)
            ->where('id', Auth::user()->chapter_id)
            ->pluck('description');

        $chapterDesc = str_replace(array('"', '[', "]"), '', $chapterDesc);
    }

    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DeMolay</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Adamina&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
    <!-- custom navbar styling -->
    <style>
        /* Backround colour */
        div {
            font-family: 'Adamina', serif;
        }

        .navbar {
            background-color: #232D45 !important;
        }

        /* Text styling */
        .navbar .navbar-brand,
        .navbar .navbar-text {
            color: #F6CD25;
            font-size: 22px;
            font-family: 'Adamina', serif;
        }

        /* Toggel styling, Mobile version */
        .navbar-toggler {
            background-color: #ffffff;
        }

        /* navbar links to other pages styling */
        .navbar .navbar-title-links {
            font-size: 15px;
            color: inherit !important;
            font-family: 'Adamina', serif;
        }

        .navbar-title-links a {
            text-decoration: none;
        }

        /*hover effects for nav links */
        .navbar .navbar-title-links a:hover {
            color: #B63226 !important;
            transition: .4s;
        }

        .navbar-title-links a:after {
            content: '';
            display: block;
            width: 0;
            height: 2px;
            background: #F6CD25;
            transition: width .3s;
        }

        .navbar-title-links a:hover::after {
            width: 100%;
            transition: width .3s;
        }

        .chapter-jurisdiction {
            font-size: 10px;
        }

        /* Footer Styling */

        .full {
            width: 100%;
        }

        .gap {
            height: 30px;
            width: 100%;
            clear: both;
            display: block;
        }

        .footer {
            background: #232D45;
            height: auto;
            padding-bottom: 4px;
            position: relative;
            width: 100%;
            border-bottom: 1px solid #CCCCCC;
            border-top: 1px solid #DDDDDD;
        }

        .footer h3 {
            color: white;
            font-family: 'Adamina', serif;
            font-size: 18px;
            line-height: 27px;
            padding: 20px 0 0px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .footer h4 {
            color: white;
            font-size: 18px;
            font-family: 'Adamina', serif;
            line-height: 27px;
            padding: 20px 0 10px;
        }

        .footer ul {
            font-size: 13px;
            list-style-type: none;
            margin-left: 0;
            padding-left: 0;
            margin-top: 0px;
            font-family: 'Adamina', serif;
            color: #7F8C8D;
            padding: 0 0 8px 0;
        }

        .footer ul li a {
            padding: 0 0 2px 0;
            display: block;
        }

        .footer p {
            color: white;
            font-weight: lighter;
        }

        .footer a:hover {
            text-decoration: none;
            font-weight: bold;
        }

        .footer a {
            color: #F6CD25;
            text-decoration: none;
        }

        .footer-bottom {
            margin-top: 0;
            border-top: 1px solid #DDDDDD;
            padding-top: 5px;
            background: #232D45;
            height: 40px;
        }

        .footer-bottom p.pull-left {
            padding-top: 6px;
            font-size: 0.75em
        }

        /* Footer hover links */
        .footer-links a:hover {
            color: #B63226;
            transition: .4s;
        }

        .footer-links a:after {
            content: '';
            display: block;
            width: 0;
            height: 2px;
            background: #F6CD25;
            transition: width .3s;
        }

        .footer-links a:hover::after {
            width: 100%;
            transition: width .3s;
        }

        .footer-links {
            padding-top: 18px;
            font-size: 20px;
            height: 100%;
        }

        /* Author Styling */
        .btn-row {
            margin: 3.0rem 0rem;
            font-size: 1.2rem;
        }

        #submitBtn,
        #cancelBtn {
            padding: 0.5rem 1.0rem;
            width: 100%;
        }

        /* Side Nav Styling */

        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background: #232D45;
            overflow-x: hidden;
            padding-top: 90px;
            transition: 0.3s;
        }

        /* The navigation menu links */
        .sidenav a,
        .dropdown-btn {
            padding: 8px 8px 8px 25px;
            text-decoration: none;
            font-size: 20px;
            color: #F6CD25;
            display: block;
            transition: 0.3s;
            border: none;
            background: none;
            white-space: nowrap;
            width: 100%;
            text-align: left;
        }

        /* When you mouse over the navigation links, change their color */
        .sidenav a:hover,
        .dropdown-btn:hover {
            color: #B63226;
        }

        /* Position and style the close button */
        .sidenav .closebtn {
            position: absolute;
            padding-top: 15px;
            padding-bottom: 0px;
            top: 0;
            left: 0px;
            font-size: 36px;
            margin-left: 0px;
            width: 80px;
        }

        .sidenav{
                width:250px;
            }

        /* On smaller screens, where height is less than 450px, change the style of the sidenav*/
        @media screen and (max-height: 450px) {
            .sidenav {
                padding-top: 15px;
            }

            .sidenav a {
                font-size: 10px;
            }
        }

        @media screen and (max-width: 1670px) {
            .sidenav{
                width: 0;
            }
        }

        .dropdown-container {
            display: none;
            background-color: #232D45;
            padding-left: 8px;
            outline: none;
            border: none;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
            @guest
            @else
            <div class="sideNav-Button">
                <!-- Use any element to open the sidenav -->
                <span onclick="openNav()" class="fa fa-bars" type="button" style="font-size:30px; color:#F6CD25; background:#232D45; padding-left:20px;"></span>
            </div>
            @endguest
            <div class="container">
                <!--Logo and title on left side of nav bar-->
                <a class="navbar-brand" href="{{ url('/home') }}"><img src="{{ URL::to('/images/DemolayCanadaLogo.png') }}" alt="demolaylogo" style="width:64px;height:69px;"></a>
                <div class="navbar-title-links">
                    <a class="navbar-brand " href="{{ url('/home') }}"> DeMolay</a>
                </div>
                @guest
                @else
                <div class="navbar-title-links chapter-jurisdiction">
                    <h7 class="navbar-text" style="font-size: 15px;">{{ Auth::user()->jurisdiction->description }}</h7>
                    <h7 class="navbar-text" style="font-size: 15px; padding-left:10px;"> {{ $chapterDesc }}</h7>
                </div>
                @endguest
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse navbar-title-links" id="navbarSupportedContent">
                    <!-- Left links on navbar beside logo and title -->

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav navbar-title-links ml-auto">
                        <!-- Authentication Links if logged in vs not logged in  -->
                        @guest
                        <li class="nav-item" style="color: #F6CD25;">
                          <!--  <a class="nav-link navbar-title-links" href="{{ route('login') }}">{{ __('Login') }}</a>-->
                        </li>
                       
                        @else
                        <p style="color: white; padding-top: 7px;">Welcome: </p>
                        <li class="nav-item dropdown" style="color: #F6CD25;">
                            <a id="navbarDropdown" class="navbar-title-links nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <a href="{{route('changePassword')}}" class="dropdown-item">
                                    Change Password
                                </a>

                                <a class="dropdown-item" href="changeEmail">
                                    Change Account Email
                                </a>

                                <a class="dropdown-item" href="{{url('updateuser').'/'.Auth::user()->id}}">
                                    Manage User Information
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

        @guest
        @else
        <!-- Side navigation -->
        <div id="mySidenav" class="sidenav">
            <div>
                <a href="javascript:void(0)" style="font-size: 50px;" class="closebtn" onclick="closeNav()">-</a>
            </div>
            <div>
                @if(Auth::user()->hasRole('Admin') or Auth::user()->hasRole('It Admin') or Auth::user()->hasRole('Board Member') or Auth::user()->hasRole('Secretary')
                or Auth::user()->hasRole('President') or Auth::user()->hasRole('Director At Large')) 
                @ITAdmin('country', 'read')
                <a href="{{url('managejurisdictions')}}">Manage Jurisdictions</a> 
                @endITAdmin
                @endif
                @if((Auth::user()->hasRole('Admin') or Auth::user()->hasRole('It Admin') or Auth::user()->hasRole('Executive Officer'))) 
                @ITAdmin('jurisdiction', 'read')
                <a href="{{url('managechapters')}}">Manage Chapters</a> 
                @endITAdmin
                @endif
                @if(Auth::user()->hasRole('Admin'))
                <a href="{{ route('itadminmanagement')}}">Manage IT Admins</a>
                @endif
                @if(Auth::user()->hasRole('Executive Officer'))
                @ITAdmin('member', 'read')
                <a href="{{ url('fees')}}">View Fees</a> 
                @endITAdmin
                @endif
                @if(Auth::user()->hasRole('Admin') or Auth::user()->hasRole('It Admin') or Auth::user()->hasRole('Chapter Chairman') or Auth::user()->hasRole('Chapter Advisor'))
                <button class="dropdown-btn">Fees
                <i class="fa fa-caret-down"></i>
                </button>
                <div class='dropdown-container'> 
                    @ITAdmin('member', 'write')
                    <a href="{{ url('fees')}}">Manage Fees</a>
                    <a href="{{ url('feedescription')}}">Manage Descriptions</a> 
                    @endITAdmin
                </div>
                @endif 
                @if(Auth::user()->canCreateUser())
                <a href="{{ url('createuser')}}">Add User</a> 
                <a href="{{ url('manageusers')}}">Manage User</a> 
                @endif  
                @if(Auth::user()->hasRole('Admin') or Auth::user()->hasRole('It Admin')) 
                <a href="{{ url('activitylog')}}">Activity Logs</a>
                @endif
                @if(Auth::user()->hasRole('Executive Officer') || Auth::user()->hasRole('Admin') or Auth::user()->hasRole('It Admin'))
                <a href="{{ url('nominations')}}">Nominations</a> 
                @endif
                @if(Auth::user()->hasRole('Board Member') or Auth::user()->hasRole('Secretary') or Auth::user()->hasRole('President') or Auth::user()->hasRole('Director At Large'))
                @else 
                <button class="dropdown-btn">Members
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-container">  
                    @ITAdmin('member', 'read')
                        <a href="{{url('search')}}">Member List</a>  
                    @endITAdmin
                    @if(Auth::user()->hasRole('Executive Officer'))
                    @else 
                    @ITAdmin('member', 'write')
                    <a href="{{ url('create-member')}}">Add Member</a> 
                    @endITAdmin
                    @endif
                    @if(Auth::user()->hasRole('Executive Officer'))
                    @else
                    @ITAdmin('member', 'write')
                    <a href="{{ url('type-of-activity')}}">Add Activity Type</a>
                    @endITAdmin
                    @endif
                </div> 
                @endif
            </div>
        </div>
        @endguest


        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <!-- Footer -->
    <footer class="mt-auto">
        <div class="footer" id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-11">
                        <h4 style="font-size: 20px; color: #F6CD25"> DeMolay Canada </h4>
                    </div>
                    <div class="footer-links">
                        <a href="{{ url('contacts')}}">Contact</a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="container">
                    <p class="pull-left"> Copyright © DeMolay Canada. All right reserved. </p>
                </div>
            </div>

    </footer>
</body>

</html>

@guest
@else
<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }

    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }
</script>
@endguest
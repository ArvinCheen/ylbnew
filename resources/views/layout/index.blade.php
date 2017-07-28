<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Metronic Admin Theme #1 | Invoice</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="Preview page of Metronic Admin Theme #1 for invoice sample" name="description" />
    <meta content="" name="author" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{ URL::asset('global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('layouts/layout/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('layouts/layout/css/themes/darkblue.min.css') }}" rel="stylesheet" type="text/css" id="style_color" />
    <link href="{{ URL::asset('layouts/layout/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    body {
        font-family: Microsoft JhengHei;
    }
</style>

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
<div class="page-wrapper">
    <div class="page-header navbar navbar-fixed-top">
        <div class="page-header-inner ">
            <div class="page-logo">
                <a href="index.html">
                    <img src="{{ URL::asset('layouts/layout/img/admins_logo_new.png') }}" alt="logo" class="logo-default" style="margin:10px 10px;width:100px;"/>
                </a>
                <div class="menu-toggler sidebar-toggler">
                    <span></span>
                </div>
            </div>
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                <span></span>
            </a>
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <span class="username username-hide-on-mobile"> Nick </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="page_user_profile_1.html">
                                    <i class="icon-user"></i> My Profile </a>
                            </li>
                            <li>
                                <a href="logout">
                                    <i class="icon-key"></i> Log Out </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="page-container">
        <div class="page-sidebar-wrapper">
            <div class="page-sidebar navbar-collapse collapse">
                <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                    <li class="sidebar-toggler-wrapper hide">
                        <div class="sidebar-toggler">
                            <span></span>
                        </div>
                    </li>
                    @foreach ($mainClass as $key => $val)
                    <li class="nav-item start ">
                        <a href="{{ $val['url'] }}" class="nav-link nav-toggle">

                            <i class="{{ $val['icon'] }}"></i>
                            <span class="title">{{ $val['name'] }}</span>
                            @if(isset($subClass[$key]))
                            <span class="arrow"></span>
                            @endif
                        </a>
                        @if(isset($subClass[$key]))
                            <ul class="sub-menu">
                            @foreach ($subClass[$key] as $val2)
                                <li class="nav-item  ">
                                    <a href="{{ $val2['url'] }}" class="nav-link ">
                                        <span class="title">{{ $val2['name'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                            </ul>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="page-content-wrapper">
            <div class="page-content">
                @yield('content')
            </div>
        </div>
    </div>
</div>
<script src="{{ URL::asset('global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/scripts/app.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('layouts/layout/scripts/layout.min.js') }}" type="text/javascript"></script>
</body>

</html>
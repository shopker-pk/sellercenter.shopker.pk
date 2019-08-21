<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $page_title }}</title>
    <meta name="keywords" content="{{ $meta_keywords }}">
    <meta name="description" content="{{ $meta_description }}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    @include('layouts.style')
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <a href="{{ route('dashboard') }}" class="logo">
                <span class="logo-mini"><b>Shopker</b>LT</span>
                <span class="logo-lg"><b>Shopker</b></span>
            </a>
            <nav class="navbar navbar-static-top">
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown messages-menu">
                            <a href="https://gmail.com">
                                <i class="fa fa-envelope-o"></i>
                            </a>
                        </li>
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ env('ADMIN_URL').'public/assets/admin/images/profile_images/'.Session::get('user_details')['image'] }}" class="user-image" alt="Profile Image">
                                <span class="hidden-xs">{{ Session::get('user_details')['name'] }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src="{{ env('ADMIN_URL').'public/assets/admin/images/profile_images/'.Session::get('user_details')['image'] }}" class="img-circle" alt="Profile Image">
                                    <p>{{ Session::get('user_details')['name'] }}</p>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{{ route('manage_profile_settings') }}" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{ route('vendor_sign_out') }}" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        @include('layouts.navigation')
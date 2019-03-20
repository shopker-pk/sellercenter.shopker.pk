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
    	<header class="main-header"></header>
		<div class="content-wrapper">
	        <div class="row">
	        	<div class="col-md-3"></div>
	        	<div class="col-md-5">
	    			<section class="content">
	    				@include('layouts.messages')
			            <form action="{{ route('vendor_validating_credentials') }}" method="post">
			            	{{ csrf_field() }}
			                <div class="box box-default">
			                    <div class="box-body">
			                    	<h2><center>Sign In</center></h2>
			                        <div class="row">
			                            <div class="col-md-12">
			                                <div class="form-group">
			                                    <label>Email</label><label class="label-control" style="color:red">*</label>
			                                    <input type="text" name="email" id="email" class="form-control" placeholder="Email*">
			                                </div>
			                            </div>
			                        </div>
			                        <div class="row">
			                            <div class="col-md-12">
			                                <div class="form-group">
			                                    <label>Password</label><label class="label-control" style="color:red">*</label>
			                                    <input type="password" name="password" id="password" class="form-control" placeholder="Password*">
			                                </div>
			                            </div>
			                        </div>
			                    </div>
			                    <div class="box-footer">
			                        <div class="row">
			                            <div class="col-md-5">
			                            	<a href="javascript::void(0);" class="btn btn-primary">Forget Password?</a>
			                            </div>
			                            <div class="col-md-4"></div>
			                            <div class="col-md-3">
			                                <button type="submit" class="btn btn-primary">&nbsp;&nbsp; Sign In &nbsp;</button>
			                            </div>
			                        </div>
			                        <div class="row">
			                            <div class="col-md-12">
			                            	<br><br><br>
			                            	Don’t have an account yet? <a href="javascript::void(0);"> Become A Seller</a>
			                            </div>
			                        </div>
			                    </div>
			                </div>
			            </form>
			        </section>    		
	        	</div>
	        </div>
	    </div>
@include('layouts.footer')
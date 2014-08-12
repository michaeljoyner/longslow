<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	@section('title')
	<title>Document</title>
	@show

	@section('head')
		<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
	@show
</head>
<body>
	@section('bodyheader')
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" id="main-nav">
		<div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    	<div class="navbar-header">
	      		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	        		<span class="sr-only">Toggle navigation</span>
	        		<span class="icon-bar"></span>
	        		<span class="icon-bar"></span>
	        		<span class="icon-bar"></span>
	      		</button>
	    		<a class="navbar-brand" href="{{ url('/') }}">Mr Writer</a>
	    	</div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		    	<ul class="nav navbar-nav">
		        	<li><a href="{{ route('admin.article.index') }}">Content</a></li>
		        	<li><a href="{{ route('admin.article.create') }}">New Post</a></li>
		        	@if( ! Auth::guest() )
		        	<li><a href="{{ route('user.show', Auth::user()->id) }}">Profile</a></li>
		        	@if( Auth::user()->role_id === 1 )
		        	<li><a href="{{ route('user.index') }}">Users</a></li>
                    <li><a href="{{ route('admin.category.index') }}">Categories</a> </li>
		        	@endif
		        	@endif
		    	</ul>
		    	<ul class="nav navbar-nav navbar-right">
			        <li class="dropdown">
			        	<a href="#" class="dropdown-toggle" data-toggle="dropdown">@if( ! Auth::guest() ) {{ Auth::user()->email }} @endif <span class="caret"></span></a>
			        	<ul class="dropdown-menu" role="menu">
                            <li><a href="{{ route('user.getpasswordreset') }}">Reset Password</a></li>
				            <li><a href="{{ route('logout') }}">Logout</a></li>
			        	</ul>
			        </li>
		    	</ul>
		    </div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
		</nav>
	@show

	@yield('content')

	@section('bodyscripts')
		<script src="{{ asset('js/jquery.min.js') }}"></script>
		<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	@show
</body>
</html>
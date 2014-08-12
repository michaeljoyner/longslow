<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	@section('title')
		<title>Mr. Writer</title>
		@show
	@section('head')
		<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css')}}">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		@show
</head>
<body>
	
	@yield('content')

	@section('bodyscripts')
		<script src="{{ asset('js/jquery.min.js') }}"></script>
		<script src="{{ asset('js/bootstrap.min.js') }}"></script>
		@show
</body>
</html>
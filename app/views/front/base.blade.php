<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	@section('title')
		<title>Long Slow Journey</title>
	@show
	@section('head')
		<link href='http://fonts.googleapis.com/css?family=Playfair+Display:400,700' rel='stylesheet' type='text/css'>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	@show
	@yield('socialsharing')
</head>
<body>
  @yield('content')

  @yield('bodyscripts')
</body>
</html>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Laravel PHP Framework</title>
	<style>
		@import url(//fonts.googleapis.com/css?family=Lato:500);

		body {
			margin:0;
			font-family:'Lato', sans-serif;
			text-align:center;
			color: #999;
		}

		.welcome {
			width: 300px;
			height: 200px;
			position: absolute;
			left: 50%;
			top: 50%;
			margin-left: -150px;
			margin-top: -100px;
		}

		a, a:visited {
			text-decoration:none;
		}

		h1 {
			font-size: 32px;
			margin: 16px 0 0 0;
		}
	</style>
</head>
<body>
	@foreach( $articles as $article )
		<a href="{{ url($article->slug) }}"><h1>{{ $article->title }}</h1></a>
		<h3>{{ $article->author['author']->fullname }}</h3>
		<h3>{{ $article->category->category }}</h3>
		<img src="{{ asset($article->cover['path']) }}"> 
		{{-- <p>{{ var_dump($article->cover) }}</p> --}}
		<p>{{ $article->excerpt }}</p>
		<hr/>
		<p>{{ \Michelf\MarkdownExtra::defaultTransform($article->content) }}</p>
		@foreach( $article->tags as $tag )
			<span>{{ $tag->tag }} </span>
		@endforeach
	@endforeach

	{{ $articles->links() }}
</body>
</html>

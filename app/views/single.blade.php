<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Laravel PHP Framework</title>
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<style>

		body {
			margin:0;
			padding-top: 50px;
			font-family: 'Playfair Display', serif;
			/*text-align:center;*/
			/*color: #999;*/
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

		.fixed-header {
		    position: fixed;
		    width: 100%;
		    height: 50px;
		    box-shadow: 0px 3px 6px #333;
		    top: 0;
		    background-color: #fff;
		    z-index: 200;
		}

		.fixed-header h3 {
		    margin: 0 1em;
		    font-size: 2em;
		}

		.cover-img-container {
		    width: 100%;
		    height: 22em;
		    @if($article->cover['path'])
		    background: url({{ $article->cover['path'] }}) no-repeat;
		    background-size: cover;
		    background-position: 0 50%;
		    @endif
		}

		.cover-img-container img {
		    width: 100%;
		    height: 100%;
		}

		.article {
		    max-width: 800px;
		    margin: 0 auto;
		    text-align: center;
		}

		.content-body {
		    font-size: 1.5em;
		    line-height: 37px;
		    text-align: left;
		}

		.content-body p img {
		    display: block;
		    width: 80%;
		    margin: 2em auto;
		}

		.article-title {
		    font-size: 3em;
		    margin: 1em 0;
		}

		.article-details {
		    position: relative;
		    text-align: left;
		    padding: 0 2em;
		}

		.date-box {
		    width: 30%;
		    display: inline-block;
		}

		.article-details i {
		    color: #990000;
		}

		.pub-date {
		    padding-left: 2em;
		}

		.tag-box {
		    float: right;
		}

		.tags {
		    padding-left: 2em;
		}

		.authorship {
		    margin: 3em 0;
            margin-bottom: 5em;
            clear: both;
		}

		.authorship img {
		    width: 200px;
            height: 200px;
            border-radius: 50%;
            float: left;
		}

		.author-name {
		    float: right;
            width: 60%;
            font-size: 1.4em;
		}

		.author-bio {
		    width: 60%;
            font-size: 1.2em;
            float: right;
		}
	</style>
		<link href='http://fonts.googleapis.com/css?family=Playfair+Display:400,700' rel='stylesheet' type='text/css'>
			<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <header class="fixed-header">
        <h3>Long Slow Journey</h3>
    </header>
    @if($article->cover['path'])
        <div class="cover-img-container">
		</div>
	@endif
		<div class="article">
	    <h1 class="article-title">{{ $article->title }}</h1>
		{{--<h3>{{ $article->category->category }}</h3>--}}
		<div class="article-details">
		    <div class="date-box"><i class="fa fa-calendar"></i><span class="pub-date">{{ $article->updated_at->toFormattedDatestring() }}</span></div>
		    <div class="tag-box">
		        <i class="fa fa-tag"></i><span class="tags">
		        @foreach($article->tags as $tag)
		            {{ $tag->tag.'    ' }}
		        @endforeach
		        </span>
		    </div>
		</div>
		<p class="content-body">{{ $article->excerpt }}</p>
		{{--<hr/>--}}
		<div class="content-body">{{ \Michelf\MarkdownExtra::defaultTransform($article->content) }}</div>
		<hr/>
		<section class="authorship">
		<img src="{{ asset($article->author['author']->getImageSrc()) }}" alt="author profile picture"/>
		<h3 class="author-name">{{ $article->author['author']->fullname }}</h3>
		<p class="author-bio">{{ $article->author['author']->bio }}</p>
		</section>
		</div>
</body>
</html>

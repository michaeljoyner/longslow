<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Laravel PHP Framework</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
        html {
            height: 100%;
        }
        html {
          box-sizing: border-box;
        }
        *, *:before, *:after {
          box-sizing: inherit;
        }
		body {
			margin:0;
			/*font-family:'Lato', sans-serif;*/
			text-align:center;
			/*color: #999;*/
			height: 100%;
		}

		/*.welcome {*/
			/*width: 300px;*/
			/*height: 200px;*/
			/*position: absolute;*/
			/*left: 50%;*/
			/*top: 50%;*/
			/*margin-left: -150px;*/
			/*margin-top: -100px;*/
		/*}*/

		a, a:visited {
			text-decoration:none;
			color: inherit;
		}

        .main-title {
            margin-top: 2em;
            color: #333;
            font-family: 'Playfair Display', serif;
            font-size: 3em;
            transition: 1s;
        }

        .scrolled .main-title {
            transform: translateY(-1.5em);
            background-color: #ffffff;
            z-index: 200;
            padding-bottom: 0.5em;
            margin-top: 1em;
            padding-top: 1em;
            box-shadow: 0px 5px 8px #525252;
        }

        .sub-title {
            color: #999;
            margin-bottom: 4em;
            font-family: 'Playfair Display', serif;
            font-weight: 400;
            font-size: 1.4em;
            transition: 1s;
        }

        .scrolled .sub-title {
            opacity: 0;
        }

		.title-image-container {
		    width: 100%;
            height: 26em;
            background: url("../images/lowly.jpg") no-repeat;
            background-size: cover;
            background-position-y: 25%;
            margin-top: 20em;
            transition: 1s;
            position: fixed;
            /*z-index: -100;*/
            pointer-events: none;
		}

		.scrolled .title-image-container {
		    transform: scale3d(.9,.9,.9) translateY(-100px);
		    opacity: 0;
		}

		.title-holder {
		    position: fixed;
		    width: 100%;
		    text-align: center;
		    pointer-events: none;
		}

		header {
		    height: 100%;
		    width: 100%;
		}

		.content {
		    max-width: 700px;
		    margin: 0 auto;
		    font-size: 1.5em;
		    font-family: 'Playfair Display', serif;
		    color: #525252;
		}

		.published {
		    position: relative;
		    text-align: center;
		    z-index: -1;
		}

		.published span {
		    padding: 0 1em;
            background-color: #fff;
            z-index: -1;
		}

		.published:before {
		    content: "";
		    width: 800px;
		    height: 3px;
		    background-color: #ccc;
		    position: absolute;
		    left: -6%;
		    top: 50%;
		    z-index: -100;
		}
	</style>
	<link href='http://fonts.googleapis.com/css?family=Playfair+Display:400,700' rel='stylesheet' type='text/css'>
</head>
<body>
    <header class="page-header">
        <div class="title-holder">
        <h1 class="main-title">Long Slow Journey</h1>
        <h3 class="sub-title">Thoughts from the back of the pack.</h3>
        </div>
        <div class="title-image-container"></div>
    </header>
    <div class="content">
    @foreach($articles as $article)
        <section class="article">
            <p class="published"><span>{{ $article->updated_at->toFormattedDatestring() }}</span></p>
            <h2 class="post-title"><a href="{{ url($article->slug) }}">{{ $article->title }}</a></h2>
            <p class="excerpt">{{ $article->excerpt }}</p>
        </section>
    @endforeach
    </div>
	{{--@foreach( $articles as $article )--}}
		{{--<a href="{{ url($article->slug) }}"><h1>{{ $article->title }}</h1></a>--}}
		{{--<h3>{{ $article->author['author']->fullname }}</h3>--}}
		{{--<h3>{{ $article->category->category }}</h3>--}}
		{{--<img src="{{ asset($article->cover['path']) }}"> --}}
		{{-- <p>{{ var_dump($article->cover) }}</p> --}}
		{{--<p>{{ $article->excerpt }}</p>--}}
		{{--<hr/>--}}
		{{--<p>{{ \Michelf\MarkdownExtra::defaultTransform($article->content) }}</p>--}}
		{{--@foreach( $article->tags as $tag )--}}
			{{--<span>{{ $tag->tag }} </span>--}}
		{{--@endforeach--}}
	{{--@endforeach--}}

	{{ $articles->links() }}
	<script>
	    var body = document.body;
	    var header = document.querySelector('header');
	    var content = document.querySelector('.content');
	    var img = document.querySelector('.title-image-container');
//	    body.addEventListener('scroll', pageScroll, false);
        window.onscroll = pageScroll;
	    function pageScroll(ev) {
	        var contrect = content.getBoundingClientRect();
	        var imrect = img.getBoundingClientRect();
	        console.log('Content: ' + contrect.top + " Image: " + imrect.bottom);
	        if(imrect.bottom > contrect.top) {
	            header.className = "scrolled";
	        } else {
	            header.className = "";
	        }
	    }

	</script>
</body>
</html>

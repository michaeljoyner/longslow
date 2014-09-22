<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Laravel PHP Framework</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		@import url(//fonts.googleapis.com/css?family=Lato:500);
        html {
            height: 100%;
        }
		body {
			margin:0;
			font-family:'Lato', sans-serif;
			text-align:center;
			color: #999;
			height: 100%;
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

        .main-title {
            margin-top: 3em;
            color: #333;
            font-family: 'Playfair Display', serif;
            font-size: 3em;
        }

        .sub-title {
            color: #999;
            margin-bottom: 4em;
            font-family: 'Playfair Display', serif;
            font-weight: 400;
            font-size: 1.4em;
        }

		.title-image-container {
		    width: 100%;
            height: 26em;
            background: url("../images/lowly.jpg") no-repeat;
            background-size: cover;
            background-position-y: 25%;
            margin-top: 20em;
		}

		.title-holder {
		    position: fixed;
		    top: 2em;
		    width: 100%;
		    text-align: center;
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
	</style>
	<link href='http://fonts.googleapis.com/css?family=Playfair+Display:400,700' rel='stylesheet' type='text/css'>
</head>
<body>
    <header>
        <div class="title-holder">
        <h1 class="main-title">Long Slow Journey</h1>
        <h3 class="sub-title">Thoughts from the back of the pack.</h3>
        </div>
        <div class="title-image-container"></div>
    </header>
    <div class="content">Bacon ipsum dolor sit amet boudin pig turkey corned beef kielbasa. Meatloaf doner rump sausage meatball beef ribs shank bresaola spare ribs jowl bacon cow leberkas. Corned beef frankfurter pig, beef ribs porchetta cow beef kielbasa. Filet mignon frankfurter strip steak, sirloin tenderloin kevin pork loin pork bacon tail beef doner prosciutto. Meatloaf sausage capicola fatback pork chop tri-tip chicken kevin cow turkey bacon chuck rump ribeye hamburger.

                         Rump pork andouille corned beef, brisket tongue shank beef ribs bresaola tri-tip tenderloin spare ribs doner biltong strip steak. Boudin pig ball tip spare ribs, fatback beef sausage pastrami leberkas sirloin meatloaf chuck kevin brisket ribeye. Rump pork loin leberkas swine ground round biltong. Bacon ground round pastrami ham hock, kielbasa fatback turducken pork loin flank bresaola salami boudin. Kielbasa pork loin swine beef ribs, ribeye chicken hamburger pork belly landjaeger prosciutto brisket fatback. Hamburger pastrami salami landjaeger meatball.

                         Rump tenderloin jowl frankfurter, sausage shank leberkas meatloaf short ribs doner. Jowl tri-tip tongue pastrami turducken boudin strip steak brisket pork loin swine capicola short ribs chuck beef ribs shankle. Bacon kielbasa ham venison kevin brisket. Short ribs beef ribs pork pork loin sausage shankle. Ham tail capicola ribeye prosciutto pork loin shank pork belly chuck chicken pastrami ball tip cow flank pig.</div>
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

@extends('front.base')

@section('head')
   @parent
   <link rel="stylesheet" href="{{ asset('styles/css/frontpages/homepage.min.css') }}"/>
@stop

@section('content')
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
            <h2 class="post-title"><a href="{{ url('/articles/'.$article->slug) }}">{{ $article->title }}</a></h2>
            <p class="excerpt">{{ $article->excerpt }}</p>
        </section>
    @endforeach
    </div>
		{{ $articles->links() }}
@stop

@section('bodyscripts')
<script>
    var body = document.body;
    var header = document.querySelector('header');
    var content = document.querySelector('.content');
    var img = document.querySelector('.title-image-container');
    window.onscroll = pageScroll;
    function pageScroll(ev) {
        var contrect = content.getBoundingClientRect();
        var imrect = img.getBoundingClientRect();
        if(imrect.bottom > contrect.top) {
            header.className = "page-header scrolled";
        } else {
            header.className = "page-header";
        }
    }
</script>
@stop
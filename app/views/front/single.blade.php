@extends('front.base')

@section('title')
    <title>{{ $article->title }}</title>
@stop
@section('head')
    @parent
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('styles/css/frontpages/frontsingle.min.css') }}"/>
    <style>
    .cover-img-container {
        width: 100%;
        height: 22em;
        @if($article->cover['path'])
        background: url({{ $article->cover['path'] }}) no-repeat;
        background-size: cover;
        background-position: 0 50%;
        @endif
    }
    </style>
@stop

@section('content')
    <header class="fixed-header">
        <h3><a href="/">Long Slow Journey</a></h3>
    </header>
    @if($article->cover['path'])
        <div class="cover-img-container">
		</div>
	@endif
		<div class="article">
	    <h1 class="article-title">{{ $article->title }}</h1>
		<div class="article-details">
		    <div class="date-box"><i class="fa fa-calendar"></i><span class="pub-date">{{ $article->updated_at->toFormattedDatestring() }}</span></div>
		    <div class="tag-box">
		        <i class="fa fa-tag"></i><span class="tags">
		        @foreach($article->tags as $tag)
		            {{ '#'.$tag->tag.' ' }}
		        @endforeach
		        </span>
		    </div>
		</div>
		<p class="content-body">{{ $article->excerpt }}</p>
		<div class="content-body">{{ \Michelf\MarkdownExtra::defaultTransform($article->content) }}</div>
		<hr/>
		<section class="authorship">
		<img src="{{ asset($article->author['author']->getImageSrc()) }}" alt="author profile picture"/>
		<h3 class="author-name">{{ $article->author['author']->fullname }}</h3>
		<p class="author-bio">{{ $article->author['author']->bio }}</p>
		</section>
		</div>
		<div class="page-footer"></div>
@stop
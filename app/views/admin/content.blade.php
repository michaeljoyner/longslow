@extends('admin.adminbase')

@section('title')
	<title>Mr Writer</title>
@stop

@section('head')
@parent
	<link rel="stylesheet" href="{{ asset('css/admincontent.css') }}">
@stop

@section('bodyheader')
	@parent
@stop

@section('content')
	<div class="container-fluid">
		<div id="sidebar" class="col-sm-4">
			
		</div>
		<div id="contentlist" class="col-sm-8">
			@foreach($articles as $article)
				<div class="row">
					<article class="article_card" id="article_card{{ $article->id }}">
						<h2 class="article-title">{{ $article->title }}</h2>
						<p class="article-excerpt">{{ $article->excerpt }}</p>
						<div class="category-box"><span class="article-category">{{ $article->category->category }}</span></div>
						<hr>
						@if($article->created_at->eq($article->updated_at))
						<p class="article-date"><span class="glyphicon glyphicon-calendar"></span> {{ $article->created_at->diffForHumans() }} &nbsp;&nbsp;&nbsp;&nbsp; <span class="glyphicon glyphicon-user"></span> {{ $article->author['author']->fullname }}</p>
						@else
						<p class="article-date"><span class="glyphicon glyphicon-calendar"></span> {{ $article->updated_at->diffForHumans() }} &nbsp;&nbsp;&nbsp;&nbsp; <span class="glyphicon glyphicon-user"></span> {{ $article->author['author']->fullname }}</p>
						@endif
						@if(Auth::user()->role_id < 3 || $article->author->id === Auth::user()->id)
						<div class="actions">
							<a href="{{ route('admin.article.edit', $article->id) }}"><span class="glyphicon glyphicon-edit"></span></a>
							<span class="glyphicon glyphicon-trash delete_article" data-id="{{ $article->id }}"></span>
						</div>
						@endif
					</article>
				</div>
			@endforeach
			{{ $articles->links() }}
		</div>
	</div>
	<!-- modal for delete article confirmation -->
	<div class="modal fade" id="deleteModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-primary">
					<button type="button" id="okClose" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title"><span class="glyphicon glyphicon-trash"></span>&nbsp;&nbsp;&nbsp;&nbsp;Are you certain?</h4>
				</div>
				<div class="modal-body">
					<p>Once it's gone, it can never come back. So take a deep breath and ask yourself, "Is it time for this to die?".</p>
				</div>
				<div class="modal-footer">
					<button type="button" id="okCancel" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" id="okDelete" class="btn btn-primary">Delete it!</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
@stop

@section('bodyscripts')
@parent
	<script src="{{ asset('js/admin/articledeleter.js') }}"></script>
	<script>
		var deleteList = document.querySelectorAll('.delete_article');
		var i = 0, l = deleteList.length;
		for(i;i<l;i++) {
			deleteList[i].addEventListener('click', articleDeleteHelper.init, false);
		}
	</script>
@stop
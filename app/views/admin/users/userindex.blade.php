@extends('admin.adminbase')

@section('head')
@parent
<link rel="stylesheet" href="{{ asset('styles/css/pages/userindex.min.css') }}"/>
@stop

@section('content')
    <div class="clearfix">
        <h1 class="page-title pull-left">The Team</h1>
        <a href="{{ route('user.create') }}"><button class="btn btn-danger blockbutton createbutton pull-right">Add new teammate</button></a>
    </div>
    <hr/>
	<h2 class="team-title">Honchos</h2>
	@foreach($honchos as $honcho)
		<div class="person-box">
			<p class="person-name">{{ $honcho->author->fullname }}</p>
			<div class="profile-img-box"><img src="{{ asset($honcho->author->getImageSrc()) }}" alt="" class="profile-img"></div>
			<p class="person-bio">{{ $honcho->author->bio }}</p>
            <div class="action-box"><a href="{{ route('user.edit', $honcho->id) }}"><span class="profile-edit">Edit</span></a></div>
		</div>
	@endforeach
	<h2 class="team-title">Editors</h2>
	@foreach($editors as $editor)
		<div class="person-box">
			<p class="person-name">{{ $editor->author->fullname }}</p>
			<div class="profile-img-box"><img src="{{ asset($editor->author->getImageSrc()) }}" alt="" class="profile-img"></div>
			<p class="person-bio">{{ $editor->author->bio }}</p>
            <div class="action-box"><a href="{{ route('user.edit', $editor->id) }}"><span class="profile-edit">Edit</span></a></div>
        </div>
	@endforeach
	<h2 class="team-title">Writers</h2>
	@foreach($writers as $writer)
		<div class="person-box writer-box">
			<p class="person-name">{{ $writer->author->fullname }}</p>
			<div class="profile-img-box"><img src="{{ asset($writer->author->getImageSrc()) }}" alt="" class="profile-img"></div>
			<p class="person-bio">{{ $writer->author->bio }}</p>
            <div class="action-box"><a href="{{ route('user.edit', $writer->id) }}"><span class="profile-edit">Edit</span></a></div>
        </div>
	@endforeach
@stop
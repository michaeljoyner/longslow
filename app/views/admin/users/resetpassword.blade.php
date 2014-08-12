@extends('admin.adminbase')

@section('head')
@parent
<link rel="stylesheet" href="{{ asset('styles/css/pages/resetpassword.min.css') }}"/>
@stop

@section('content')
<div class="profile-header">
    <div class="image-box">
        <img src="{{ asset($user->author->getImageSrc()) }}" alt="profile pic" id="profile-img-preview"
             class="profile-img">
    </div>
</div>
{{ Form::open(array('method' => 'PUT', 'route' => array('user.resetpassword', Auth::user()->id), 'class' => 'form-horizontal admin-form')) }}
{{ Form::passwordField('old_password', 'current password') }}
{{ Form::passwordWithConfirmation('password', 'new password') }}
{{ Form::submitField('submit', 'Reset Password') }}
{{ Form::close() }}
@stop
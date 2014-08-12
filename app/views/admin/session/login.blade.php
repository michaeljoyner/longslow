@extends('admin.adminbase')

@section('head')
@parent
	<style>
		form {
			max-width: 400px;
			margin: 0 auto;
		}
	</style>
@stop

@section('bodyheader')
@stop

@section('content')
	{{ Form::open(array('url' => '/session')) }}
		<h1 class="form_title">Please Login</h1>
		<div class="row">
			<div class="col-sm-12">
				<label for="email">Email:</label>
				<input type="email" placeholder="email" name="email" id="email" class="form-control">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<label for="password">Password:</label>
				<input type="password" placeholder="password" name="password" id="password" class="form-control">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<button type="submit" class="btn btn-info form-control">Login</button>
			</div>
		</div>
	{{ Form::close() }}
@stop
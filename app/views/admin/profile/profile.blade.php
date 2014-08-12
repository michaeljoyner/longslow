@extends('admin.adminbase')

@section('head')
@parent
<link rel="stylesheet" href="{{ asset('styles/css/pages/userprofile.min.css') }}"/>
@stop

@section('content')
<div class="profile-header">
	<div class="image-box">
		<label for="profile-pic">
			@if( ! $profile->author->profilepic )
			<img src="{{ asset('images/me.jpg') }}" alt="profile pic" id="profile-img-preview" class="profile-img">
			@else
			<img src="{{ asset($profile->author->profilepic) }}" alt="profile pic" id="profile-img-preview" class="profile-img">
			@endif
			<input type="file" name="profile-pic" id="profile-pic">
		</label>
	</div>
</div>
{{ Form::open(array('method' => 'PUT', 'route' => array('user.update', Auth::user()->id), 'id' => 'profileform', 'class' => 'admin-form form-horizontal')) }}
	{{ Form::textField('fullname', 'name', $profile->author->fullname) }}
    {{ Form::emailField('email', 'email', $profile->email) }}
    {{ Form::textAreaField('bio', 'bio', $profile->author->bio) }}
    {{ Form::submitField('submit', 'Update Profile') }}
{{ Form::close() }}
@stop

@section('bodyscripts')
@parent
	<script>
		var profileImageHandler = {
			elems: {
				fileselect: document.getElementById('profile-pic'),
				preview: document.getElementById('profile-img-preview')
			},

			addEvents: function() {
				profileImageHandler.elems.fileselect.addEventListener('change', profileImageHandler.handleSelect, false);
			},

			init: function() {
				profileImageHandler.addEvents();
			},

			handleSelect: function(ev) {
				if(ev.target.files[0].type.indexOf('image') !== 0) {
					console.log('not a pic');
				} else {
					console.log('thats a pic!');
					profileImageHandler.processImage(ev.target.files[0]);	
				}
			},

			processImage: function(file) {
				var reader = new FileReader();
				var img = new Image();
				img.onload = function() {
					profileImageHandler.cropImage(img);
				};
				reader.onload = function(ev) {
					img.src = ev.target.result;
				};
				reader.readAsDataURL(file);
			},

			cropImage: function(img) {
				var newImg = new Image();
				var canvas = document.createElement('canvas');
				var cxt = canvas.getContext('2d');
				canvas.width = 300;
				canvas.height = 300;
				cxt.drawImage(img, (img.width - img.height)/2, 0, img.height, img.height, 0, 0, canvas.width, canvas.height);
				newImg.onload = function() {
					profileImageHandler.elems.preview.src = newImg.src;
					profileImageHandler.uploadImage(newImg.src);
				}
				newImg.src = canvas.toDataURL();

			},

			uploadImage: function(img) {
				var req = new XMLHttpRequest();
				var fd = new FormData();
				fd.append('image', img);
				req.open("POST", '/admin/profileimageupload', true);
				// req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				req.onload = function(ev) {
					console.log(ev.target.response);
				}
				req.send(fd);
			}
		}
		profileImageHandler.init();
	</script>
@stop
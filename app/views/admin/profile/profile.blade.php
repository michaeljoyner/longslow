@extends('admin.adminbase')

@section('head')
@parent
<link rel="stylesheet" href="{{ asset('styles/css/pages/userprofile.min.css') }}"/>
@stop

@section('content')
<div class="profile-header">
	<div class="image-box">
		<label for="profile-pic">
			<img src="{{ asset($profile->author->getImageSrc()) }}" alt="profile pic" id="profile-img-preview" class="profile-img">
			<input type="file" name="profile-pic" id="profile-pic">
		</label>
	</div>
	<p id="error-message" class="error-message"></p>
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
					profileImageHandler.errorMessage.showMessage("Sorry, that is not an acceptable image type.", false);
				} else {
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
					if(ev.target.status === 200) {
					    profileImageHandler.errorMessage.showMessage("Profile image successfully updated", true);
					} else {
					    profileImageHandler.errorMessage.showMessage("Failed: " + ev.target.responseText, false);
					}
				}
				req.send(fd);
			},

			errorMessage: {
			    elems: {
			        container: document.querySelector('#error-message')
			    },

			    showMessage: function(message, success) {
			        profileImageHandler.errorMessage.elems.container.innerHTML = message;
			        if(success) {
			            profileImageHandler.errorMessage.elems.container.classList.add('success');
			        } else {
			            profileImageHandler.errorMessage.elems.container.classList.add('failure');
			        }
			        profileImageHandler.errorMessage.elems.container.style.width = "30em";
			        var timer = window.setTimeout(profileImageHandler.errorMessage.hideMessage, 3000);
			    },

			    hideMessage: function() {
			        profileImageHandler.errorMessage.elems.container.className = 'error-message';
			        profileImageHandler.errorMessage.elems.container.style.width = '0';
			        profileImageHandler.errorMessage.elems.container.innerHTML = "";
			    }
			}
		}
		profileImageHandler.init();
	</script>
@stop
@extends('admin.adminbase')

@section('head')
@parent
<link rel="stylesheet" href="{{ asset('styles/css/pages/usercreate.min.css') }}"/>
@stop

@section('content')
@foreach($errors as $message)
<p>{{ $message }}</p>
@endforeach
    <h1 class="page-title">Create a New User</h1>
	{{ Form::open(array('route' => 'user.store', 'id' => 'newuserform', 'class' => 'admin-form form-horizontal')) }}
       {{ Form::emailField('email', 'email') }}
        {{ Form::passwordWithConfirmation('password', 'password') }}
        {{ Form::textField('fullname', 'full name') }}

		<div class="col-sm-offset-3 col-sm-9">
			<div class="row user-types">
				<div class="col-sm-4">
					<label for="role_id1" class="user-role-label">
						<div class="user-type-box">
							<input id="role_id1" type="radio" value="1" name="role_id">
							<h4 class="role-title">Head Honcho</h4>
							<p class="icon-holder"><span class="glyphicon glyphicon-user"></span></p>
							<ul class="user-permission-list">
								<li class="permission">Create new posts</li>
								<li class="permission">Can edit or delete any post</li>
								<li class="permission">Add new users/writers</li>
								<li class="permission">Manage categories</li>
							</ul>
						</div>
					</label>
				</div>
				<div class="col-sm-4">
					<label for="role_id2" class="user-role-label">
						<div class="user-type-box">
							<input id="role_id2" type="radio" value="2" name="role_id">
							<h4 class="role-title">Editor</h4>
							<p class="icon-holder"><span class="glyphicon glyphicon-user"></span></p>
							<ul class="user-permission-list">
								<li class="permission">Create new posts</li>
								<li class="permission">Can edit or delete any post</li>
							</ul>
						</div>
					</label>
				</div>
				<div class="col-sm-4">
					<label for="role_id3" class="user-role-label">
						<div class="user-type-box active">
							<input id="role_id3" type="radio" value="3" name="role_id">
							<h4 class="role-title">Writer</h4>
							<p class="icon-holder"><span class="glyphicon glyphicon-user"></span></p>
							<ul class="user-permission-list">
								<li class="permission">Create new posts</li>
								<li class="permission">Can only edit or delete own posts</li>
							</ul>
						</div>
					</label>
				</div>
			</div>
		</div>
		{{ Form::submitField('submit', 'Create User') }}
	{{ Form::close() }}
@stop

@section('bodyscripts')
	<script>
		var userRoleSelector = {
			currentChoice: null,

			elems: {
				headHonchoRadio: document.getElementById('role_id1'),
				editorRadio: document.getElementById('role_id2'),
				writerRadio: document.getElementById('role_id3')
			},

			addEvents: function() {
				userRoleSelector.elems.headHonchoRadio.addEventListener('change', userRoleSelector.changeSelection, false);
				userRoleSelector.elems.editorRadio.addEventListener('change', userRoleSelector.changeSelection, false);
				userRoleSelector.elems.writerRadio.addEventListener('change', userRoleSelector.changeSelection, false);
			},

			changeSelection: function(ev) {
				userRoleSelector.currentChoice.parentNode.classList.remove('active');
				userRoleSelector.currentChoice = ev.target;
				ev.target.parentNode.classList.add('active');
			},

			init: function() {
				this.currentChoice = this.elems.writerRadio;
                this.currentChoice.checked = true;
				this.addEvents();
			}
		}

		userRoleSelector.init();
	</script>
@stop
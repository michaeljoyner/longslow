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
	<script>
        var passwordReporter = {
            elems: {
                password: document.querySelector('#password'),
                confirm: document.querySelector('#password_confirmation'),
                passwordReport: document.querySelector('#password-report'),
                confirmReport: document.querySelector('#password-confirm-report')
            },

            attachEvents: function() {
                passwordReporter.elems.password.addEventListener('keyup', passwordReporter.reportOnPassword, false);
                passwordReporter.elems.confirm.addEventListener('keyup', passwordReporter.reportOnConfirm, false);
            },

            reportOnPassword: function(ev) {
                var input = ev.target.value;
                var onlyletters = /^[a-zA-Z]+$/;
                var alphanumeric = /^[a-zA-Z0-9]+$/;
                var specialchars = /^[a-zA-Z0-9!@#$&*]+$/;
                if(input.length === 0) {
                    passwordReporter.elems.passwordReport.innerHTML = '';
                    passwordReporter.elems.passwordReport.className = '';
                } else if(input.length < 8) {
                    passwordReporter.elems.passwordReport.innerHTML = 'Too short';
                    passwordReporter.elems.passwordReport.className = 'fail';
                } else if(onlyletters.test(input)) {
                    passwordReporter.elems.passwordReport.innerHTML = 'Good job';
                    passwordReporter.elems.passwordReport.className = 'okay';
                } else if(alphanumeric.test(input)) {
                    passwordReporter.elems.passwordReport.innerHTML = 'Great job';
                    passwordReporter.elems.passwordReport.className = 'great';
                } else if(specialchars.test(input)) {
                    passwordReporter.elems.passwordReport.innerHTML = 'Excellent job';
                    passwordReporter.elems.passwordReport.className = 'great';
                } else {
                    passwordReporter.elems.passwordReport.innerHTML = 'Not acceptable';
                    passwordReporter.elems.passwordReport.className = 'fail';
                }

                passwordReporter.checkConfirm(passwordReporter.elems.confirm.value);
            },

            reportOnConfirm: function(ev) {
                passwordReporter.checkConfirm(ev.target.value);
            },

            checkConfirm: function(input) {
                var password = passwordReporter.elems.password.value;
                var report = passwordReporter.elems.confirmReport;

                if(input.length === 0) {
                    report.innerHTML = '';
                    report.className = '';
                } else if(input === password) {
                    report.innerHTML = 'matches';
                    report.className = 'great';
                } else {
                    report.innerHTML = 'not a match';
                    report.className = 'fail';
                }
            }
        };

        passwordReporter.attachEvents();
    </script>
@stop
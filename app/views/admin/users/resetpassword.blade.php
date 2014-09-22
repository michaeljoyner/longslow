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

@section('bodyscripts')
@parent
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
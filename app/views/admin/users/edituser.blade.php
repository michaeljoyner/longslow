@extends('admin.adminbase')

@section('head')
@parent
<link rel="stylesheet" href="{{ asset('styles/css/pages/useredit.min.css') }}"/>
@stop

@section('content')
<div class="profile-header">
    <div class="image-box">
            <img src="{{ asset($profile->author->getImageSrc()) }}" alt="profile pic" id="profile-img-preview" class="profile-img">
    </div>
</div>
<h1 class="user-fullname">{{ $profile->author->fullname }}</h1>
{{ Form::open(array('method' => 'PUT', 'route' => array('user.updaterole', $profile->id), 'class' => 'admin-form', 'id' => 'role-update-form')) }}
<div class="row user-types">
    <div class="col-sm-4">
        <label for="role_id1" class="user-role-label">
            <div class="user-type-box">
                <input id="role_id1" type="radio" value="1" name="role_id" @if($profile->role_id == 1) {{ 'checked' }} @endif>
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
                <input id="role_id2" type="radio" value="2" name="role_id" @if($profile->role_id == 2) {{ 'checked' }} @endif>
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
            <div class="user-type-box">
                <input id="role_id3" type="radio" value="3" name="role_id" @if($profile->role_id == 3) {{ 'checked' }} @endif>
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
{{ Form::submitField('submit', 'Update') }}
{{ Form::close() }}

@if(Auth::user()->id != $profile->id)
{{ Form::open(array('method' => 'DELETE', 'route' => array('user.destroy', $profile->id), 'id' => 'delete-user-form', 'class' => 'admin-form')) }}
<div class="row">
    <div class="col-sm-offset-4 col-sm-4">
        <div class="btn btn-danger form-control blockbutton secondblockbutton" id="modalTrigger">Delete User</div>
    </div>
</div>
{{ Form::close() }}
@endif
<!-- modal for delete user confirmation -->
<div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" id="okClose" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-trash"></span>&nbsp;&nbsp;&nbsp;&nbsp;Are you certain?</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to get rid of this team member? Consider wisely&hellip;</p>
            </div>
            <div class="modal-footer">
                <button type="button" id="okCancel" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="okDelete" class="btn btn-primary">I'm Sure</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop

@section('bodyscripts')
@parent
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

        getSelectedRadioButton: function() {
            if(this.elems.headHonchoRadio.checked) {
                return this.elems.headHonchoRadio;
            } else if(this.elems.editorRadio.checked) {
                return this.elems.editorRadio;
            } else {
                return this.elems.writerRadio;
            }
        },

        init: function() {
            this.currentChoice = this.getSelectedRadioButton();
            this.currentChoice.parentNode.classList.add('active');
            this.currentChoice.checked = true;
            this.addEvents();
        }
    }

    var userDeleter = {
        elems: {
            modal: document.getElementById('deleteModal'),
            modalOk: document.getElementById('okDelete'),
            modalCancel: document.getElementById('okCancel'),
            modalClose: document.getElementById('okClose'),
            trigger: document.getElementById('modalTrigger'),
            form: document.getElementById('delete-user-form')
        },

        addEvents: function() {
            userDeleter.elems.modalCancel.addEventListener('click', userDeleter.closeModal, false);
            userDeleter.elems.modalClose.addEventListener('click', userDeleter.closeModal, false);
            userDeleter.elems.modalOk.addEventListener('click', userDeleter.submitForm, false);
        },

        removeEvents: function() {
            userDeleter.elems.modalCancel.removeEventListener('click', userDeleter.closeModal, false);
            userDeleter.elems.modalClose.removeEventListener('click', userDeleter.closeModal, false);
            userDeleter.elems.modalOk.removeEventListener('click', userDeleter.submitForm, false);
        },

        openModal: function() {
            $(userDeleter.elems.modal).modal('show');
        },

        closeModal: function() {
            userDeleter.removeEvents();
            $(userDeleter.elems.modal).modal('hide');
        },

        submitForm: function() {
            userDeleter.elems.form.submit();
        },

        init: function() {
            userDeleter.addEvents();
            userDeleter.elems.trigger.addEventListener('click', userDeleter.openModal, false);
        }
    }

    userRoleSelector.init();
    userDeleter.init();
</script>
@stop
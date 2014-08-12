@extends('admin.adminbase')

@section('head')
@parent
<link rel="stylesheet" href="{{ asset('styles/css/pages/categorycreate.min.css') }}"/>
@stop

@section('content')
@if(Session::get('flash_message'))
<p>{{ Session::get('flash_message') }}</p>
@endif
<h1 class="page-title">Create a Category</h1>
<hr/>
{{ Form::open(array('route' => 'admin.category.store', 'id' => 'category_create_form', 'class' => 'form-horizontal admin-form', 'files' => true)) }}
{{ Form::textField('category', 'Category') }}
{{ Form::textAreaField('description', 'category description') }}
{{ Form::fileSelector('cover', 'cover image') }}
{{ Form::submitField('submit', 'Create Category') }}
@stop

@section('bodyscripts')
@parent
<script>
    var imagePreviewer = {
        elems: {
            container: document.getElementById('cover-preview'),
            select: document.getElementById('cover')
        },

        addEvents: function() {
            imagePreviewer.elems.select.addEventListener('change', imagePreviewer.handleFile, false);
        },

        handleFile: function(ev) {
            var file = ev.target.files[0];
            if(file.type.indexOf('image') !== 0) {
                //handle error
                return false;
            }
            imagePreviewer.processFile(file);
        },

        processFile: function(file) {
            var reader = new FileReader();
            var img = new Image();
            reader.onload = function(ev) {
                img.src = ev.target.result;
                imagePreviewer.showPreview(img);
            };
            reader.readAsDataURL(file);
        },

        showPreview: function(img) {
            imagePreviewer.elems.container.appendChild(img);
        },

        init: function() {
            imagePreviewer.addEvents();
        }
    }
    imagePreviewer.init();
</script>
@stop
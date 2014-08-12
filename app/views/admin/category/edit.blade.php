@extends('admin.adminbase')

@section('head')
@parent
<link rel="stylesheet" href="{{ asset('styles/css/pages/categorycreate.min.css') }}"/>
@stop


@section('content')
<h1 class="page-title">Edit this Category</h1>
<hr/>
{{ Form::model($category, ['method' => 'PUT', 'route' => ['admin.category.update', $category->id], 'id' => 'edit-category-form', 'files' => true, 'class' => 'form-horizontal admin-form']) }}
    {{ Form::textField('category', 'Category') }}
    {{ Form::textAreaField('description', 'category description') }}
    {{ Form::fileSelector('cover', 'cover image', $category->cover) }}
    {{ Form::submitField('submit', 'Update Category') }}
{{ Form::close() }}
@stop

@section('bodyscripts')
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
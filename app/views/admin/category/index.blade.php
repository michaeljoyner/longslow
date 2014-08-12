@extends('admin.adminbase')

@section('head')
@parent
<link rel="stylesheet" href="{{ asset('styles/css/pages/categoryindex.min.css') }}"/>
<style>



</style>
@stop

@section('content')
    <div class="clearfix">
        <h1 class="page-title pull-left">Categories</h1>
        <a href="{{ route('admin.category.create') }}"><button class="btn btn-danger blockbutton createbutton pull-right">Add new category</button></a>
    </div>
    <hr/>
    <ul>
        @foreach($categories as $category)
        <div class="category-box">
            <div class="cover-box">
                <img class="cover" src="{{ asset($category->cover) }}" alt="category image"/>
                <p class="category-title">{{ $category->category }}</p>
            </div>
            <div class="content-box">
                <p class="description">{{ $category->description }}</p>
                <a class="edit-button" href="{{ route('admin.category.edit', $category->id) }}">
                    <button class="btn btn-info form-control">Edit</button>
                </a>
            </div>
        </div>
        @endforeach
    </ul>
@stop
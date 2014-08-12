@extends('admin.adminbase')

@section('head')
	@parent
	<script src="  {{ asset('js/Markdown.Converter.js')}} "></script>
	<script src="  {{ asset('js/Markdown.Sanitizer.js')}} "></script>
	<script src="  {{ asset('js/Markdown.Editor.js')}} "></script>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/demo.css')}}">
	<link rel="stylesheet" href="{{ asset('css/admincreate.css') }}">
	@stop

@section('content')


<!-- form iteself -->
{{ Form::open(array('route' => ['admin.article.update', $article->id], 'method' => 'PUT', 'id' => 'articleform', 'files' => true)) }}
	<div class="row">
		<div class="col-sm-12">
			<input id="title" type="text" value="@if(Input::old('title')){{ Input::old('title') }}@else{{ $article->title }}@endif" name="title" placeholder="Your title" class="form-control">
		</div>
	</div>
	<!-- excerpt and cover picture -->
	<div id="post_meta_box">
		<div class="row">
			<div class="col-md-5" id="excerpt_box">
				<textarea id="excerpt_txt" rows="10" cols="50" name="excerpt" placeholder="Excerpt" class="form-control">@if(Input::old('excerpt')){{ Input::old('excerpt') }}@else{{ $article->excerpt }}@endif</textarea>
			</div>
			<div class="col-md-7" id="picture_box">
				<div id="cover_pic_upload_box">
					<label for="cover_pic">Click to select cover pic
						<input type="file" name="cover_pic" id="cover_pic">
					</label>
					<div id="cover_pic_preview">
						@if($article->cover)
							<img src="{{ asset($article->cover['path']) }}" alt="cover image">
						@endif
					</div>
					<div id="cover_pic_error"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- content and preview -->
	<div id="writing_area">
		<div class="row">
			<div class="col-md-5">
				 <div class="wmd-panel">
			          <div id="wmd-button-bar"></div>
			          <textarea class="wmd-input" id="wmd-input" name="content">@if(Input::old('content')){{ Input::old('content') }}@else{{ $article->content }}@endif</textarea>
			     </div>
			</div>
			<div class="col-md-7">
				<div id="wmd-preview" class="wmd-panel wmd-preview">
     			</div>
			</div>
		</div>
	</div>
	<!-- footer with category, tags and submit -->
	<div id="footbar" class="row">
		<div id="category_container" class="col-md-2">
			<select name="category_id" id="category" class="form-control">
				<option value="0">Category</option>
				@foreach($categories as $category)
					<option value="{{ $category->id }}" @if(! Input::old('category_id') && $article->category_id === $category->id) {{ 'selected' }} @elseif(Input::old('category_id') == $category->id) {{ 'selected' }} @endif >{{ $category->category }}</option>
				@endforeach
			</select>
		</div>
		<div id="tags_container" class="col-md-8">
			<div class="input-group">
				<span class="input-group-addon" id="tagaddon"><span class="glyphicon glyphicon-tags"></span></span>
				<input type="text" id="taglist" value="@if(Input::old('tags')){{ Input::old('tags') }}@else{{ $tags }}@endif" name="tags" placeholder="tag things here" class="form-control">
			</div>
		</div>
		<div id="submit_container" class="col-md-2">
			<!-- Single button -->
			<div class="btn-group dropup" id="submit_btn_grp">
				<button type="button" class="btn btn-danger dropdown-toggle form-control" data-toggle="dropdown" id="submitbutton">
			    	Publish <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu" id="publish_options_list">
			    	<li id="draft_save">Save as draft</li>
			    	<li id="publish_save">Publish and Push to top</li>
			    	<li id="publish_silent">Publish, but don't push to top</li>
				</ul>
			</div>
		</div>
	</div>
	<input type="hidden" value="1" name="status_id" id="statusflag">
</form>
<!-- bootstrap modal dialog for image insert -->
<div class="modal fade" id="insertImageModal" tabindex="-1" role="dialog" aria-labelledby="insertPicLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close picmodalHide" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="insertPicLabel">Insert Image</h4>
			</div>
			<div class="modal-body">
				<label for="imageToUpload" id="fileUploadLabel"><span class="glyphicon glyphicon-picture"></span> Browse files
					<input type="file" name="selectImage" id="imageToUpload">
				</label>
				<div class="image_preview"></div>
				<div id="uploadErrors" class="clearfix"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default picmodalHide" data-dismiss="modal" data-target="#insertImageModal">Close</button>
				<button type="button" class="btn btn-primary" id="insertBtn" disabled>Insert</button> 
			</div>
		</div>
	</div>
</div>
<!-- modal for error messages -->
<div class="modal fade" id="error_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Please correct the following errors</h4>
			</div>
			<div class="modal-body">
				@foreach($errors->all() as $message)
				<p>{{ $message }}</p>
				@endforeach
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
@stop

@section('bodyscripts')
@parent
	<script src="{{ asset('js/Markdown.Extra.js') }}"></script>
	<script src="{{ asset('js/InsertImageDialog.js') }}"></script>
	<script src="{{ asset('js/admin/coverimagepreview.js') }}"></script>
	<script src="{{ asset('js/admin/formsubmitter.js') }}"></script>
	<script src="{{ asset('js/admin/previewscroller.js') }}"></script>
	<script type="text/javascript">
		var imageInserter = new PDImageInserter();
		var converter = new Markdown.Converter();
        Markdown.Extra.init(converter);
     	var editor = new Markdown.Editor(converter);
     	editor.hooks.set('insertImageDialog', imageInserter.setUpHook.bind(imageInserter));
     	editor.run();
	</script>
	
	<script type="text/javascript">
		coverImagePreview.attachEvents();
		formSubmitter.attachEvents();
		previewScroller.attachEvents();
	</script>
	@if( $errors->any() )
	<script type="text/javascript">
		$('#error_modal').modal();
	</script>
	@endif
@stop
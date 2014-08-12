@extends('basicbase')

@section('head')
	@parent
	<script src="  {{ asset('js/Markdown.Converter.js')}} "></script>
	<script src="  {{ asset('js/Markdown.Sanitizer.js')}} "></script>
	<script src="  {{ asset('js/Markdown.Editor.js')}} "></script>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/demo.css')}}">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<style type="text/css">
		@import url(//fonts.googleapis.com/css?family=Lato:400);

		form {
			width: 99%;
			margin: 0 auto;
		}

		.row {
			margin: 0.5em 0;
		}

		#title {
			font-size: 2em;
			height: 2.5em;
		}

		#cover_pic {
			display: none;
		}

		#cover_pic_upload_box {
			min-height: 214px;
			background: url('../../images/2.jpg') no-repeat;
			background-size: cover;
			background-position: center;
			position: relative;
			border: 1px solid #ccc;
			border-left: none;
			position: relative;
		}

		/*#cover_pic_upload_box img {
			position: absolute;
			top: 0;
			width: 100%;
			height: 100%;
			z-index: -1000;
		}*/

		#cover_pic_upload_box label {
			position: relative;
			top: 40%;
			display: inline-block;
			width: 100%;
			text-align: center;
			font-size: 2em;
			color: #FFFFFF;
			font-family: 'Lato', Ariel, sans-serif;
			line-height: 180px;
			z-index: 100;
		}

		#wmd-input {
			width: 100%;
			resize: none;
		}

		#wmd-button-row {
			width: 100%;
		}

		.image_preview {
			max-width: 250px;
			max-height: 200px;
			float: right;
		}

		.image_preview img {
			width: 100%;
			height: 100%;
		}

		#excerpt_box {
			padding-right: 0;
		}

		#excerpt_box textarea {
			border-radius: 0;
		}

		#picture_box {
			padding-left: 0;
		}

		#wmd-preview {
			position: relative;
			width: 100%;
			height: 500px;
			background-color: #FCFCFC;
			margin-top: 3em;
			padding: 1.5em;
			overflow-Y: scroll;
			overflow-X: hidden;
			padding-bottom: 3em;
		}

		#wmd-preview:before {
			content: 'Preview';
			font-size: 1.5em;
			font-weight: 700;
			position: absolute;
			top: -1.5em;
			left: 45%;
		}

		#footbar {
			position: fixed;
			bottom: 0;
			width: 100%;
			background-color: #242628;
			margin: 0;
			padding: 0.3em 0;
		}

		#main-nav {
			margin-bottom: 0;
			background-color: #2980b9;
			color: #FFFFFF;
			border: none;
			border-radius: 0;
		}

		#main-nav a, #main-nav li {
			color: #FFFFFF;
		}

		#bs-example-navbar-collapse-1 ul li.active a {
			background-color: #3498db;
		}

		#submit_btn_grp {
			width: 100%;
		}

		#cover_pic_preview {
			width: 100%;
			height: 100%;
			position: absolute;
			left: 0;
			top: 0;
			/*z-index: -1000;*/
		}

		#cover_pic_preview img {
			width: 100%;
			height: 100%;
			z-index: -500;
		}

		#imageToUpload {
			display: none;
		}

		#fileUploadLabel {
			font-size: 1.5em;
			font-weight: 400;
			color: #2980B9;
		}

		#excerpt_txt {
			resize: none;
		}

		#cover_pic_error {
			/*display: none;*/
			position: absolute;
			bottom: 0;
			right: 0;
			/*width: 0;*/
			-webkit-transition: 1s;
			opacity: 0;
			background-color: red;
			color: white;
			border-radius: 8px;
			padding: 0.5em 1em;
			margin: 1em;
		}

		#cover_pic_error.show {
			opacity: 1;
			width: auto;
		}

		#taglist, #tagaddon, #category, #submitbutton {
			border-radius: 0;
		}

		#submitbutton {
			background-color: #2980B9;
			border-color: #2980B6;
		}

		#publish_options_list {
			right: 0;
		}

		#publish_options_list li {
			padding: 0.5em 2em;
			text-align: center;
			cursor: pointer;
		}
	</style>
	@stop

@section('content')
<!-- top nav bar -->
<nav class="navbar navbar-default" role="navigation" id="main-nav">
	<div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    	<div class="navbar-header">
      		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        		<span class="sr-only">Toggle navigation</span>
        		<span class="icon-bar"></span>
        		<span class="icon-bar"></span>
        		<span class="icon-bar"></span>
      		</button>
    		<a class="navbar-brand" href="#">Mr Writer</a>
    	</div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	    	<ul class="nav navbar-nav">
	        	<li class="active"><a href="#">View Site</a></li>
	        	<li><a href="#">Content</a></li>
	        	<li><a href="#">New Post</a></li>
	    	</ul>
	    	<ul class="nav navbar-nav navbar-right">
		        <li class="dropdown">
		        	<a href="#" class="dropdown-toggle" data-toggle="dropdown">User McUserson <span class="caret"></span></a>
		        	<ul class="dropdown-menu" role="menu">
			            <li><a href="#">Action</a></li>
			            <li><a href="#">Another action</a></li>
			            <li><a href="#">Something else here</a></li>
			            <li class="divider"></li>
			            <li><a href="#">Separated link</a></li>
		        	</ul>
		        </li>
	    	</ul>
	    </div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>

<!-- form iteself -->

<form action="/postarticle" method="POST" id="articleform" enctype="multipart/form-data">
	<div class="row">
		<div class="col-sm-12">
			<input id="title" type="text" value="{{ Input::old('title') }}" name="title" placeholder="Your title" class="form-control">
		</div>
	</div>
	<!-- excerpt and cover picture -->
	<div id="post_meta_box">
		<div class="row">
			<div class="col-md-5" id="excerpt_box">
				<textarea id="excerpt_txt" rows="10" cols="50" name="excerpt" placeholder="Excerpt" class="form-control">{{ Input::old('excerpt') }}</textarea>
			</div>
			<div class="col-md-7" id="picture_box">
				<div id="cover_pic_upload_box">
					<label for="cover_pic">Click to select cover pic
						<input type="file" name="cover_pic" id="cover_pic">
					</label>
					<div id="cover_pic_preview"></div>
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
			          <textarea class="wmd-input" id="wmd-input" name="content">{{ Input::old('content') }}</textarea>
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
					<option value="{{ $category->id }}">{{ $category->category }}</option>
				@endforeach
			</select>
		</div>
		<div id="tags_container" class="col-md-8">
			<div class="input-group">
				<span class="input-group-addon" id="tagaddon"><span class="glyphicon glyphicon-tags"></span></span>
				<input type="text" id="taglist" value="{{ Input::old('tags') }}" name="tags" placeholder="tag things here" class="form-control">
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
			    	<li id="publish_save">Publish now</li>
				</ul>
			</div>
		</div>
	</div>
	<input type="hidden" value="1" name="status_id" id="statusflag">
	<input type="hidden" value="267" name="user_id">
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
	<script type="text/javascript">
		var imageInserter = new PDImageInserter();
		var converter = new Markdown.Converter();
        Markdown.Extra.init(converter);
     	var editor = new Markdown.Editor(converter);
     	editor.hooks.set('insertImageDialog', imageInserter.setUpHook.bind(imageInserter));
     	editor.run();
	</script>
	<script type="text/javascript">
		var coverImagePreview = {
			elems: {
				select: document.getElementById('cover_pic'),
				preview: document.getElementById('cover_pic_preview'),
				message: document.getElementById('cover_pic_error')
			},

			attachEvents: function() {
				this.elems.select.addEventListener('change', this.processImg.bind(this), false);
			},

			processImg: function() {
				var self = this;
				var file = this.elems.select.files[0];
				this.hideError();
				if(file.type.indexOf('image') === 0) {
					var reader = new FileReader();
					var img = new Image();
					reader.onload = function(ev) {
						img.src = ev.target.result;
						self.elems.preview.innerHTML = '';
						self.elems.preview.appendChild(img);
						self.elems.preview.parentNode.style.backgroundImage = "none";
						console.log('done'); 
					}
					reader.readAsDataURL(file);
				} else {
					this.showError('That file is not supported. Please use png, gif or jpg.');
					setTimeout(coverImagePreview.hideError.bind(this), 3000);
					self.elems.preview.parentNode.style.backgroundImage = "none";
					self.elems.preview.parentNode.style.backgroundColor = "#2980B9";
					this.elems.preview.innerHTML = '';
					this.elems.select.value = '';
				}
			},

			showError: function(message) {
				this.elems.message.innerHTML = message;
				this.elems.message.classList.add('show');
			},

			hideError: function() {
				//this.elems.message.innerHTML = '';
				this.elems.message.classList.remove('show');
			}
		}
		coverImagePreview.attachEvents();
	</script>
	<script type="text/javascript">
		var formSubmitter = {
			elems: {
				form: document.getElementById('articleform'),
				draft: document.getElementById('draft_save'),
				publish: document.getElementById('publish_save'),
				statusflag: document.getElementById('statusflag')
			},

			attachEvents: function() {
				this.elems.draft.addEventListener('click', this.saveAsDraft.bind(this), false);
				this.elems.publish.addEventListener('click', this.saveAsPublished.bind(this), false);
			},

			saveAsDraft: function() {
				this.elems.statusflag.value = "2";
				this.elems.form.submit();
			},

			saveAsPublished: function() {
				this.elems.statusflag.value = "1";
				this.elems.form.submit();	
			}
		}
		formSubmitter.attachEvents();
	</script>
	<script type="text/javascript">
		var inp = document.getElementById('wmd-input');
		var prev = document.getElementById('wmd-preview');
		inp.addEventListener('keyup', function() {
			prev.scrollTop = prev.scrollHeight;
		}, false);
	</script>
	@if( $errors->any() )
	<script type="text/javascript">
		$('#error_modal').modal();
	</script>
	@endif
@stop
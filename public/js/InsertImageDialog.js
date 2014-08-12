;(function(w, $) {
	var d = w.document;

	function ErrorMessage(message) {
		this.message = message || 'An error has occured';
		this.container = d.getElementById('uploadErrors');
	}

	ErrorMessage.prototype = {
		render: function() {
			this.container.innerHTML = '';
			var span = d.createElement('span');
			span.setAttribute('class', 'upload-error-message');
			span.innerHTML = this.message;
			this.container.appendChild(span);
		}
	}

	function PDImageInserter(options) {
		this.$modal = $('#insertImageModal');
		this.elems = {
			preview: d.querySelector('.image_preview'),
			hide: d.querySelectorAll('.picmodalHide'),
			insert: d.querySelector('#insertBtn'),
			fileSelect: d.querySelector('#imageToUpload'),
			errorBox: d.querySelector('#uploadErrors')
		};
		this.url = '/admin/contentimageupload';
		this.imageURL = null;
		this.setListeners();
	}

	PDImageInserter.prototype = {
		setListeners: function() {
			var self = this;
			var i = 0, l = this.elems.hide.length;
			for(i;i<l;i++) {
				this.elems.hide[i].addEventListener('click', self.cancelDialog.bind(this), false);
			}
			this.elems.insert.addEventListener('click', self.insertImage.bind(this), false);
			this.elems.fileSelect.addEventListener('change', self.processImage.bind(this), false);
		},

		cancelDialog: function() {
			this.callback(null);
			this.closeDialog();
		},

		insertImage: function() {
			if(!this.imageURL || this.imageURL.length < 5 ) {
				return;
			}
			this.callback(this.imageURL);
			this.closeDialog();
		},

		processImage: function() {
			var self = this;
			var img, reader;
			var file = this.elems.fileSelect.files[0];
			this.elems.errorBox.innerHTML = '';
			if(file.size > 5242880) {
				//handle error
				return;
			}
			if(file.type.indexOf('image') === 0) {
				img = new Image();
				reader = new FileReader();
				reader.onload = function(ev) {
					img.src = ev.target.result;
					self.elems.preview.innerHTML = "";
					self.elems.preview.appendChild(img);
				}
				reader.readAsDataURL(file);
				this.uploadImage(file);
			} else {
				var error = new ErrorMessage('That file type is not supported. Please use png, jpg or gif');
				error.render();
				return;
			}
		},

		uploadImage: function(file) {
			var self = this;
			var fd = new w.FormData();
			fd.append('image', file);
			var req = new w.XMLHttpRequest();
			req.open('POST', this.url, true);
			req.onload = function(ev) {
				if(req.status === 200) {
					console.log('Success: ' + ev.target.response);
					self.imageURL = ev.target.response;
					self.elems.insert.innerHTML = "Insert";
					self.elems.insert.disabled = false;
				} else {
					console.log('Failed: ' + ev.target.response);
					var error = new ErrorMessage(ev.target.response);
					error.render();
					self.elems.insert.innerHTML = "Error";
				}
			};
			req.onerror = function(ev) {
				console.log('ajax error');
				var error = new ErrorMessage('Sorry. The upload was not successful.');
				error.render();
			};
			req.send(fd);
			this.elems.insert.innerHTML = "uploading...";
		},

		setUpHook: function(callback) {
			console.log(this);
			this.callback = callback;
			this.$modal.modal('show');
			return true;
		},

		closeDialog: function() {
			this.elems.errorBox.innerHTML = '';
			this.elems.preview.innerHTML = '';
			this.elems.insert.disabled = true;
			this.elems.fileSelect.value = '';
			this.$modal.modal('hide');
		}
	};

	w.PDImageInserter = PDImageInserter;
}(window, jQuery));
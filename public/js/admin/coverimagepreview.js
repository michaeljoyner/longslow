;(function(w){
	var d = w.document;
	var coverImagePreview = {
		elems: {
			select: d.getElementById('cover_pic'),
			preview: d.getElementById('cover_pic_preview'),
			message: d.getElementById('cover_pic_error')
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
	w.coverImagePreview = coverImagePreview;
}(window));
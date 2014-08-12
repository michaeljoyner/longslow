;(function(w){
	var d = w.document;
	var previewScroller = {
		elems: {
			input: d.getElementById('wmd-input'),
			preview: d.getElementById('wmd-preview')
		},

		attachEvents: function() {
			this.elems.input.addEventListener('keyup', this.scrollPreview.bind(this), false);
		},

		scrollPreview: function(ev) {
			this.elems.preview.scrollTop = this.elems.preview.scrollHeight;
		}
	}

	w.previewScroller = previewScroller;
}(window));
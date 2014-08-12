;(function(w){
	var d = w.document;
	var formSubmitter = {
		elems: {
			form: d.getElementById('articleform'),
			draft: d.getElementById('draft_save'),
			publish: d.getElementById('publish_save'),
			silentPublish: d.getElementById('publish_silent'),
			statusflag: d.getElementById('statusflag')
		},

		attachEvents: function() {
			this.elems.draft.addEventListener('click', this.saveAsDraft.bind(this), false);
			this.elems.publish.addEventListener('click', this.saveAsPublished.bind(this), false);
			if(this.elems.silentPublish) {
				this.elems.silentPublish.addEventListener('click', this.saveSilently.bind(this), false);
			}
		},

		saveAsDraft: function() {
			this.elems.statusflag.value = "2";
			this.elems.form.submit();
		},

		saveAsPublished: function() {
			this.elems.statusflag.value = "1";
			this.elems.form.submit();	
		},

		saveSilently: function() {
			this.elems.statusflag.value = "3";
			this.elems.form.submit();
		}
	}
	w.formSubmitter = formSubmitter;
}(window));
;(function(w, $){
	var d = w.document;
	var formSubmitter = {
        errors: [],

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
			this.checkAndSubmit();
		},

		saveAsPublished: function() {
			this.elems.statusflag.value = "1";
			this.checkAndSubmit();
		},

		saveSilently: function() {
			this.elems.statusflag.value = "3";
			this.checkAndSubmit();
		},

        checkAndSubmit: function() {
          if(this.validate()) {
              this.elems.form.submit();
          } else {
              this.showAllErrors();
          }
        },

        validate: function() {
            this.errors = [];
            var title = d.querySelector('#title');
            var excerpt = d.querySelector('#excerpt_txt');
            var body = d.querySelector('#wmd-input');
            var category = d.querySelector('#category');

            if(title.value.length === 0) {
                this.errors.push('You need to give the post a tile.');
            }
            if(excerpt.value.length === 0) {
                this.errors.push('Please write a short excerpt for your post');
            }
            if(body.value.length === 0) {
                this.errors.push('You haven\'t added any content to the body of your post');
            }
            if(category.value == 0) {
                this.errors.push('Please select a category for this post.')
            }

            return (this.errors.length === 0);

        },

        showAllErrors: function() {
            var i = 0, l = this.errors.length;
            var modalcontent = d.querySelector('#error_modal .modal-body');
            modalcontent.innerHTML = '<ul>';
            for(i;i<l;i++) {
                modalcontent.innerHTML += '<li>'+ this.errors[i] + '</li>';
            }
            modalcontent.innerHTML += '</ul>';
            $('#error_modal').modal('show')
        }
	}
	w.formSubmitter = formSubmitter;
}(window, jQuery));
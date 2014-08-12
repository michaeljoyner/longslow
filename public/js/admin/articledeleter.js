;(function(w, $){

	var d = w.document;
	var url = '/admin/article/';
	var articleId = null;

	var ErrorMessage = function(message) {
		this.message = message;
	}

	ErrorMessage.prototype = {
		render: function(view) {
			var cont = d.createElement('div');
			cont.setAttribute('class', 'clearfix');
			var p = d.createElement('p');
			p.setAttribute('class', 'error_message');
			p.innerHTML = 'Error: ' + this.message;
			cont.appendChild(p);
			view.insertBefore(cont, view.firstChild);
		}
	}

	var articleDeleter = {
		elems: {
			modal: document.getElementById('deleteModal'),
			modalOK: document.getElementById('okDelete'),
			modalCancel: document.getElementById('okCancel'),
			modalClose: document.getElementById('okClose')
		},

		init: function(ev) {
			
		},

		addEvents: function() {
			articleDeleter.elems.modalOK.addEventListener('click', articleDeleter.deleteArticle, false);
			articleDeleter.elems.modalCancel.addEventListener('click', articleDeleter.closeModal, false);
			articleDeleter.elems.modalClose.addEventListener('click', articleDeleter.closeModal, false);
		},

		removeEvents: function() {
			articleDeleter.elems.modalOK.removeEventListener('click', articleDeleter.deleteArticle, false);
			articleDeleter.elems.modalCancel.removeEventListener('click', articleDeleter.closeModal, false);
			articleDeleter.elems.modalClose.removeEventListener('click', articleDeleter.closeModal, false);	
		},

		closeModal: function() {
			articleId = null;
			articleDeleter.removeEvents();
			$(articleDeleter.elems.modal).modal('hide');
		},

		deleteArticle: function(ev) {
			var view = d.getElementById('article_card'+articleId);
			var req = new XMLHttpRequest();
			var fd = new FormData();
			fd.append('_method', 'DELETE');
			req.open('POST', '/admin/article/'+ articleId, true);
			req.onload = function(ev) {
				if(ev.target.status === 200) {
					articleDeleter.removeView(view);
				} else {
					articleDeleter.showError(view, ev.target)
				}
			}
			req.send(fd);
			articleDeleter.closeModal();
		},

		removeView: function(view) {
			console.log('removing view' + view);
			$(view).animate({'left': 900}, function() {
				this.remove();
			});
		},

		showError: function(view, target) {
			console.log(target.response);
			var er = new ErrorMessage(target.response);
			er.render(view);
		}
	}

	var articleDeleteHelper = {
		init: function(ev) {
			articleId = ev.target.getAttribute('data-id');
			articleDeleter.addEvents();
			$(articleDeleter.elems.modal).modal('show');
		}
	}

	w.articleDeleteHelper = articleDeleteHelper;
}(window, jQuery));
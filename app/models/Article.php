<?php
	class Article extends Eloquent {
		/**
		 * Database table name
		 * @var string
		 */
		protected $table = 'articles';

		/**
		 * Mass assignable attributes
		 * @var array
		 */
		protected $fillable = array(
			'user_id',
			'status_id',
			'category_id',
			'title',
			'slug',
			'excerpt',
			'content',
			'cover_id'
		);

		protected $softDelete = true;

		/**
		 * one to one relationship with author
		 * @return \Illuminate\Database\Eloquent\Relationships\HasOne
		 */
		public function author() {
			return $this->belongsTo('User', 'user_id')->withTrashed();
		}

		/**
		 * one to one relationship with Status
		 * @return \Illuminate\Database\Eloquent\Relationships\HasOne
		 */
		public function status() {
			return $this->belongsTo('Status');
		}

		/**
		 * one to one relationship with Category
		 * @return \Illuminate\Database\Eloquent\Relationships\HasOne
		 */
		public function category() {
			return $this->belongsTo('Category');
		}

		public function cover()
		{
			return $this->belongsTo('Cover');
		}

		/**
		 * many to many relationship with Tag
		 * @return \Illuminate\Database\Eloquent\Relationships\BelongsToMany
		 */
		public function tags() {
			return $this->belongsToMany('Tag', 'articles_tags', 'article_id', 'tag_id')->withTimestamps();
		}

		public function userCanModify($user)
		{
			if($user->role_id < 3 || $this->user_id === $user->id)
			{
				return true;
			}
			return false;
		}
	}
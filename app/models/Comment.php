<?php

class Comment extends \Eloquent {
	protected $fillable = ['text', 'recipe_id'];

	protected function recipe() {
		return $this->belongsTo('Recipe');
	}
}
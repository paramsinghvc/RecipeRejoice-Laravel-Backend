<?php

class Recipe extends \Eloquent {
	protected $fillable = ['title', 'description', 'vote', 'photo', 'ingredients', 'username'];

	protected function comments() {
		return $this->hasMany('Comment');
	}
}
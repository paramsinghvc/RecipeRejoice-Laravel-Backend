<?php

class CommentsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /comments
	 *
	 * @return Response
	 */
	public function index() {
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /comments/create
	 *
	 * @return Response
	 */
	public function create() {

	}

	/**
	 * Store a newly created resource in storage.
	 * POST /comments
	 *
	 * @return Response
	 */
	public function store() {
		$comment = Comment::create([
			'recipe_id' => Input::get('recipe_id'),
			'text' => Input::get('text'),
		]);
		return Response::json(['status' => '200', 'comment' => $comment, 'msg' => 'Saved Successfully']);
	}

	/**
	 * Display the specified resource.
	 * GET /comments/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /comments/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id) {

	}

	/**
	 * Update the specified resource in storage.
	 * PUT /comments/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id) {
		$comment = Comment::find($id);
		if (!$comment) {
			return Response::json(['msg' => 'Invalid Comment ID']);
		}

		$comment->text = Input::get('text');

		return Response::json(['msg' => 'Data Saved Successfully', 'comment' => $comment], 200);
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /comments/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id) {
		$comment = Comment::find($id);
		if (!$comment) {
			return Response::json(['msg' => 'Invalid Comment ID']);
		}

		$comment->delete();
		return Response::json(['msg' => 'Comment Deleted Successfully']);
	}

}
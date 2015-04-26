<?php

class RecipesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /recipes
	 *
	 * @return Response
	 */
	public function index() {
		$recipes = Recipe::all();
		foreach ($recipes as $recipe) {
			$recipe->comments;
		}
		return $recipes;
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /recipes/create
	 *
	 * @return Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /recipes
	 *
	 * @return Response
	 */
	public function store() {
		$rules = [

			'title' => 'required',
			'vote' => 'integer',
			// 'photo' => 'mimes:jpeg,bmp,png',

		];

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Response::json(['msg' => 'validation errors', 'errors' => $validator->messages()]);
		}

		$recipe = Recipe::create([

			'title' => Input::get('title'),
			'description' => Input::get('description'),
			'ingredients' => Input::get('ingredients'),
			'vote' => Input::get('vote'),
			'username' => Input::get('username'),

		]);

		if ($photo = Input::file('photo')) {

			$result = $this->uploadRecipePhoto($photo, $recipe);
			if (isset($result['errors'])) {
				return Response::json(['errors' => $result['errors']]);

			}
		}

		$recipe->comments;
		return Response::json(['recipe' => $recipe, 'msg' => 'Saved Successfully', 'status' => 200], 200);
	}

	public function uploadRecipePhoto($picture, $recipe) {

		$result = $this->imageUpload($picture, 'recipes');

		if (isset($result['errors'])) {
			return $result;
		}

		// Database Entry

		$recipe->photo = $result['pictureName'];
		$recipe->save();

		return ['img' => Config::get('configs.uploadPath') . '/thumbs/recipes/' . $result['pictureName']];
	}

	/*  Upload Recipe Photo
	POST recipe/img/{id}	 */

	public function uploadPhoto($id) {

		$recipe = Recipe::find($id);

		if (!$recipe) {
			return Response::json(['msg' => 'Invalid Recipe ID']);
		}
		if (Input::hasFile('photo')) {
			$picture = Input::file('photo');

			$result = $this->uploadRecipePhoto($picture, $recipe);

			return Response::json($result);

		}
		return Response::json(['msg' => 'Please Upload a file']);
	}

	/* 	Delete Recipe Photo
	DELETE recipe/img/{name}	*/

	public function deletePhoto($name) {

		$recipe = Recipe::where('photo', $name)->first();
		if (!$recipe) {
			return Response::json(['msg' => 'Invalid Recipe ID']);
		}

		$recipe->photo = '';
		$recipe->save();

		$result = $this->deleteImage($name, 'recipes');
		if ($result) {
			return $result;
		}

		return Response::json(['msg' => 'Photo Deleted Successfully']);
	}

	/**
	 * Display the specified resource.
	 * GET /recipes/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id) {
		$recipe = Recipe::find($id);

		if (!$recipe) {
			return Response::json(['msg' => 'Invalid Recipe ID']);
		}
		$recipe->comments;
		return Response::json(['recipe' => $recipe], 200);
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /recipes/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /recipes/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id) {
		$recipe = Recipe::find($id);
		if (!$recipe) {
			return Response::json(['msg' => 'Invalid Recipe ID']);
		}

		$recipe->title = Input::get('title');
		$recipe->description = Input::get('description');
		$recipe->ingredients = Input::get('ingredients');
		$recipe->vote = Input::get('vote');
		$recipe->username = Input::get('username');

		$recipe->save();

		return Response::json(['msg' => 'Data Saved Successfully', 'recipe' => $recipe], 200);
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /recipes/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id) {
		$recipe = Recipe::find($id);
		if (!$recipe) {
			return Response::json(['msg' => 'Invalid Recipe ID']);
		}

		$this->deletePhoto($recipe->photo);
		$recipe->delete();
		return Response::json(['msg' => 'Recipe Deleted Successfully']);
	}

}
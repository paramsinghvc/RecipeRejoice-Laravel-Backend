<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */

	public function deleteImage($imageName, $folderName) {

		$iUpload = File::delete(Config::get('configs.uploadPath') . '/' . $folderName . '/' . $imageName);
		$tUpload = File::delete(Config::get('configs.uploadPath') . '/thumbs/' . $folderName . '/' . $imageName);

		if (!$iUpload || !$tUpload) {
			return Response::json(['errors' => 'Error deleting images']);
		}

	}

	public function imageUpload($picture, $entityName) {

		$rules = [

			'picture' => 'max:10000|image',

		];

		$validator = Validator::make(['picture' => $picture], $rules);

		if ($validator->fails()) {
			return ['msg' => 'validation errors', 'errors' => $validator->messages()];
		}

		$pictureName = 'RR' . Input::get('name') . str_random(8) . '.' . $picture->getClientOriginalExtension();

		// try{

		// Thumbnail Image saving in /thumbs/recipes or recipes

		$thumbImg = Image::make($picture);
		$thumbImg->resize(100, 100);
		$thumb = $thumbImg->save(Config::get('configs.uploadPath') . '/thumbs/' . $entityName . '/' . $pictureName);

		// Upload of the real sized image

		$picture->move(Config::get('configs.uploadPath') . '/' . $entityName, $pictureName);

		// }
		// catch( Exception $e ) {

		// 	return ['errors' => 'Problem uploading the image'] ;

		// }

		return ['pictureName' => $pictureName];

	}

	protected function setupLayout() {
		if (!is_null($this->layout)) {
			$this->layout = View::make($this->layout);
		}
	}

}

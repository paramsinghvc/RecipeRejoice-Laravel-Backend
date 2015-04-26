<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecipesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('recipes', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->text('description')->nullable();
			$table->text('ingredients')->nullable();
			$table->string('username')->nullable();
			$table->integer('vote')->nullable();
			$table->string('photo')->nullable();

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('recipes');
	}

}

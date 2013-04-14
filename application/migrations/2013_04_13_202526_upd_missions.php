<?php

class Upd_Missions {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('missionseintraege', function($table) {
			$table->integer('anwesenheit');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('missionseintraege', function($table) {
			$table->drop_column('anwesenheit');
		});
	}

}
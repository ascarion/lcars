<?php

class Upd_Rank {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('raenge', function($table) {
			$table->integer('nachfolger');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('raenge', function($table) {
			$table->drop_column('nachfolger');
		});
	}

}
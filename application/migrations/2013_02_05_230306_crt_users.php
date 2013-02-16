<?php

class Crt_Users {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('spieler', function($table) {
			$table->increments('id');
			$table->string('name', 255);
			$table->string('password', 64);
			$table->string('email', 255);
			$table->boolean('aktiv');
			$table->integer('rollen_id')->nullable();
			$table->timestamps();
		});

		Schema::create('charaktere', function($table) {
			$table->increments('id');
			$table->string('name', 255);
			$table->integer('raenge_id');
			$table->integer('spieler_id');
			$table->integer('positionen_id');
			$table->integer('missionspins');
			$table->integer('leiterpins');
			$table->integer('gastpins');
			$table->boolean('aktiv');
			$table->boolean('hauptcharakter');
			$table->timestamps();
		});

		Schema::create('komponenten', function($table) {
			$table->increments('id');
			$table->string('name', 255);
			$table->string('typ', 255);
			$table->boolean('aktiv');
			$table->timestamps();
		});

		Schema::create('raenge', function($table) {
			$table->increments('id');
			$table->string('name', 255);
			$table->integer('missionspins');
			$table->integer('leiterpins');
			$table->integer('gastpins');
		});

		Schema::create('positionen', function($table) {
			$table->increments('id');
			$table->string('name', 255);
			$table->integer('komponenten_id');
			$table->boolean('admin');
		});

		Schema::create('notizen', function($table) {
			$table->increments('id');
			$table->text('text');
			$table->integer('charaktere_id');
			$table->integer('eintragende_id');
			$table->integer('aendernde_id');
			$table->integer('missionspins');
			$table->integer('leiterpins');
			$table->integer('gastpins');
			$table->timestamps();
		});

		Schema::create('missionen', function($table) {
			$table->increments('id');
			$table->integer('komponenten_id');
			$table->integer('eintragende_id');
			$table->integer('aendernde_id');
			$table->timestamps();
		});

		Schema::create('missionseintraege', function($table) {
			$table->increments('id');
			$table->integer('missionen_id');
			$table->integer('charaktere_id');
			$table->integer('missionspins');
			$table->integer('leiterpins');
			$table->integer('gastpins');
		});

		Schema::create('rollen', function($table) {
			$table->increments('id');
			$table->string('name',255);
			$table->string('rechte', 255);
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('spieler');
		Schema::drop('charaktere');
		Schema::drop('komponenten');
		Schema::drop('raenge');
		Schema::drop('positionen');
		Schema::drop('notizen');
		Schema::drop('missionen');
		Schema::drop('missionseintraege');
		Schema::drop('rollen');
	}
}
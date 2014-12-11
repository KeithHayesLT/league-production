<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentItemTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payment_item', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('description');
			$table->integer('quantity');
			$table->double('price',15, 2);
			$table->double('fee',15, 2);
			$table->double('discount',15, 2);
			$table->string('payment_id', 36)->index();
			$table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
			$table->integer('event_id')->unsigned()->index()->nullable();
			$table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('payment_item');
	}

}

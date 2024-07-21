<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarefasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tarefas', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('user_id')->comment('Usuario responsavel pela atividade');
			$table->unsignedBigInteger('project_id')->nullable();
			$table->unsignedBigInteger('sector_id')->nullable();
			$table->string('title')->comment('Nome da atividade');
			$table->text('description')->comment('Descrição da atividade');
			$table->integer('days')->nullable()->comment('Prazo para entrega');
			$table->decimal('percentage', 5, 2)->nullable()->comment('Percentual realizado');
			$table->boolean('is_completed')->default(false)->comment('informa conclusao da atividade');
			$table->timestamp('opened_at')->nullable();
			$table->timestamp('completed_at')->nullable();
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
			$table->foreign('project_id')->references('id')->on('projetos')->onDelete('set null');
			$table->foreign('sector_id')->references('id')->on('setors')->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('tarefas');
	}
}

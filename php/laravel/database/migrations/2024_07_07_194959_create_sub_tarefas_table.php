<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubTarefasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subtarefas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id')->comment('Tarefa pai'); // Foreign key to tasks table
            $table->string('title')->comment('Nome da sub-tarefa');
            $table->text('description')->nullable()->comment('Descrição da sub-tarefa');
            $table->boolean('is_completed')->default(false);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('task_id')->references('id')->on('tarefas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subtarefas');
    }
}

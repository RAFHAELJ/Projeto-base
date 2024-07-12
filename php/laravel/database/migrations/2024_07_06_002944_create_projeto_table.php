<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjetoTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projetos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sector');
            $table->text('description')->nullable();
            $table->timestamp('opened_at')->nullable()->comment('Data de abertura do projeto');
            $table->timestamp('completed_at')->nullable()->comment('Data de conclusão do projeto');
            $table->timestamp('deadline until')->nullable()->comment('Prazo de conclusão');
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
        Schema::dropIfExists('projetos');
    }
}

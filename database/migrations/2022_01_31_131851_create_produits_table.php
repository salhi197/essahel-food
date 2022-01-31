<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom');
            $table->string('reference');
            $table->text('description');
            $table->double('prix_gros', 8, 2);
            $table->double('prix_semi_gros', 8, 2);
            $table->double('prix_detail', 8, 2);
            $table->double('prix_minimum', 8, 2);
            $table->double('prix_autre', 8, 2);
            $table->unsignedBigInteger('id_categorie');
            $table->foreign('id_categorie')->references('id')->on('categories');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produits');
    }
}

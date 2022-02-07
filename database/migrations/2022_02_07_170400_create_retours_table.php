<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retours', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('id_ticket');
            $table->unsignedBigInteger('id_livreur');
            $table->unsignedBigInteger('id_client');
            $table->string('statut_livraison')->default('retour');;
            $table->double('prix_vente',8,2);
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
        Schema::dropIfExists('retours');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->unsignedBigInteger('id_produit');
            $table->unsignedBigInteger('num_ticket_produit');
            $table->string('satut')->default('0');
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
        Schema::dropIfExists('tickets');
    }
}

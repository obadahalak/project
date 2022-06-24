<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('party_places', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->constrained('providers');
            $table->text('name');
            $table->double('rating')->default('1.00');
            $table->string('location');
            $table->longText('details');
            $table->string('image');
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('party_places');
    }
};

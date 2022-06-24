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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('party_places_id')->constrained('party_places');
            $table->integer('number_pepole');
            $table->string('party_type');
            $table->string('kato_size');
            $table->string('photo');
            $table->string('dinner');/// وجبة العشاء
            $table->integer('chairs');/// كراسي
            $table->integer('tables');/// طاولات
            $table->integer('invitation_cards');/// كروت الدعوة
            $table->date('date');
            $table->string('phone_number');
            $table->string('name');
            $table->string('price')->nullable(); /// provider only  set price
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('orders');
    }
};

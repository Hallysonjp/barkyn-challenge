<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePets extends Migration{

    public function up(){
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender');
            $table->enum('lifestage', ['puppy', 'adult', 'senior']);
            $table->float('weight', 3, 2);
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('pets');
    }
}

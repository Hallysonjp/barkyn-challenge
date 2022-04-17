<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class CreateCustomers extends Migration{

    public function up(){
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->date('birth_date');
            $table->string('gender');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('customers');
    }
}

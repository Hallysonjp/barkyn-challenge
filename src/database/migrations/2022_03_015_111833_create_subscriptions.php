<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptions extends Migration{

    public function up(){
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->decimal('base_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->timestamp('next_order_date');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('subscriptions');
    }
}

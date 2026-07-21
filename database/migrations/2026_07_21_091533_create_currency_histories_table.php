<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('currency_histories', function (Blueprint $table) {
            $table->id();
            $table->string('currency_code', 10);
            $table->decimal('exchange_rate', 15, 4);
            $table->date('recorded_date');
            $table->timestamps();

            $table->unique(['currency_code', 'recorded_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('currency_histories');
    }
};
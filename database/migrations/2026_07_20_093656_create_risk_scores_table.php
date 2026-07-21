<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('risk_scores', function (Blueprint $table) {

            $table->id();

            $table->string('country');

            $table->integer('weather_score');

            $table->integer('inflation_score');

            $table->integer('news_score');

            $table->integer('currency_score');

            $table->decimal('total_score',5,2);

            $table->string('risk_level');

            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('risk_scores');
    }
};
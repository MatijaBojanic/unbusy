<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bus_line_bus_stop', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_line_id')->constrained();
            $table->foreignId('bus_stop_id')->constrained();
            $table->integer('order');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bus_line_bus_stop');
    }
};

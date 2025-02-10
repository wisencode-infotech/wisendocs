<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('block_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('block_type'); // e.g., 'title', 'subtitle'
            $table->json('attributes'); // JSON field to store attributes dynamically
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('block_attributes');
    }
};


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
        Schema::create('phps', function (Blueprint $table) {
            $table->id();
            $table->string('version');
            $table->string('path');
            $table->boolean('default')->default(false);
            $table->string('cmd_php');
            $table->string('cmd_composer');
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
        Schema::dropIfExists('php_versions');
    }
};

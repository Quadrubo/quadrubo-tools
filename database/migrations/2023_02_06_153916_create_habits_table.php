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
        Schema::create('habits', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('question')->nullable();
            $table->text('notes')->nullable();
            $table->string('color')->default('#0000ff');

            // Frequency
            $table->integer('times')->default(1);
            $table->integer('multiplier')->default(1);
            $table->enum('unit', ['day', 'week', 'month', 'year'])->default('day');
            $table->string('frequency_sentence');

            $table->enum('visibility', ['private', 'invite', 'public'])->default('private');

            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();

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
        Schema::dropIfExists('habits');
    }
};

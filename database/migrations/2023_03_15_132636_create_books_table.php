<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('file_path');
            $table->string('image');
            $table->longText('description')->nullable();
            $table->boolean('accepted')->default(0);
            $table->string('book_audio')->nullable();
            $table->string('edition')->nullable();
            $table->foreignId('category_id')->constrained('categories')->CascadeOnDelete();
            $table->foreignId('Publisher_id')->constrained('publishers')->CascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};

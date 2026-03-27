<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('code', 50)->unique();
            $table->decimal('value', 8, 2);
            $table->enum('type', ['percent', 'fixed'])->default('percent');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->tinyInteger('status')->default(1)->comment('0 - inactive, 1 - active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};

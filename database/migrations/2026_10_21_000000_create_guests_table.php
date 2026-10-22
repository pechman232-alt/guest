<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 150);
            $table->string('phone', 40)->nullable();
            $table->string('guest_side', 20)->default('both'); // bride, groom, both
            $table->string('table_number', 30)->nullable();
            $table->unsignedSmallInteger('guest_count')->default(1);
            $table->string('rsvp_status', 20)->default('pending'); // pending, confirmed, declined
            $table->timestamp('checked_in_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('full_name');
            $table->index('checked_in_at');
            $table->index(['guest_side', 'rsvp_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};

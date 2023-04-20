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
        Schema::create('friends', function (Blueprint $table) {
            $table->foreignId('fk_user_send_request')->constrained('users');
            $table->foreignId('fk_user_receive_request')->constrained('users');
            $table->primary(['fk_user_send_request', 'fk_user_receive_request']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friends');
    }
};

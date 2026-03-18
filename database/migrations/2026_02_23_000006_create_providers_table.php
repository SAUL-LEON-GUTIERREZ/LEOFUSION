<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('providers', function (Blueprint $table): void {
            $table->id();
            $table->string('company_name');
            $table->string('contact_name');
            $table->string('phone');
            $table->string('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};

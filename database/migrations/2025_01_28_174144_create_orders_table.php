<?php

use App\Models\Tariff;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('client_phone', 11)->unique();
            $table->foreignIdFor(Tariff::class);
            $table->enum('schedule_type', [
                "EVERY_DAY",
                "EVERY_OTHER_DAY",
                "EVERY_OTHER_DAY_TWICE"
            ]);
            $table->string('comment');
            $table->timestamp('created_at');
            $table->timestamp('first_date');
            $table->timestamp('last_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

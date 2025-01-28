<?php

use App\Models\Order;
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
        Schema::create('ration', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class);
            $table->timestamp('cooking_date');
            $table->boolean('cooking_day_before');
            $table->timestamp('delivery_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ration');
    }
};

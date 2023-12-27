<?php

use App\Models\City;
use App\Models\orderCategory;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('policy_number');
            $table->string('receiver_name');
            $table->foreignIdFor(orderCategory::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('phone_number');
            $table->foreignIdFor(City::class)->constrained()->cascadeOnDelete()->cascadeOnDelete();
            $table->string('address');
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
        Schema::dropIfExists('orders');
    }
};

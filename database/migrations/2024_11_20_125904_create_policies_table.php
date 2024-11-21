<?php

use App\PolicyType;
use App\Status;
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
        Schema::create('policies', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('policy_number')->unique();
            $table->string('customer_name');
            $table->enum('policy_type', array_column(PolicyType::cases(), 'value'))->default(PolicyType::Health->value);
            $table->enum('status', array_column(Status::cases(), 'value'))->default(Status::Pending->value);
            $table->decimal('premium_amount');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policies');
    }
};

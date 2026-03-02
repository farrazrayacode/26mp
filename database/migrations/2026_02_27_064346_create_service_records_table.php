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
        Schema::create('service_records', function (Blueprint $table) {
            $table->id();
            $table->string('gate_pass_no')->constrained();
            $table->foreignId('vehicle_id')->constrained();
            $table->foreignId('customer_id')->constrained();
            $table->string('mechanic')->nullable();
            $table->text('complaint')->nullable();
            $table->integer('km_in')->nullable();
            $table->integer('km_out')->nullable();
            $table->dateTime('gate_in_at');
            $table->dateTime('gate_out_at')->nullable();
            $table->string('wo_nuber')->nullable();
            $table->enum('status', [
                'Pengecekan Awal',
                'Menunggu WO',
                'Menunggu Estimasi',
                'Proses Servis',
                'Lunas',
                'Batal Servis',
                'Closed',
            ])->default('Pengecekan Awal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_records');
    }
};

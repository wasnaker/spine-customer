<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel customers — entity utama modul Customer.
 *
 * Tidak ada kolom 'status' karena Customer bukan alur-kerja — lifecycle
 * pakai is_active. parent_vat_number menyimpan NPWP HO (nullable: bisa
 * kosong untuk customer tanpa HO, atau sama dengan NPWP cabang tertentu).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ulid', 26)->nullable()->unique();
            $table->string('code', 64)->unique();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone', 32)->nullable();
            $table->string('parent_vat_number', 32)->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

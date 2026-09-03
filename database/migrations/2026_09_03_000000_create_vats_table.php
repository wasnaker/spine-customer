<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel vats — NPWP/nomor pajak yang bisa di-attach ke banyak record
 * lintas module (Customer, Branch, Surveyor, dst.) via polymorphic.
 *
 * 1 NPWP = 1 baris, di-share lewat morph. 'npwp' unique sehingga
 * pendataan pajak perusahaan tidak duplikat.
 *
 * Modul lain tinggal deklarasi `morphMany(Vat::class, 'vattable')` di
 * modelnya; tidak ada cross-module dependency.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ulid', 26)->nullable()->unique();
            $table->string('npwp', 32)->unique();          // NPWP / nomor pajak — unique across DB
            $table->string('name')->nullable();            // label tampilan (opsional)
            $table->string('vattable_type', 64);          // morph: model polimorfik
            $table->unsignedBigInteger('vattable_id');     // morph: id record

            $table->timestamps();

            $table->index(['vattable_type', 'vattable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vats');
    }
};

<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Koreksi: relasi customer-pengawas sebenarnya one-to-many (1 customer
        // bisa punya BANYAK pengawas — perusahaan besar). Kolom pengawas_id
        // (added 2026_09_05_000011) TIDAK cukup; ganti dengan pivot table.
        if (Schema::hasColumn('customers', 'pengawas_id')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->dropForeign(['pengawas_id']);
                $table->dropColumn('pengawas_id');
            });
        }

        if (! Schema::hasTable('customer_pengawas')) {
            Schema::create('customer_pengawas', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('customer_id');
                $table->unsignedBigInteger('pengawas_id');
                $table->timestamps();

                $table->unique(['customer_id', 'pengawas_id']);
                $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
                $table->foreign('pengawas_id')->references('id')->on('users')->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_pengawas');

        if (! Schema::hasColumn('customers', 'pengawas_id')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->unsignedBigInteger('pengawas_id')->nullable()->after('admin_id');
                $table->foreign('pengawas_id')->references('id')->on('users')->nullOnDelete();
            });
        }
    }
};
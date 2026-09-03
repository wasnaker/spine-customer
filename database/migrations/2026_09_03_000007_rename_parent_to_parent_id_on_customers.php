<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Rename kolom `parent` -> `parent_id` (customers).
 * Konvensi: kolom FK relasi selalu suffix _id; nama kolom tidak boleh
 * sama dengan nama method relasi (parent()) — attribute menimpa relasi
 * saat serialisasi, jadi ->with('parent') tak pernah muncul.
 *
 * Constraint ikut di-drop lalu dibuat ulang dengan nama baru:
 *   - FK       customers_parent_foreign       -> customers_parent_id_foreign
 *   - UNIQUE   customers_parent_code_unique   -> customers_parent_id_code_unique
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('customers', 'parent') || Schema::hasColumn('customers', 'parent_id')) {
            return;
        }

        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign('customers_parent_foreign');
            $table->dropUnique('customers_parent_code_unique');
            $table->renameColumn('parent', 'parent_id');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('customers')->nullOnDelete();
            $table->unique(['parent_id', 'code'], 'customers_parent_id_code_unique');
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('customers', 'parent_id') || Schema::hasColumn('customers', 'parent')) {
            return;
        }

        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign('customers_parent_id_foreign');
            $table->dropUnique('customers_parent_id_code_unique');
            $table->renameColumn('parent_id', 'parent');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->foreign('parent')->references('id')->on('customers')->nullOnDelete();
            $table->unique(['parent', 'code']);
        });
    }
};

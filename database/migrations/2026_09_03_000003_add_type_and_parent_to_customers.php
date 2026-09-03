<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Idempoten: hanya tambah kolom yang belum ada.
        if (!Schema::hasColumn('customers', 'type')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->string('type', 32)->default('customer')->after('vat_id');
            });
        }
        if (!Schema::hasColumn('customers', 'parent')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->unsignedBigInteger('parent')->nullable()->after('type');
            });
        }
        if (!Schema::hasColumn('customers', 'address')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->string('address', 1024)->nullable()->after('name');
            });
        }
        if (Schema::hasColumn('customers', 'parent') && !Schema::hasColumn('customers', 'parent_foreign')) {
            // cek apakah foreign sudah ada dengan nama standar
            $hasFK = DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_NAME='customers' AND COLUMN_NAME='parent' AND TABLE_SCHEMA=DATABASE() AND REFERENCED_TABLE_NAME='customers'");
            if (empty($hasFK)) {
                Schema::table('customers', function (Blueprint $table) {
                    $table->foreign('parent')->references('id')->on('customers')->nullOnDelete();
                });
            }
        }

        // Composite unique parent+code hanya jika belum ada dan kolom parent ada
        if (Schema::hasColumn('customers', 'parent')) {
            $hasUnique = DB::select("SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS WHERE TABLE_NAME='customers' AND CONSTRAINT_TYPE='UNIQUE' AND TABLE_SCHEMA=DATABASE() AND CONSTRAINT_NAME LIKE '%parent_code%'");
            if (empty($hasUnique)) {
                Schema::table('customers', function (Blueprint $table) {
                    $table->dropUnique(['code']);
                    $table->unique(['parent', 'code']);
                });
            }
        }

        // Migrate data dari branches (jika tabel masih ada)
        if (Schema::hasTable('branches')) {
            $branches = DB::table('branches')->get();
            foreach ($branches as $branch) {
                DB::table('customers')->insert([
                    'ulid'      => $branch->ulid,
                    'code'      => $branch->code,
                    'name'      => $branch->name,
                    'email'     => null,
                    'phone'     => $branch->phone,
                    'address'   => $branch->address,
                    'vat_id'    => $branch->vat_id,
                    'is_active' => $branch->is_active,
                    'type'      => 'branch',
                    'parent'    => $branch->customer_id,
                    'created_at' => $branch->created_at,
                    'updated_at' => $branch->updated_at,
                    'deleted_at' => $branch->deleted_at,
                ]);
            }
            Schema::dropIfExists('branches');
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('customers', 'parent')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->dropForeign(['parent']);
            });
        }
        Schema::table('customers', function (Blueprint $table) {
            $table->dropUnique(['parent', 'code']);
            $table->unique('code');
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['type', 'parent', 'address']);
        });
    }
};

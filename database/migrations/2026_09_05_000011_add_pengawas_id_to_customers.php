<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('customers', 'pengawas_id')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->unsignedBigInteger('pengawas_id')->nullable()->after('admin_id');
                $table->foreign('pengawas_id')->references('id')->on('users')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            if (! empty($fk = Schema::getConnection()->getDoctrineSchemaManager()->listTableForeignKeys('customers'))) {
                foreach ($fk as $f) {
                    if (in_array('pengawas_id', $f->getLocalColumns())) {
                        $table->dropForeign($f->getName());
                    }
                }
            }
            $table->dropColumn('pengawas_id');
        });
    }
};
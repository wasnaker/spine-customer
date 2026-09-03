<?php

declare(strict_types=1);

namespace Modules\Customer\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spine\Traits\HasLifecycleHooks;

/**
 * Vat — NPWP / nomor pajak.
 *
 * Polimorfik: 1 NPWP bisa melekat ke banyak record (Customer, Branch,
 * Surveyor, dst.) tanpa duplikasi. Modul lain yang butuh NPWP cukup
 * deklarasi `morphMany(Vat::class, 'vattable')` di modelnya — tidak
 * ada cross-module dependency.
 *
 * NPWP disimpan sekali di sini; record attach cukup reference id.
 */
class Vat extends Model
{
    use HasLifecycleHooks;
    use HasUlids;

    protected $table = 'vats';

    protected $fillable = [
        'npwp', 'name',
        'vattable_type', 'vattable_id',
    ];

    public function uniqueIds(): array
    {
        return ['ulid'];
    }

    public function vattable(): MorphTo
    {
        return $this->morphTo();
    }
}

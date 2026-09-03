<?php

declare(strict_types=1);

namespace Modules\Customer\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Customer\Models\Vat;
use Spine\Traits\HasLifecycleHooks;

/**
 * Customer — entity utama modul Customer.
 *
 * - branches:     daftar kantor cabang / site / pabrik (hasMany).
 * - vats:         NPWP yang melekat pada customer ini (morphMany — bisa 0..N).
 *                 Satu NPWP bisa dipakai banyak customer/cabang; dibuat
 *                 terpisah di tabel 'vats' agar modul lain (Surveyor)
 *                 bisa attach Vat yang sama tanpa duplikasi.
 */
class Customer extends Model
{
    use HasLifecycleHooks;
    use HasUlids;
    use SoftDeletes;

    protected $table = 'customers';

    protected $fillable = [
        'code', 'name', 'email', 'phone',
        'parent_vat_number', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function uniqueIds(): array
    {
        return ['ulid'];
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function vats(): MorphMany
    {
        return $this->morphMany(Vat::class, 'vattable');
    }
}

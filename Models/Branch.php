<?php

declare(strict_types=1);

namespace Modules\Customer\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Vat\Models\Vat;
use Spine\Traits\HasLifecycleHooks;

/**
 * Branch — kantor cabang / site / pabrik milik Customer.
 *
 * - customer: parent (belongsTo).
 * - vat:     NPWP cabang (belongsTo vats, nullable). Tabel 'vats'
 *            di-own module spine-vat.
 * - vats:    morphMany ke spine-vat (untuk ke depan kalau 1 cabang
 *            bisa attach beberapa NPWP).
 */
class Branch extends Model
{
    use HasLifecycleHooks;
    use HasUlids;
    use SoftDeletes;

    protected $table = 'branches';

    protected $fillable = [
        'customer_id', 'code', 'name', 'address', 'phone',
        'vat_id', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function uniqueIds(): array
    {
        return ['ulid'];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function vat(): BelongsTo
    {
        return $this->belongsTo(Vat::class);
    }

    public function vats(): MorphMany
    {
        return $this->morphMany(Vat::class, 'vattable');
    }
}

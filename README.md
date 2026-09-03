# spine-customer

Modul Customer untuk platform **laravelspine** — data customer + kantor
cabang (branch) + NPWP/VAT (polimorfik, dipakai bersama modul lain).

## Entity

- **Vat** — NPWP / nomor pajak. Tabel `vats` dengan `npwp` unique.
  Polimorfik (`vattable_type` + `vattable_id`): 1 NPWP bisa melekat ke
  banyak record lintas module. Modul lain (mis. Surveyor) cukup deklarasi
  `morphMany(Vat::class, 'vattable')` di modelnya — tidak ada
  cross-module dependency.
- **Customer** — entitas utama. Field: `code` (unique), `name`, `email`,
  `phone`, `parent_vat_number` (NPWP HO, nullable), `is_active`,
  `ulid`, soft delete. HasMany Branch + MorphMany Vat.
- **Branch** — kantor cabang / site / pabrik. Field: `customer_id` (FK),
  `code` (nullable), `name`, `address`, `phone`, `vat_id` (FK ke vats,
  nullable), `is_active`. BelongsTo Customer + BelongsTo Vat.

## API

```
GET    /api/v1/customers                  customer:view
POST   /api/v1/customers                  customer:create
GET    /api/v1/customers/{id}             customer:view
PUT    /api/v1/customers/{id}             customer:edit
DELETE /api/v1/customers/{id}             customer:delete
GET    /api/v1/customers/{id}/activity-logs   customer:view
GET    /api/v1/customers/{id}/branches        branch:view   (nested)

GET    /api/v1/branches                   branch:view
POST   /api/v1/branches                   branch:create
GET    /api/v1/branches/{id}              branch:view
PUT    /api/v1/branches/{id}              branch:edit
DELETE /api/v1/branches/{id}              branch:delete
GET    /api/v1/branches/{id}/activity-logs    branch:view

GET    /api/v1/vats                       customer:view
POST   /api/v1/vats                       customer:create
GET    /api/v1/vats/{id}                  customer:view
PUT    /api/v1/vats/{id}                  customer:edit
DELETE /api/v1/vats/{id}                  customer:delete
```

Vat dipakai untuk autocomplete NPWP di form Customer/Branch, sehingga
gate-nya mengikuti permission Customer (bukan permission sendiri).

## RBAC

Dideklarasikan di `manifest.php` key `rbac`:

- **Permission (8)**: `customer:{view,create,edit,delete}` + `branch:{view,create,edit,delete}`
- **Role (3)**:
  - `customer`             → `customer:view` (read-only)
  - `customer-branch-admin`→ `customer:view` + `branch:*` (cabang admin)
  - `customer-admin`       → `customer:*` + `branch:*` (full)
- **Grants**: `staff` → `customer:view` + `branch:view` (staff internal bisa lihat)

Sync ke database via:

```bash
php artisan spine:rbac:sync                # semua modul
php artisan spine:rbac:sync --module=Customer   # satu modul
```

## Lifecycle

Tiap entity (`Customer`, `Branch`, `Vat`) memakai `HasLifecycleHooks`
dari platform — otomatis dispatch `EntityCreated/Updated/Deleted`.
Listener `Log{Customer,Branch,Vat}Activity` di `Listeners/` mencatat ke
activity log via `ActivityLogService`.

## Menu

`manifest.php` mendeklarasikan item menu **Customers** dengan
`permission: customer:view` — otomatis tersembunyi untuk user tanpa
permission (frontend filter via `can()`).

## Instalasi (konsumen laravelspine)

1. Copy/symlink module ke `modules/Customer/` di konsumen
2. Tambahkan `Customer` ke `modules_statuses.json`
3. `composer dump-autoload`
4. `php artisan migrate`
5. `php artisan spine:rbac:sync`

## Catatan

- Field `parent_vat_number` di `customers` adalah string NPWP HO
  (nullable). Bisa berbeda dengan NPWP cabang — cabang punya
  `vat_id` sendiri (FK ke `vats`) atau null.
- Vat polimorfik: 1 NPWP = 1 record di `vats`. Attach ke Customer atau
  Branch lewat `vattable_type` + `vattable_id`. Contoh: `vattable_type
  = "Modules\Customer\Models\Customer"`, `vattable_id = 1`.
- Activity log: lihat `Listeners/Log*.php`. Tidak ada status-change
  untuk Vat (model referensi).

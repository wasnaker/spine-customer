# spine-customer

Modul Customer untuk platform **laravelspine** — data customer + kantor
cabang (branch). NPWP/VAT dipakai bersama module lain via
**[spine-vat](https://github.com/wasnaker/spine-vat)** (FK reference,
bukan morph).

## Entity

- **Customer** — entitas utama. Field: `code` (unique), `name`, `email`,
  `phone`, `vat_id` (FK nullable ke `vats.id` — NPWP HO), `is_active`,
  `ulid`, soft delete. HasMany Branch. BelongsTo Vat.
- **Branch** — kantor cabang / site / pabrik. Field: `customer_id` (FK),
  `code` (nullable), `name`, `address`, `phone`, `vat_id` (FK nullable
  ke `vats.id` — NPWP cabang), `is_active`. BelongsTo Customer + Vat.

## Dependensi

- **wajib**: [`wasnaker/spine-vat`](https://github.com/wasnaker/spine-vat) — tabel `vats` di-own module itu; customer & branch pakai FK `vat_id`.

## Prinsip NPWP

**1 NPWP = 1 row global** di tabel `vats` (npwp unique). Customer/Branch
yang pakai NPWP yang sama cukup reference row yang sama via FK
`vat_id` — tidak duplikat. Pakai `VatService::findOrCreateId()` di
controller untuk dapat id (auto-create kalau belum ada).

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
```

Endpoint Vat ada di module spine-vat (`/api/v1/vats`).

## RBAC

- **Permission (8)**: `customer:{view,create,edit,delete}` + `branch:{view,create,edit,delete}`
- **Role (3)**:
  - `customer`             → `customer:view`
  - `customer-branch-admin`→ `customer:view` + `branch:*`
  - `customer-admin`       → `customer:*` + `branch:*`
- **Grants**: `staff` → `customer:view` + `branch:view`

Sync: `php artisan spine:rbac:sync`.

## Lifecycle

`Customer` & `Branch` pakai `HasLifecycleHooks` → listener log activity.
Vat lifecycle di-handle module `spine-vat`.

## Menu

Item menu **Customers** dengan `permission: customer:view` — auto-hidden
untuk user tanpa permission.

## Instalasi (konsumen laravelspine)

1. Install `spine-vat` dulu (module dependensi — tabel `vats` harus
   ada sebelum `customers`).
2. Install `spine-customer`: taruh di `modules/Customer/`, tambahkan
   `'Customer'` ke `modules_statuses.json`.
3. `composer dump-autoload`
4. `php artisan migrate`  → vats → customers → branches berurutan
5. `php artisan spine:rbac:sync`

## v2 → v3 changelog

- Drop morph (vattable_type+vattable_id) dari `vats` — pakai FK saja.
- Tabel `customers`: ganti field `parent_vat_number` (string) → `vat_id` (FK).
- `VatService` disederhanakan: hanya `findByNpwp`, `findOrCreate`,
  `findOrCreateId`. Method `attach()` / `detach()` dihapus karena
  1 NPWP = 1 row, attach = reference via FK.
- Field form `npwp` di CustomerController: auto-create Vat row, simpan
  `vat_id` FK.

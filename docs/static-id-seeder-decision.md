# Static ID pada Seeder — Catatan Diskusi

Tanggal: 2026-09-04
Module: Customer (CustomerDemoSeeder) — relevan untuk semua seeder demo
Status: DISKUSI (belum diputuskan / belum diimplementasi)

## Topik

User ingin ID record (mis. `customers.id`, `admin_id`, dan relasi FK) menjadi
STATIC / snapshot — id yang sama persis di semua environment, tidak bergantung
urutan auto-increment saat seed pertama dijalankan.

## Fakta yang sudah diverifikasi

1. Seeder saat ini idempotent (firstOrCreate by code + parent) —
   re-run di env yang sama TIDAK mengubah row existing dan TIDAK menaikkan
   auto-increment (terbukti: AI customers 142, users 175, vats 258 — sama
   sebelum & sesudah re-seed).
2. Auto-increment naik hanya saat INSERT pertama (env fresh).
3. ID numeric (auto-increment) antar environment TIDAK dijamin sama:
   - urutan seed/insert bisa beda
   - ada data lain yang sudah terlanjur masuk (mis. row test, user manual)
   - staging saat ini: customers id mulai 57, users id sampai 174+
4. Relasi FK (parent_id, admin_id, vat_id) dibangun saat seed via lookup
   (code/email/NPWP), bukan hardcode id — karena itu seeder jalan di env mana pun.
5. Model Customer: `id` = auto-increment (HasUlids menambah kolom `ulid` unik).

## Opsi yang dibahas

### Opsi 1 — ID eksplisit snapshot di data seeder (yang user minta)
- `id` dimasukkan sebagai bagian dari data literal snapshot.
- Insert pertama memakai id eksplisit: `firstOrCreate([...], ['id' => 57, ...])`.
- Efek: id identik di semua env fresh.
- Syarat/risiko:
  - Env yang SUDAH terlanjur seed (staging sekarang) tidak bisa dipaksa ulang
    tanpa reset penuh + semua tabel FK yang mereferensi ikut di-reset.
  - Perlu urutan seed deterministik & konsisten antar module (siapa insert duluan).
  - Konflik id kalau tabel lain (users, vats) sudah punya id di rentang yang sama.

### Opsi 2 — Andalkan referensi natural (code/email/NPWP), bukan angka id
- `code` customer/branch unik & eksplisit di data → referensi stabil yang benar.
- `admin_id`/`vat_id` di-set saat seed via lookup, tidak perlu identik antar env.
- Tidak ada jaminan angka id sama, tapi TIDAK BUTUH id sama karena relasi
  selalu dibangun ulang dari referensi natural.
- Inilah pola yang dipakai seeder sekarang.

### Opsi 3 — Id tidak berubah di env yang sama (re-seed)
- Sudah terpenuhi oleh idempotensi firstOrCreate.

## Keputusan sementara

Belum ada. User menyatakan ingin Opsi 1 (static ID snapshot) dan akan
memberikan pandangan/alasannya menyusul — catatan ini menunggu input tersebut.

## TODO

- [ ] Terima pandangan user: kenapa static ID dibutuhkan
- [ ] Putuskan scope: hanya customers? users? vats? semua module demo?
- [ ] Putuskan strategi reset env lama (migrate:fresh?) vs hanya berlaku env baru
- [ ] Update generator snapshot agar menyertakan id
- [ ] Update seeder (insert id eksplisit, urut HO → branch, admin/vat id konsisten)
- [ ] Verifikasi id stabil di 2 env berbeda

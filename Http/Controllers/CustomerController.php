<?php

declare(strict_types=1);

namespace Modules\Customer\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Connection\Models\Connection;
use Modules\Connection\Services\ActorResolver;
use Modules\Customer\Models\Customer;
use Modules\Vat\Services\VatService;
use Spine\Services\ActivityLogService;

/**
 * CRUD Customer — modul Customer.
 *
 * Field business:
 *   - type          ('customer' untuk HO, 'branch' untuk cabang)
 *   - parent        (FK ke customers.id, hanya diisi kalau type='branch')
 *   - code          (unique per parent — code boleh duplikat kalau parent beda)
 *   - name, email, phone, address
 *   - npwp          (string dari form; auto-create Vat row, simpan vat_id FK)
 *   - is_active     (boolean)
 *
 * Activity log OTOMATIS via EntityCreated/Updated/Deleted (HasLifecycleHooks)
 * -> listener LogCustomerActivity di ServiceProvider.
 */
class CustomerController extends Controller
{
    public function __construct(
        private readonly ActivityLogService $activityLog,
        private readonly VatService $vats,
        private readonly ActorResolver $actors,
    ) {
    }

    /**
     * True kalau caller akses penuh (platform: customer:view).
     * Caller view-connected (surveyor) TIDAK punya customer:view.
     */
    private function isFullAccess(Request $request): bool
    {
        return $request->user()->hasPermissionTo('customer:view');
    }

    /**
     * Customer id yang terhubung ACTIVE dengan surveyor entity user.
     */
    private function connectedCustomerIds(int $surveyorId): array
    {
        return Connection::where('surveyor_id', $surveyorId)
            ->where('status', 'active')
            ->pluck('customer_id')
            ->all();
    }

    /**
     * Guard record utk caller surveyor (view-connected): row customer hanya
     * boleh diakses kalau terhubung active. Platform lolos tanpa cek.
     */
    private function allowAccessTo(Request $request, int $customerId): bool
    {
        if ($this->isFullAccess($request)) {
            return true;
        }

        $actor = $this->actors->resolve($request->user());
        if ($actor['type'] !== 'surveyor') {
            return false;
        }

        return in_array($customerId, $this->connectedCustomerIds($actor['entity']->id), true);
    }

    public function index(Request $request): JsonResponse
    {
        $query = Customer::with([ 'vat', 'parent:id,code,name', 'admin:id,name', 'province:id,name', 'regency:id,name']);

        // Caller surveyor (view-connected): daftar dibatasi customer yg
        // terhubung ACTIVE dengannya (direktori rekanan via connection).
        if (! $this->isFullAccess($request)) {
            $actor = $this->actors->resolve($request->user());
            if ($actor['type'] !== 'surveyor') {
                return response()->json(['message' => 'Forbidden.'], 403);
            }
            $ids = $this->connectedCustomerIds($actor['entity']->id);
            $query->whereIn('id', $ids === [] ? [0] : $ids);
        }

        if ($request->filled('q')) {
            $term = $request->string('q');
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('code', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%");
            });
        }
        if ($request->has('is_active')) {
            $query->where('is_active', filter_var($request->query('is_active'), FILTER_VALIDATE_BOOLEAN));
        }
        if ($request->has('type')) {
            $type = $request->query('type');
            if ($type === 'customer') {
                $query->where('type', 'customer');
            } elseif ($type === 'branch') {
                $query->where('type', 'branch');
            }
        }

        // Order: HO first, then branches, by id desc
        $query->orderByRaw("CASE WHEN type = 'customer' THEN 0 ELSE 1 END")
              ->orderByDesc('id');

        return response()->json(['data' => $query->get()]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'type'      => ['sometimes', 'string', 'in:customer,branch'],
            'code'      => ['required', 'string', 'max:64'],
            'name'      => ['required', 'string', 'max:190'],
            'email'     => ['nullable', 'string', 'email', 'max:190'],
            'phone'     => ['nullable', 'string', 'max:32'],
            'address'   => ['nullable', 'string'],
            'province_id' => ['nullable', 'integer', 'exists:provinces,id'],
            'regency_id'  => ['nullable', 'integer', 'exists:regencies,id'],
            'npwp'      => ['nullable', 'string', 'max:32'],
            'is_active' => ['sometimes', 'boolean'],
            'parent_id'    => ['nullable', 'integer'],
        ]);

        $type = $validated['type'] ?? 'customer';
        $parent = $validated['parent_id'] ?? null;

        if (! in_array($type, ['customer', 'branch'])) {
            $type = 'customer';
        }

        if ($type === 'branch' && ! $parent) {
            return response()->json(['message' => 'Branch harus memiliki parent.'], 422);
        }

        if ($type === 'customer' && $parent) {
            return response()->json(['message' => 'Customer HO tidak boleh memiliki parent.'], 422);
        }

        $code = $validated['code'];
        $check = Customer::where('parent_id', $parent)
            ->where('code', $code)
            ->where('deleted_at', null)
            ->first();
        if ($check) {
            return response()->json(['message' => "Code {$code} sudah ada untuk parent ini."], 422);
        }

        $vatId = null;
        if (! empty($validated['npwp'])) {
            $vatId = $this->vats->findOrCreateId($validated['npwp'], $validated['name']);
        }
        unset($validated['npwp']);

        $entity = Customer::create(array_merge($validated, [
            'vat_id'  => $vatId,
            'type'    => $type,
            'parent_id'  => $parent,
        ]));

        Log::info("[Customer] created", ['id' => $entity->id, 'code' => $entity->code, 'type' => $type]);

        return response()->json($entity, 201);
    }

    public function show(int $id, Request $request): JsonResponse
    {
        if (! $this->allowAccessTo($request, $id)) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $entity = Customer::with(['branches.vat', 'branches.parent:id,code,name', 'branches.admin:id,name', 'branches.province:id,name', 'branches.regency:id,name',  'vat', 'parent:id,code,name', 'admin:id,name', 'province:id,name', 'regency:id,name'])->find($id);

        if (! $entity) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        return response()->json($entity);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $entity = Customer::find($id);

        if (! $entity) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $validated = $request->validate([
            'type'      => ['sometimes', 'string', 'in:customer,branch'],
            'code'      => ['sometimes', 'string', 'max:64'],
            'name'      => ['sometimes', 'string', 'max:190'],
            'email'     => ['nullable', 'string', 'email', 'max:190'],
            'phone'     => ['nullable', 'string', 'max:32'],
            'address'   => ['nullable', 'string'],
            'province_id' => ['nullable', 'integer', 'exists:provinces,id'],
            'regency_id'  => ['nullable', 'integer', 'exists:regencies,id'],
            'npwp'      => ['nullable', 'string', 'max:32'],
            'is_active' => ['sometimes', 'boolean'],
            'parent_id'    => ['nullable', 'integer'],
        ]);

        if (array_key_exists('type', $validated) && $validated['type'] !== $entity->type) {
            return response()->json(['message' => 'Tidak boleh mengubah type setelah row dibuat.'], 422);
        }

        if (array_key_exists('parent_id', $validated) && $validated['parent_id'] !== $entity->parent_id) {
            return response()->json(['message' => 'Tidak boleh mengubah parent setelah row dibuat.'], 422);
        }

        if (array_key_exists('code', $validated)) {
            $newCode = $validated['code'];
            $dup = Customer::where('id', '!=', $entity->id)
                ->where('parent_id', $entity->parent_id)
                ->where('code', $newCode)
                ->where('deleted_at', null)
                ->first();
            if ($dup) {
                return response()->json(['message' => "Code {$newCode} sudah ada untuk parent ini."], 422);
            }
        }

        if (array_key_exists('npwp', $validated)) {
            if (! empty($validated['npwp'])) {
                $entity->vat_id = $this->vats->findOrCreateId($validated['npwp'], $entity->name);
            } else {
                $entity->vat_id = null;
            }
            unset($validated['npwp']);
        }

        $entity->update($validated);

        Log::info("[Customer] updated", ['id' => $entity->id, 'code' => $entity->code, 'type' => $entity->type]);

        return response()->json($entity);
    }

    public function destroy(int $id): JsonResponse
    {
        $entity = Customer::find($id);

        if (! $entity) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $entity->delete();

        return response()->json(['message' => 'Customer deleted']);
    }

    public function branches(int $id, Request $request): JsonResponse
    {
        if (! $this->allowAccessTo($request, $id)) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $parent = Customer::find($id);

        if (! $parent) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        return response()->json(['data' => $parent->branches()->with(['vat', 'admin:id,name', 'province:id,name', 'regency:id,name'])->get()]);
    }

    public function activityLogs(int $id, Request $request): JsonResponse
    {
        if (! $this->allowAccessTo($request, $id)) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        if (! Customer::find($id)) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $logs = $this->activityLog
            ->query()
            ->where('subject_type', Customer::class)
            ->where('subject_id', $id)
            ->orderByDesc('created_at')
            ->get()
            ->map(fn ($log) => [
                'id'          => $log->id,
                'description' => $log->description,
                'causer'      => $log->causer?->name ?? 'System',
                'properties'  => $log->properties,
                'at'          => $log->created_at?->toIso8601String(),
            ]);

        return response()->json(['data' => $logs]);
    }
}

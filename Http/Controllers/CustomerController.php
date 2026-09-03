<?php

declare(strict_types=1);

namespace Modules\Customer\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Customer\Models\Customer;
use Modules\Vat\Services\VatService;
use Spine\Services\ActivityLogService;

/**
 * CRUD Customer — modul Customer.
 *
 * Field business:
 *   - code              (unique kode internal)
 *   - name, email, phone
 *   - parent_vat_number (NPWP HO, nullable). Disimpan literal di sini
 *                        + otomatis di-attach ke record Vat via
 *                        VatService::findOrCreate() (module spine-vat).
 *   - is_active         (boolean)
 *
 * Activity log OTOMATIS via EntityCreated/Updated/Deleted (HasLifecycleHooks)
 * -> listener LogCustomerActivity di ServiceProvider.
 */
class CustomerController extends Controller
{
    public function __construct(
        private readonly ActivityLogService $activityLog,
        private readonly VatService $vats,
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $query = Customer::query();

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

        return response()->json(['data' => $query->orderByDesc('id')->get()]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code'              => ['required', 'string', 'max:64', 'unique:customers,code'],
            'name'              => ['required', 'string', 'max:190'],
            'email'             => ['nullable', 'string', 'email', 'max:190'],
            'phone'             => ['nullable', 'string', 'max:32'],
            'parent_vat_number' => ['nullable', 'string', 'max:32'],
            'is_active'         => ['sometimes', 'boolean'],
        ]);

        $entity = Customer::create($validated);

        // Auto-attach NPWP ke Vat (module spine-vat) — idempotent.
        if ($entity->parent_vat_number) {
            $this->vats->findOrCreate($entity->parent_vat_number, $entity, $entity->name);
        }

        Log::info("[Customer] created", ['id' => $entity->id, 'code' => $entity->code]);

        return response()->json($entity, 201);
    }

    public function show(int $id): JsonResponse
    {
        $entity = Customer::with(['branches', 'vats'])->find($id);

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
            'code'              => ['sometimes', 'string', 'max:64', 'unique:customers,code,' . $id],
            'name'              => ['sometimes', 'string', 'max:190'],
            'email'             => ['nullable', 'string', 'email', 'max:190'],
            'phone'             => ['nullable', 'string', 'max:32'],
            'parent_vat_number' => ['nullable', 'string', 'max:32'],
            'is_active'         => ['sometimes', 'boolean'],
        ]);

        $entity->update($validated);

        // Re-attach NPWP kalau parent_vat_number berubah.
        if ($request->has('parent_vat_number') && $entity->parent_vat_number) {
            $this->vats->findOrCreate($entity->parent_vat_number, $entity, $entity->name);
        }

        Log::info("[Customer] updated", ['id' => $entity->id, 'code' => $entity->code]);

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

    public function activityLogs(int $id): JsonResponse
    {
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

    /**
     * Branches milik customer ini (nested resource — proxy ke BranchController::index
     * dengan filter customer_id).
     */
    public function branches(int $id, Request $request): JsonResponse
    {
        if (! Customer::find($id)) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $query = \Modules\Customer\Models\Branch::query()->where('customer_id', $id);
        if ($request->has('is_active')) {
            $query->where('is_active', filter_var($request->query('is_active'), FILTER_VALIDATE_BOOLEAN));
        }

        return response()->json(['data' => $query->orderByDesc('id')->get()]);
    }
}

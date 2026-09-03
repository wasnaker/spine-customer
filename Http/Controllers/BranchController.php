<?php

declare(strict_types=1);

namespace Modules\Customer\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Customer\Models\Branch;
use Modules\Customer\Models\Customer;
use Spine\Services\ActivityLogService;

/**
 * CRUD Branch — kantor cabang / site / pabrik.
 *
 * Field:
 *   - customer_id   FK ke customers
 *   - code          (nullable, kode internal cabang)
 *   - name, address, phone
 *   - vat_id        FK ke vats (NPWP cabang, nullable)
 *   - is_active
 */
class BranchController extends Controller
{
    public function __construct(private readonly ActivityLogService $activityLog)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $query = Branch::query();

        if ($request->has('customer_id')) {
            $query->where('customer_id', (int) $request->query('customer_id'));
        }
        if ($request->has('is_active')) {
            $query->where('is_active', filter_var($request->query('is_active'), FILTER_VALIDATE_BOOLEAN));
        }

        return response()->json(['data' => $query->orderByDesc('id')->get()]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'code'        => ['nullable', 'string', 'max:64'],
            'name'        => ['required', 'string', 'max:190'],
            'address'     => ['nullable', 'string'],
            'phone'       => ['nullable', 'string', 'max:32'],
            'vat_id'      => ['nullable', 'integer', 'exists:vats,id'],
            'is_active'   => ['sometimes', 'boolean'],
        ]);

        $entity = Branch::create($validated);

        Log::info("[Branch] created", ['id' => $entity->id, 'customer_id' => $entity->customer_id]);

        return response()->json($entity, 201);
    }

    public function show(int $id): JsonResponse
    {
        $entity = Branch::with(['customer', 'vat'])->find($id);

        if (! $entity) {
            return response()->json(['message' => 'Branch not found'], 404);
        }

        return response()->json($entity);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $entity = Branch::find($id);

        if (! $entity) {
            return response()->json(['message' => 'Branch not found'], 404);
        }

        $validated = $request->validate([
            'customer_id' => ['sometimes', 'integer', 'exists:customers,id'],
            'code'        => ['nullable', 'string', 'max:64'],
            'name'        => ['sometimes', 'string', 'max:190'],
            'address'     => ['nullable', 'string'],
            'phone'       => ['nullable', 'string', 'max:32'],
            'vat_id'      => ['nullable', 'integer', 'exists:vats,id'],
            'is_active'   => ['sometimes', 'boolean'],
        ]);

        $entity->update($validated);

        Log::info("[Branch] updated", ['id' => $entity->id, 'customer_id' => $entity->customer_id]);

        return response()->json($entity);
    }

    public function destroy(int $id): JsonResponse
    {
        $entity = Branch::find($id);

        if (! $entity) {
            return response()->json(['message' => 'Branch not found'], 404);
        }

        $entity->delete();

        return response()->json(['message' => 'Branch deleted']);
    }

    public function activityLogs(int $id): JsonResponse
    {
        if (! Branch::find($id)) {
            return response()->json(['message' => 'Branch not found'], 404);
        }

        $logs = $this->activityLog
            ->query()
            ->where('subject_type', Branch::class)
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

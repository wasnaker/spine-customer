<?php

declare(strict_types=1);

namespace Modules\Customer\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Customer\Models\Vat;
use Spine\Services\ActivityLogService;

/**
 * CRUD Vat — NPWP / nomor pajak.
 *
 * NPWP disimpan sekali di sini (unique). Record customer/branch attach
 * lewat morph — id vattable_type + vattable_id. Untuk attach ke record
 * lain, create Vat baru dengan vattable_type & vattable_id.
 *
 * Endpoints:
 *   GET    /api/v1/vats                       list (optional ?npwp= / ?q=)
 *   POST   /api/v1/vats                       create
 *   GET    /api/v1/vats/{id}                  show
 *   PUT    /api/v1/vats/{id}                  update
 *   DELETE /api/v1/vats/{id}                  delete
 */
class VatController extends Controller
{
    public function __construct(private readonly ActivityLogService $activityLog)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $query = Vat::query();

        if ($request->filled('q')) {
            $term = $request->string('q');
            $query->where(function ($q) use ($term) {
                $q->where('npwp', 'like', "%{$term}%")
                  ->orWhere('name', 'like', "%{$term}%");
            });
        }
        if ($request->filled('vattable_type')) {
            $query->where('vattable_type', $request->string('vattable_type'));
        }

        return response()->json(['data' => $query->orderByDesc('id')->limit(200)->get()]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'npwp'           => ['required', 'string', 'max:32', 'unique:vats,npwp'],
            'name'           => ['nullable', 'string', 'max:190'],
            'vattable_type'  => ['required', 'string', 'max:64'],
            'vattable_id'    => ['required', 'integer'],
        ]);

        $entity = Vat::create($validated);

        Log::info("[Vat] created", ['id' => $entity->id, 'npwp' => $entity->npwp]);

        return response()->json($entity, 201);
    }

    public function show(int $id): JsonResponse
    {
        $entity = Vat::find($id);

        if (! $entity) {
            return response()->json(['message' => 'Vat not found'], 404);
        }

        return response()->json($entity);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $entity = Vat::find($id);

        if (! $entity) {
            return response()->json(['message' => 'Vat not found'], 404);
        }

        $validated = $request->validate([
            'npwp'          => ['sometimes', 'string', 'max:32', 'unique:vats,npwp,' . $id],
            'name'          => ['nullable', 'string', 'max:190'],
            'vattable_type' => ['sometimes', 'string', 'max:64'],
            'vattable_id'   => ['sometimes', 'integer'],
        ]);

        $entity->update($validated);

        Log::info("[Vat] updated", ['id' => $entity->id, 'npwp' => $entity->npwp]);

        return response()->json($entity);
    }

    public function destroy(int $id): JsonResponse
    {
        $entity = Vat::find($id);

        if (! $entity) {
            return response()->json(['message' => 'Vat not found'], 404);
        }

        $entity->delete();

        return response()->json(['message' => 'Vat deleted']);
    }
}

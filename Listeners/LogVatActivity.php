<?php

declare(strict_types=1);

namespace Modules\Customer\Listeners;

use Modules\Customer\Models\Vat;
use Spine\Events\EntityCreated;
use Spine\Events\EntityDeleted;
use Spine\Events\EntityUpdated;
use Spine\Services\ActivityLogService;

/**
 * HOOK — Vat lifecycle (HasLifecycleHooks).
 *
 * Tidak ada status-change di Vat (model referensi). Cukup created/updated/deleted.
 */
class LogVatActivity
{
    public function __construct(private readonly ActivityLogService $activityLog)
    {
    }

    public function created(EntityCreated $event): void
    {
        if (! $event->entity instanceof Vat) {
            return;
        }

        $this->activityLog->log(
            "Vat created: " . $this->label($event->entity),
            $event->entity,
            $this->user(),
            ['event' => 'created'],
        );
    }

    public function updated(EntityUpdated $event): void
    {
        if (! $event->entity instanceof Vat) {
            return;
        }

        $this->activityLog->log(
            "Vat updated: " . $this->label($event->entity),
            $event->entity,
            $this->user(),
            ['event' => 'updated', 'changes' => $event->changes],
        );
    }

    public function deleted(EntityDeleted $event): void
    {
        if (! $event->entity instanceof Vat) {
            return;
        }

        $this->activityLog->log(
            "Vat deleted: " . $this->label($event->entity),
            null,
            $this->user(),
            ['event' => 'deleted', 'id' => $event->entity->getKey()],
            null,
            $event->entityType,
        );
    }

    private function label($entity): string
    {
        return (string) ($entity->npwp ?? $entity->getKey());
    }

    private function user(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        return auth('sanctum')->user() ?? auth()->user();
    }
}

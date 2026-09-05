<?php

declare(strict_types=1);

namespace Modules\Customer\Listeners;

use Modules\Customer\Models\Customer;
use Spine\Events\EntityCreated;
use Spine\Events\EntityDeleted;
use Spine\Events\EntityUpdated;
use Spine\Services\ActivityLogService;

/**
 * HOOK — entity lifecycle generic (HasLifecycleHooks) untuk Customer.
 *
 * 1. created/updated/deleted -> activity log (satu listener, semua entity).
 * 2. STATUS-CHANGE pattern: EntityUpdated mengecek changes['is_active'] —
 *    padanan Customer Status Changed di legacy Clients_model.php.
 */
class LogCustomerActivity
{
    public function __construct(private readonly ActivityLogService $activityLog)
    {
    }

    public function created(EntityCreated $event): void
    {
        if (! $event->entity instanceof Customer) {
            return;
        }

        $this->activityLog->log(
            "Customer created: " . $this->label($event->entity),
            $event->entity,
            $this->user(),
            ['event' => 'created'],
        );
    }

    public function updated(EntityUpdated $event): void
    {
        if (! $event->entity instanceof Customer) {
            return;
        }

        $changes = $event->changes;

        $this->activityLog->log(
            "Customer updated: " . $this->label($event->entity) . " (" . $this->describe($changes) . ")",
            $event->entity,
            $this->user(),
            ['event' => 'updated', 'changes' => $changes],
        );

        $status = $changes['is_active'] ?? null;
        if ($status && $status['old'] !== $status['new']) {
            $this->activityLog->log(
                "Customer status changed: " . $this->boolLabel($status['old']) . " -> " . $this->boolLabel($status['new']),
                $event->entity,
                $this->user(),
                ['event' => 'customer.status_changed', 'old' => $status['old'], 'new' => $status['new']],
            );
        }
    }

    public function deleted(EntityDeleted $event): void
    {
        if (! $event->entity instanceof Customer) {
            return;
        }

        $this->activityLog->log(
            "Customer deleted: " . $this->label($event->entity),
            null,
            $this->user(),
            ['event' => 'deleted', 'id' => $event->entity->getKey()],
            null,
            $event->entityType,
        );
    }

    private function describe(array $changes): string
    {
        $parts = [];

        foreach ($changes as $field => $change) {
            if (in_array($field, ['updated_at', 'remember_token'], true)) {
                continue;
            }

            $label = Customer::labels()[$field] ?? $field;
            $parts[] = $label . ': ' . $change['old'] . ' → ' . $change['new'];
        }

        return implode(', ', $parts);
    }

    private function boolLabel(mixed $value): string
    {
        return $value ? 'Aktif' : 'Nonaktif';
    }

    private function label($entity): string
    {
        return (string) ($entity->name ?? $entity->getKey());
    }

    private function user(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        return auth('sanctum')->user() ?? auth()->user();
    }
}
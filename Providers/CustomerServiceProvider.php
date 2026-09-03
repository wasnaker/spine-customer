<?php

declare(strict_types=1);

namespace Modules\Customer\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Modules\Customer\Listeners\LogCustomerActivity;

class CustomerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../Http/routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // HOOK — entity lifecycle (HasLifecycleHooks).
        // Branch sekarang adalah row di tabel customers dengan type='branch',
        // jadi tidak perlu listener terpisah untuk Branch.
        Event::listen(\Spine\Events\EntityCreated::class, LogCustomerActivity::class . '@created');
        Event::listen(\Spine\Events\EntityUpdated::class, LogCustomerActivity::class . '@updated');
        Event::listen(\Spine\Events\EntityDeleted::class, LogCustomerActivity::class . '@deleted');
    }
}

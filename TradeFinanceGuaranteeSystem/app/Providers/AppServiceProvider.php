<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// ✅ Add these:
use App\Repositories\Contracts\GuaranteeRepositoryInterface;
use App\Repositories\GuaranteeRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // ✅ Binding works now:
        $this->app->bind(GuaranteeRepositoryInterface::class, GuaranteeRepository::class);
    }

    public function boot(): void
    {
        //
    }
}

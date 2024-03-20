<?php

namespace Raysulkobir\ZktecoLaravel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class ZktecoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'ZktecoService');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->registerRoutes();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '../config/config.php' => config_path('ZktecoService.php'),
        ], 'config');

        if (!class_exists('createAttandancesTable')) {
            $this->publishes([
                __DIR__ . '../database/migrations/2024_02_27_190214_create_attendance_logs_table.php' => database_path('migrations/2024_02_27_190214_create_attendance_logs_table.php'),
                __DIR__ . '../database/migrations/2024_02_23_043452_create_attendances_table.php' => database_path('migrations/2024_02_23_043452_create_attendances_table.php'),
                __DIR__ . '../database/migrations/2024_02_22_193324_create_employees_table.php' => database_path('migrations/2024_02_22_193324_create_employees_table.php'),
                __DIR__ . '../database/migrations//2024_02_22_202734_create_schedules_table.php' => database_path('migrations/2024_02_22_202734_create_schedules_table.php'),
                __DIR__ . '../database/migrations/2024_02_23_044756_create_latetimes_table.php' => database_path('migrations/2024_02_23_044756_create_latetimes_table.php'),
                __DIR__ . '../database/migrations/2024_02_23_063541_create_leaves_table.php' => database_path('migrations/2024_02_23_063541_create_leaves_table.php'),
                __DIR__ . '../database/migrations/2024_02_23_064955_create_overtimes_table.php' => database_path('migrations/2024_02_23_064955_create_overtimes_table.php'),
                __DIR__ . '../database/migrations/2024_02_22_140211_create_finger_devices_table.php' => database_path('migrations/2024_02_22_140211_create_finger_devices_table.php'),
            ], 'migrations');
        }
    }

    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/Route/Routes.php');
        });
    }

    protected function routeConfiguration()
    {
        return [
            'prefix' => config('ZktecoService.prefix'),
            'middleware' => config('ZktecoService.middleware'),
        ];
    }
}

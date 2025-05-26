<?php

namespace Botble\EmailOrder\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Botble\Base\Facades\DashboardMenu;

class EmailOrderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadAndPublishConfigurations(['permissions']);
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'email-order');
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'email-order');
    }

    public function register()
    {
        // Register bindings, if any
    }

    protected function loadAndPublishConfigurations(array $configs)
    {
        foreach ($configs as $config) {
            $this->mergeConfigFrom(
                __DIR__ . '/../../config/' . $config . '.php',
                'email-order.' . $config
            );
        }
    }
} 
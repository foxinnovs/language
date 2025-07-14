<?php

namespace Akaunting\Language;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\AliasLoader;

class Provider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/language.php', 'language');
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Publier la configuration
        $this->publishes([
            __DIR__ . '/config/language.php' => config_path('language.php'),
        ], 'language-config');

        // Publier les vues
        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/language'),
        ], 'language-views');

        // Publier les assets
        $this->publishes([
            __DIR__ . '/resources/assets' => public_path('vendor/language'),
        ], 'language-assets');

        // Charger les vues
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'language');

        // Charger les routes
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        // Charger les migrations
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        // Charger les traductions
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'language');

        // Enregistrer les commandes
        if ($this->app->runningInConsole()) {
            $this->commands([
                // Ajoutez vos commandes ici
            ]);
        }

        // Middleware global pour la détection de langue
        if (config('language.auto_detect', true)) {
            $this->app['router']->pushMiddlewareToGroup('web', Middleware\SetLanguage::class);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
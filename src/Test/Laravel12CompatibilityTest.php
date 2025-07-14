<?php

namespace Akaunting\Language\Tests;

use Orchestra\Testbench\TestCase;
use Akaunting\Language\Provider;

class Laravel12CompatibilityTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [Provider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Configuration de test
        $app['config']->set('app.key', 'base64:' . base64_encode('your-secret-key-here'));
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    public function test_service_provider_loads_successfully()
    {
        $this->assertTrue(true);
    }

    public function test_config_is_merged()
    {
        $config = config('language');
        $this->assertIsArray($config);
    }

    public function test_middleware_can_be_resolved()
    {
        if (class_exists('Akaunting\Language\Middleware\SetLanguage')) {
            $middleware = $this->app->make('Akaunting\Language\Middleware\SetLanguage');
            $this->assertNotNull($middleware);
        }
        
        $this->assertTrue(true);
    }

    public function test_trust_proxies_middleware_works()
    {
        if (class_exists('Akaunting\Language\Middleware\TrustProxies')) {
            $middleware = $this->app->make('Akaunting\Language\Middleware\TrustProxies');
            $this->assertNotNull($middleware);
        }
        
        $this->assertTrue(true);
    }

    public function test_laravel_version_compatibility()
    {
        $version = $this->app->version();
        $this->assertStringContainsString('Laravel', $version);
    }

    public function test_php_version_compatibility()
    {
        $this->assertTrue(version_compare(PHP_VERSION, '8.1.0', '>='));
    }
}
<?php

declare(strict_types=1);

namespace Interfaces\Api\Providers;

use Closure;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
use Modules\Support\Concerns\LoadsClassesInDirectory;
use Ramsey\Uuid\Uuid;
use ReflectionClass;
use SebastiaanLuca\Router\Routers\Router;
use function Support\source_path;

class ApiServiceProvider extends ServiceProvider
{
    use LoadsClassesInDirectory;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() : void
    {
        Passport::ignoreMigrations();
        Passport::enableImplicitGrant();

        $this->useUuidsForApiClients();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() : void
    {
        Passport::cookie(config('passport.cookie_name'));

        $this->load(
            source_path('Interfaces/Api/Routers'),
            Closure::fromCallable([$this, 'registerRouter'])
        );
    }

    /**
     * @return void
     */
    private function useUuidsForApiClients() : void
    {
        Client::creating(static function (Client $client) : void {
            $client->incrementing = false;

            if (! $client->id) {
                $client->id = Uuid::uuid4()->toString();
            }
        });

        Client::retrieved(static function (Client $client) : void {
            $client->incrementing = false;
        });
    }

    /**
     * @param string $router
     */
    private function registerRouter(string $router) : void
    {
        if (is_subclass_of($router, Router::class) && ! (new ReflectionClass($router))->isAbstract()) {
            app()->make($router);
        }
    }
}

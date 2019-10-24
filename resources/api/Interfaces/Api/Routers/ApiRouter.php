<?php

declare(strict_types=1);

namespace Interfaces\Api\Routers;

use Laravel\Passport\Passport;
use Laravel\Passport\RouteRegistrar;
use SebastiaanLuca\Router\Routers\Router;

class ApiRouter extends Router
{
    /**
     * Map the routes.
     *
     * @return void
     */
    public function map() : void
    {
        $this->router->group(['prefix' => 'api', 'middleware' => 'api'], static function () : void {
            Passport::routes(static function (RouteRegistrar $router) {
                $router->forAccessTokens();
                $router->forTransientTokens();
                $router->forAuthorization();
                // $router->forClients();
                // $router->forPersonalAccessTokens();
            });
        });

        $this->router->group(['prefix' => 'api', 'middleware' => 'api'], function () : void {
            $this->router->get('ping', static function () : string {
                return 'Pong!';
            });
        });

        $this->router->group(['prefix' => 'api', 'middleware' => ['api', 'auth:api']], function () : void {
            $this->router->get('auth/ping', static function () : string {
                return 'Authenticated pong!';
            });
        });
    }
}

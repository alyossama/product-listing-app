<?php

declare(strict_types=1);

namespace App\Bootstrap;

use App\Configs\Config;
use App\Configs\DB;
use App\Configs\Router;
use App\Configs\View;

use App\Exceptions\RouteNotFoundException;

class App
{
    private static DB $db;
    protected Router $router;
    protected array $request;
    protected Config $config;

    public function __construct(Router $router,  array $request,  Config $config)
    {
        $this->router = $router;
        $this->request = $request;
        $this->config = $config;
        static::$db = new DB($config->db ?? []);
    }

    public static function db(): DB
    {
        return static::$db;
    }

    public function run()
    {
        try {
            echo $this->router->resolve($this->request['uri'], $this->request['method']);
        } catch (\Exception $e) {
            http_response_code(404);

            echo View::make('errors/404');
        }
    }
}

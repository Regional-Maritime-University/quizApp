<?php

namespace Core;

use Core\Base;

class Router
{

    private static $routes = [];

    public static function add($method, $uri, $controller)
    {
        self::$routes[] = [
            "method" => $method,
            "uri" => $uri,
            "controller" => $controller
        ];
    }

    public static function archive($uri, $controller)
    {
        self::add("ARCHIVE", $uri, $controller);
    }

    public static function delete($uri, $controller)
    {
        self::add("DELETE", $uri, $controller);
    }

    public static function get($uri, $controller)
    {
        self::add("GET", $uri, $controller);
    }

    public static function post($uri, $controller)
    {
        self::add("POST", $uri, $controller);
    }

    public static function patch($uri, $controller)
    {
        self::add("PATCH", $uri, $controller);
    }

    public static function put($uri, $controller)
    {
        self::add("PUT", $uri, $controller);
    }

    public static function route($uri, $method)
    {
        foreach (self::$routes as $route) {
            if ($route["uri"] === $uri && $route["method"] === strtoupper($method)) {
                return require Base::build_path($route["controller"]);
            }
        }
    }

    public static function abort($status = 404)
    {
        http_response_code($status);
        require Base::build_path("views/{$status}.php");
        die();
    }
}

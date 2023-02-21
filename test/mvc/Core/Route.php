<?php

namespace Core;

use Controllers\AuthController;
use Controllers\CategoryController;
use Controllers\IndexController;
use Controllers\ProductController;

class Route
{
    private array $routeMap = [
        'index'    => IndexController::class,
        'auth'     => AuthController::class,
        'category' => CategoryController::class,
        'product'  => ProductController::class,
    ];

    public function getClassName($controllerName): ?string {
        return $this->routeMap[$controllerName] ?? null;
    }
}
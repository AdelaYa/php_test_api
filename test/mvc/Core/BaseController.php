<?php

namespace Core;

class BaseController
{
    private string $defaultController = 'index';

    private string $defaultAction = 'index';


    public function processRequest(): void
    {
        $requestUriParams = explode('/', $_SERVER['REQUEST_URI']);

        $controllerName = $this->defaultController;
        if (!empty($requestUriParams[1])) {
            $controllerName = $requestUriParams[1];
        }

        $actionName = $this->defaultAction;
        if (!empty($requestUriParams[2])) {
            $actionParams = explode('?', $requestUriParams[2]);
            $actionName = $actionParams[0];
        }

//        if (!empty($requestUriParams[3])) {
//            $arrayUri = explode('?', $_SERVER['REQUEST_URI']);
//        }
//        if (str_contains($_SERVER['REQUEST_URI'], "?")) {
//            $params = explode('&', substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], "?") + 1));
//            foreach ($params as $param) {
//                if (str_contains($param, "=")) {
//                    $ar = explode("=", $param);
//                    $getparams[trim(htmlspecialchars($ar[0], ENT_QUOTES, 'UTF-8'))] = trim(htmlspecialchars($ar[1], ENT_QUOTES, 'UTF-8'));
//                }
//            }
//        }
//        $getParams = $getparams ?? [];

        $route = new Route();
        $className = $route->getClassName($controllerName);
        if (!$className) {
            $this->page404();
        }

        $controller = new $className;
        $method = $actionName . 'Action';

        if (!method_exists($controller, $method)) {
            $this->page404();
        }

        // render view
        /** @var BaseView $view */
        $view = $controller->$method();
//        $view = $controller->$method($getParams);
        $view->render();
    }

    public
    function output(string $layout, array $data = []): BaseView
    {
        return new BaseView($layout, $data);
    }

    public
    function page404(): void
    {
        (new BaseView('Errors/404'))->render();
        exit();
    }
}
<?php

namespace components;

class Router {

	private $routes;

	public function __construct() {

		$routesPath = ROOT.'/config/routes.php';
		$this->routes = include($routesPath);
	}

	/*
	 * Return request string
	 * @return string
	 */
	private function getURI() {
		if (!empty($_SERVER['REQUEST_URI'])) {
			return trim($_SERVER['REQUEST_URI'], '/');
		}
	}

	public function run() {
		// Get query string
		$uri = $this->getURI();
		$pageExist = false;
		// Check if such a query exists in routes.php
		foreach ($this->routes as $uriPattern => $path) {
			if (preg_match("~^{$uriPattern}~", $uri)) {
				// If there is a match than define needed controller and action
				$internalRoute = preg_replace("~^{$uriPattern}~", $path, $uri);
				$segments = explode('/', $internalRoute)	;


				$controllerName = array_shift($segments) . 'Controller';
				$controllerName = ucfirst($controllerName);

				$actionName = 'action' . ucfirst(array_shift($segments));

				$parameters = $segments;

				// Include controller class file
				$objectName = "controllers\\" . $controllerName;
				$controllerObject = new $objectName;
				$result = call_user_func_array(array($controllerObject, $actionName), $parameters);
				if ($result != null) {
					$pageExist = true;
					break;
				}
			}

		}

		if (!$pageExist) {
			$pageTitle = 'Page Not Found';
			require_once(ROOT . '/views/site/404.php');
		}

	}

}
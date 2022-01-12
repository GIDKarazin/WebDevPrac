<?php
	session_start();
	require_once 'config/db.php';
	require_once 'route/web.php';

	//define controller and action
	$controllerName = $_GET['controller'] ?? 'index';
	$actionName = $_GET['action'] ?? 'index';

	//Load routing object
	$routing = new Route();
	//Load model object
	$db = new Db();

	$routing->loadPage($db, $controllerName, $actionName);
<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\App([
	'settings' => [
	'displayErrorDetails' => true,
	]
	]);

$container = $app->getContainer();
$container['view'] = function($container){
	$view = new \Slim\View\Twig(__DIR__ . '/../resources/views',[
		'cache' => false,
		]);
	$view->addExtension(new \Slim\Views\TwigExtension(
		$container->router,
		$container->request->getUri()
		));
};

require __DIR__ . '/../app/routes.php';

// $app->get('/',function($request,$response){
//  return 'Home'	;
// });
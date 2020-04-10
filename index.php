<?php  
	require 'vendor/autoload.php';
	
	use App\Connection as Connection;
		
	try {
		Connection::get()->connect();
		
	} catch (\PDOException $e) {
		echo $e->getMessage();
	}

	$app = new \Slim\App([ 'settings' => [
        'displayErrorDetails' => true
    ]
]);

session_start();

$app->get('/', function ()
{
	$SisController = new App\controllers\SisController;
	$SisController->index();
});

$app->run();



















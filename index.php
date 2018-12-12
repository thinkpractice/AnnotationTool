<?php
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require 'vendor/autoload.php';

$router = new AltoRouter();
//$router->setBasePath('/AnnotationTool');

// setup routes here
$router->map('GET', '/', function() {
	require 'templates/main.php';
});

$router->map('GET', '/get_images/', function(){
    require __DIR__ . '/Images.php';
});

$router->map('GET', '/get_categories/', function(){
	require __DIR__ . '/Categories.php';
});

$router->map('POST', '/set_category/[i:imageId]/[i:categoryId]', function($imageId, $categoryId){
	echo "test" + $imageId;
	require __DIR__ . '/Categories.php';
});

// match current request url
$match = $router->match();

// call closure or throw 404 status
if( $match && is_callable( $match['target'] ) ) 
{
	call_user_func_array( $match['target'], $match['params'] ); 
} 
else 
{
	// no route was matched
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}


?>
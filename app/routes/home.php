<?php 

// When nav to the homepage('/') render it and names it as 'home'
$app->get('/', function() use ($app) {
	$app->render('home.php');
})->name('home');


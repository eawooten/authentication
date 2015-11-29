<?php

// Setting up namespacing
use Slim\Slim;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

use Noodlehaus\Config;
use RandomLib\Factory as RandomLib;

use eawooten\User\User;
use eawooten\Mail\Mailer;
use eawooten\Helpers\Hash;
use eawooten\Validation\Validator;

use eawooten\middleware\BeforeMiddleware;
use eawooten\middleware\CsrfMiddleware;

session_cache_limiter(false);
session_start();

//Turning on PHP Errors
ini_set('display_errors', 'On');

//Defining directory as INC_ROOT
define('INC_ROOT', dirname(__DIR__));

require INC_ROOT . '/vendor/autoload.php';

// New Slim view and configuration
$app = new Slim([
  'mode' => file_get_contents(INC_ROOT . '/mode.php'), //Specifies whether config is dev or production
  'view' => new Twig(), // Setting twig as view
  'templates.path' => INC_ROOT . '/app/views' // path to the views in the app
]);

// Creating middleware
$app->add(new BeforeMiddleware);
$app->add(new CsrfMiddleware);

// Setting Noodlehaus/config by loading mode.php as config file
$app->configureMode($app->config('mode'), function() use ($app) {
  $app->config = Config::load(INC_ROOT . "/app/config/{$app->mode}.php");
});

require 'database.php';
require 'filters.php';
require 'routes.php';

// Setting initial state as unauthenticated
$app->auth = false;

// Adding user model to the Slim container
$app->container->set('user', function() {
	return new User;
});

// Adding password hashing and passing config for it
$app->container->singleton('hash', function() use ($app) {
	return new Hash($app->config);
});

// Adding validation to form inputs
$app->container->singleton('validation', function() use ($app) {
	return new Validator($app->user, $app->hash, $app->auth);
});

// Adding email functionality
$app->container->singleton('mail', function() use ($app) {
	$mailer = new PHPMailer;

	// Mailer settings
	$mailer->isSMTP();
	$mailer->Host = $app->config->get('mail.host');
	$mailer->SMTPAuth = $app->config->get('mail.smtp_auth');
	$mailer->SMTPSecure = $app->config->get('mail.smtp_secure');
	$mailer->Port = $app->config->get('mail.port');
	$mailer->Username = $app->config->get('mail.username');
	$mailer->Password = $app->config->get('mail.password');

	$mailer->isHTML($app->config->get('mail.html'));

	return new Mailer($app->view, $mailer);	

});

// Adding randomlib random generator
$app->container->singleton('randomlib', function() {
	$factory = new RandomLib;
	return $factory->getMediumStrengthGenerator();
});

// Adding view to slim
$view = $app->view();

// Twig configuration
$view->parserOptions = [
	'debug' => $app->config->get('twit.debug')
];

// Adding parser extensions
$view->parserExtensions = [
	new TwigExtension
];
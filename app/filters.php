<?php 

$authenticationCheck = function($required) use ($app) {
	return function() use ($required, $app) {
		if ((!$app->auth && $required) || ($app->auth && !$required)) {
			$app->response->redirect($app->urlFor('home'));
		}
	};
};

$authenticated = function () use ($authenticationCheck) {
	// calls above function as requiring authentication
	return $authenticationCheck(true);
};

$guest = function () use ($authenticationCheck) {
	// calls above function as not requiring authentication
	return $authenticationCheck(false);
};

$admin = function() use ($app) {
	return function () use ($app) {
		if (!$app->auth || !$app->auth->isAdmin()) {
			$app->redirect($app->urlFor('home'));
		}
	};
};

?>
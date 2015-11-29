<?php 

use eawooten\User\UserPermission;

$app->get('/register', $guest(), function() use ($app) {
	$app->render('auth/register.php');
})->name('register');


$app->post('/register', $guest(), function () use ($app) {
	
	// Slim helpers to retrieve form data (used instead of $_POST)
	$request = $app->request;

	$email = $request->post('email');
	$username = $request->post('username');
	$password = $request->post('password');
	$password_confirm = $request->post('password_confirm');

	$v = $app->validation;

	$v->validate([
		'email' => [$email, 'required|email|uniqueEmail'],
		'username' => [$username, 'required|alnumDash|max(20)|uniqueUsername'],
		'password' => [$password, 'required|min(6)'],
		'password_confirm' => [$password_confirm, 'required|matches(password)']
	]);

	if ($v->passes()) {

		$identifier = $app->randomlib->generateString(128);

		$user = $app->user->create([
			'email' => $email,
			'username' => $username,
			'password' => $app->hash->password($password),
			'active' => false,
			'active_hash' => $app->hash->hash($identifier)
		]);

		// Creating a permissions record with default values
		$user->permissions()->create(UserPermission::$defaults);

		// Upon registration, send confirmation email
		$app->mail->send('email/auth/registered.php', ['user' => $user, 'identifier' => $identifier], function($message) use ($user) {
			$message->to($user->email);
			$message->subject('Thanks for registering.');
		});

		$app->flash('global', 'You have been registered.');
		return $app->response->redirect($app->urlFor('home'));
	}

	$app->render('auth/register.php', [
		'errors' => $v->errors(),
		'request' => $request
	]);

})->name('register.post');

?>
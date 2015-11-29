<?php namespace eawooten\Middleware;

use Slim\Middleware;

class BeforeMiddleware extends Middleware
{
	public function call()
	{
		// attaches the 'run' function to Slim's before middleware
		$this->app->hook('slim.before', [$this, 'run']);

		$this->next->call();
	}

	public function run()
	{
		// Checks is session with name provided in config is set which means the user is logged in
		if (isset($_SESSION[$this->app->config->get('auth.session')])) {
			// Queries database for user where 'id' is the session id and puts information in 'auth'
			$this->app->auth = $this->app->user->where('id', $_SESSION[$this->app->config->get('auth.session')])->first();
		}

		$this->checkRememberMe();

		$this->app->view()->appendData([
			'auth' => $this->app->auth,
			'baseUrl' => $this->app->config->get('app.url')
		]);
	}

	public function checkRememberMe()
	{
		// Check if cookie is available
		if ($this->app->getCookie($this->app->config->get('auth.remember')) && !$this->app->auth) {
			$data = $this->app->getCookie($this->app->config->get('auth.remember'));
			$credentials = explode('___', $data);

			// Check data is not empty and credentials have two elements
			if (empty(trim($data)) || count($credentials) !== 2) {
				$this->app->response->redirect($this->app->urlFor('home'));
			} else {

				$identifier = $credentials[0];
				$token = $this->app->hash->hash($credentials[1]);

				$user = $this->app->user
					->where('remember_identifier', $identifier)
					->first();

				if ($user) {
					if ($this->app->hash->hashCheck($token, $user->remember_token)) {
						$_SESSION[$this->app->config->get('auth.session')] = $user->id;
						$this->app->auth = $this->app->user->where('id', $user->id)->first();
					} else {
						$user->removeRememberCredentials();
					}
				}
			}
		}
	}
}



 ?>
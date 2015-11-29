<?php namespace eawooten\Helpers;

// Helper to hash user passwords
class Hash {
	protected $config;

	// Passes in the configuration settings for use
	public function __construct ($config) 
	{
		$this->config = $config;
	}

	// Creates password hash using config settings
	public function password($password) 
	{
		return password_hash(
			$password,
			$this->config->get('app.hash.algo'),
			['cost' => $this->config->get('app.hash.cost')]
			);
	}

	// verifies password against stored hash
	public function passwordCheck($password, $hash) 
	{
		return password_verify($password, $hash);
	}

	// hash method for non-password strings
	public function hash($input)
	{
		return hash('sha256', $input);
	}

	// hash verify for non-password strings
	public function hashCheck($known, $user)
	{
		return hash_equals($known, $user);
	}
} 

?>
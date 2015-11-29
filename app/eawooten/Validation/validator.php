<?php 

namespace eawooten\Validation;

use Violin\Violin;
use eawooten\User\User;
use eawooten\Helpers\Hash;

class Validator extends Violin
{
	protected $user;

	protected $hash;

	protected $auth;

	public function __construct(User $user, Hash $hash, $auth = null)
	{
		$this->user = $user;
		$this->hash = $hash;
		$this->auth = $auth;

		// adding message to display when email or username is not unique
		$this->addFieldMessages([
			'email' => [
				'uniqueEmail' => 'That email is already in use.'
			],
			'username' => [
				'uniqueUsername' => 'That username is already taken.'
			]
		]);

		$this->addRuleMessages([
			'matchesCurrentPassword' => 'That does not match your current password!'
		]);
	}

	public function validate_uniqueEmail($value, $input, $args)
	{
		// using query builder from Eloquent
		$user = $this->user->where('email', $value);

		// checking if user email is his own in profile updater
		if ($this->auth && $this->auth->email === $value) {
			return true;
		}

		return ! (bool) $user->count();
	}

	public function validate_uniqueUsername($value, $input, $args)
	{
		// using query builder from Eloquent
		return ! (bool) $this->user->where('username', $value)->count();
	}

	public function validate_matchesCurrentPassword($value, $input, $args)
	{
		if ($this->auth && $this->hash->passwordCheck($value, $this->auth->password)) {
			return true;
		}

		return false;
	}
}

?>
<?php namespace eawooten\User;

// this class creates a user model using Eloquent
use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent{
	//setting the table name
	protected $table = 'users';

	//defining editable fields since by default mass assignment is not possible
	protected $fillable = [
		'email',
		'username',
		'first_name',
		'last_name',
		'password',
		'active',
		'active_hash',
		'recover_hash',
		'remember_identifier',
		'remember_token',
	];

	public function getFullName()
	{
		if (!$this->first_name || !$this->last_name) {
			return null;
		}

		return "{$this->first_name} {$this->last_name}";
	}

	public function getFullNameOrUsername ()
	{
		return $this->getFullName() ?: $this->username;
	}

	public function activateAccount()
	{
		$this->update([
			'active' => true,
			'active_hash' => null
		]);
	}

	public function getAvatarUrl($options = [])
	{
		$size = isset($options['size']) ? $options['size']: 45;
		return 'http://www.gravatar.com/avatar/' . md5($this->email) . '?s=' . $size . '&d=mm';
	}

	public function updateRememberCredentials($identifier, $token)
	{
		$this->update([
			'remember_identifier' => $identifier,
			'remember_token' => $token
		]);
	}

	public function removeRememberCredentials()
	{
		$this->updateRememberCredentials(null, null);
	}

	// checks database for permissions
	public function hasPermission($permission)
	{
		return (bool) $this->permissions->{$permission};
	}

	// helper method to check permissions by calling above method
	public function isAdmin()
	{
		return $this->hasPermission('is_admin');
	}

	// relates the user table to the users_permissions table using Elaquent
	public function permissions()
	{
		return $this->hasOne('eawooten\User\UserPermission', 'user_id');
	}
}
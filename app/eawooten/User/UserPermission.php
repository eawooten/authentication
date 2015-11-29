<?php namespace eawooten\User;

// this classs creates a user permissions model using Eloquent
use Illuminate\Database\Eloquent\Model as Eloquent;

class UserPermission extends Eloquent
{
	protected $table = 'users_permissions';

	protected $fillable = [
		'is_admin'
	];

	public static $defaults = [
		'is_admin' => false
	];
}

?>
{# //extending default view with register content #}
{% extends 'templates/default.php' %}

{# //defining content to replace block in default template #}
{% block title %}Register{% endblock %}

{% block content %}
	<form action="{{ urlFor('register.post') }}" method="post" autocomplete="off">
		<div>
			<label for="email">Email</label>
			<input type="text" name="email" id="email" {% if request.post('email') %} value="{{ request.post('email') }}" {% endif %}>
			{# //checks for errors with this field and if present outputs them #}
			{% if errors.has('email') %}{{ errors.first('email') }}{% endif %}

		</div>
		<div>
			<label for="username">Username</label>
			<input type="text" name="username" id="username" {% if request.post('username') %} value="{{ request.post('username') }}" {% endif %}>
			{% if errors.has('username') %}{{ errors.first('username') }}{% endif %}
		</div>
		<div>
			<label for="password">Password</label>
			<input type="password" name="password" id="password">
			{% if errors.has('password_confirm') %}{{ errors.first('password_confirm') }}{% endif %}
		</div>
		<div>
			<label for="password_confirm">Password Confirm</label>
			<input type="password" name="password_confirm" id="password_confirm">
			{% if errors.has('password_confirm') %}{{ errors.first('password_confirm') }}{% endif %}
		</div>
		<div>
			<input type="submit" value="Register">
		</div>
		
		<input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">
	</form>
{% endblock %}
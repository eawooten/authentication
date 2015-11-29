{# //extending default view with all users content #}
{% extends 'templates/default.php' %}

{# //defining content to replace block in default template #}
{% block title %}All Users{% endblock %}

{% block content %}
	<h2>All users</h2>

	{% if users is empty %}
		<p>No registered users.</p>
	{% else %}
		{% for user in users %}
			<div class="user">
				<a href="{{ urlFor('user.profile', {username: user.username}) }}">{{ user.username }}</a>
				{% if user.getFullName %}
					({{ user.getFullName }})
				{% endif %}
				{% if user.isAdmin %}
					(Admin)
				{% endif %}
			</div>
		{% endfor %}
	{% endif %}
{% endblock %}
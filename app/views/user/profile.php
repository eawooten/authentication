{# //extending default view with profile content #}
{% extends 'templates/default.php' %}

{# //defining content to replace block in default template #}
{% block title %}{{ user.getFullNameOrUsername }}{% endblock %}

{% block content %}
	<h2>{{ user.username }}</h2>
	<img src="{{ user.getAvatarUrl({size: 30}) }}" alt="Profile picture for {{ user.getFullNameOrUsername }}">
	<dl>
		{% if user.getFullName %}
			<dt>Full name</dt>
			<dd>{{ user.getFullName }}</dd>
		{% endif %}

		<dt>Email</dt>
		<dd>{{ user.email }}</dd>
	</dl>
{% endblock %}
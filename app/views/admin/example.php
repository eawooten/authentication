{# //extending default view with admin area content #}
{% extends 'templates/default.php' %}

{# //defining content to replace block in default template #}
{% block title %}Admin{% endblock %}

{% block content %}
	Admin example
{% endblock %}
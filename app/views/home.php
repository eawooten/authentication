{# //extending default view with hompage content #}
{% extends 'templates/default.php' %}

{# //defining content to replace block in default template #}
{% block title %}Home{% endblock %}

{% block content %}
	Home
{% endblock %}
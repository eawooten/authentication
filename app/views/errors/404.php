{# //extending default view with 404 page content #}
{% extends 'templates/default.php' %}

{# //defining content to replace block in default template #}
{% block title %}404{% endblock %}

{% block content %}
	That page cannot be found.
{% endblock %}
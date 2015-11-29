{# //default view for page template #}
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	{# //pulling in dynamic page title from twig #}
	<title>Website | {% block title %}{% endblock %}</title>
</head>
<body>
	{% include 'templates/partials/messages.php' %}
	{% include 'templates/partials/navigation.php' %}
	{% block content %}{% endblock %}
</body>
</html>
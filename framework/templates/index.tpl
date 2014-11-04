<!DOCTYPE html>
<html class="no-js">
    <head>
        <title>{{ PAGE_TITLE }}</title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        
        <meta name="author" content="{{ PAGE_AUTHOR }}">
        <meta name="keywords" content="{{ META_KEYWORDS }}">
        <meta name="description" content="{{ PAGE_DESCRIPTION }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    </head>
    <body>
        {% include 'browsehappy.tpl' %}

        <div class="container">
        	{% if REQUEST_PAGE == 'index' %}
        		{% include ['welcome.tpl', 'error/notfound.tpl'] %}
        	{% else %}
        		{% include ['include/' ~ REQUEST_PAGE ~ '.tpl', 'error/notfound.tpl'] %}
        	{% endif %}
		</div>

        {% include 'footer.tpl' %}
    </body>
</html>
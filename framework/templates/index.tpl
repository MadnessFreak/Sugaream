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
		  <h1>It work's!</h1>
		  <div>
		  	<p>Request</p>
		  	<ul>
		  		<li>REQUEST_PAGE: {{ REQUEST_PAGE }}</li>
		  		<li>REQUEST_ACTION: {{ REQUEST_ACTION }}</li>
		  		<li>REQUEST_VALUE: {{ REQUEST_VALUE }}</li>
		  		<li>REQUEST_TYPE: {{ REQUEST_TYPE }}</li>
		  	</ul>
		  </div>
		  <div>
		  	<p>Array GET</p>
		  	<ul>
		  	{% for key, item in GET %}
		  		<li>{{ key }}: {{ item }}</li>
		  	{% endfor %}
		  	</ul>
		  </div>
		  <div>
		  	<p>Array POST</p>
		  	<ul>
		  	{% for key, item in POST %}
		  		<li>{{ key }}: {{ item }}</li>
		  	{% endfor %}
		  	</ul>
		  </div>
		  <div>
		  	<p>Array SERVER</p>
		  	<ul>
		  	{% for key, item in SERVER %}
		  		<li>{{ key }}: {{ item }}</li>
		  	{% endfor %}
		  	</ul>
		  </div>
		</div>

        {% include 'footer.tpl' %}
    </body>
</html>

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

        <link rel="icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />

        <link href="/css/common.css" rel="stylesheet">
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/font-awesome.min.css" rel="stylesheet">
    </head>
    <body>
        {% include 'browsehappy.tpl' %}

        {% include 'header.tpl' %}

        {% include 'breadcrumb.tpl' %}

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
            	{% if REQUEST_PAGE == 'index' %}
            		{% include ['welcome.tpl', 'error/notfound.tpl'] %}
            	{% else %}
            		{% include ['include/' ~ REQUEST_PAGE ~ '.tpl', 'error/notfound.tpl'] %}
            	{% endif %}
                </div>
            </div>
		</div>

        {% include 'footer.tpl' %}
    </body>
</html>
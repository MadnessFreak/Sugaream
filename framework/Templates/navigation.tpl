<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">{{ PAGE_TITLE }}</a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        {% for nav in navigation %}
        <li {{ nav.navLink == REQUEST_PAGE ? 'class="active"' : '' }}><a href="/{{ nav.navLink }}">{{ nav.navName }}</a></li>
        {% endfor %}
      </ul>
      <ul class="nav navbar-nav navbar-right">
        {% if SESSION.loggedIn %}
          <li><a href="/logout">Logout</a></li>
        {% else %}
          <li><a href="/login">Login</a></li>
        {% endif %}
      </ul>
    </div>
  </div>
</nav>

{% if REQUEST_PAGE == 'index' and ENABLE_BREADCRUM_ON_INDEX == false %}
  {# HIDE BREADCRUM #}
{% else %}
  {% include 'breadcrumb.tpl' %}
{% endif %}

{% if ALERT %}
<div class="container" id="alert">
  <div class="alert alert-dismissable alert-{{ ALERT.type }}">
    {% if ALERT.closeable %}<button type="button" class="close" data-dismiss="alert">×</button>{% endif %}
    {% if ALERT.title %}<h4>{{ ALERT.title }}</h4>{% endif %}
    <p>{{ ALERT.message|raw }}</p>
  </div>
</div>
{% endif %}
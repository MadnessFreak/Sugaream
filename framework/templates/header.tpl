<div class="navbar navbar-default bs-docs-nav" id="top" role="banner">
  <div class="container">
    <div class="navbar-header">
      <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="/" class="navbar-brand">{{ PAGE_TITLE }}</a>
    </div>
    <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
      <ul class="nav navbar-nav">
        {% for nav in navigation %}
        <li {{ nav.navLink starts with REQUEST_PAGE ? 'class="active"':"" }}><a href="/{{ nav.navLink }}">{{ nav.navName }}</a></li>
        {% endfor %}
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="https://github.com/MadnessFreak/Sugaream" target="_blank">GitHub</a></li>
      </ul>
    </nav>
  </div>
</div>
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
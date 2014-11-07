<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<ul class="breadcrumb">
				<li><a href="/dashboard">Dashboard</a></li>
				{% if REQUEST_ACTION != '' %}
				<li><a href="/{{ REQUEST_PAGE }}">{{ REQUEST_PAGE|capitalize }}</a></li>
				<li class="active">{{ REQUEST_ACTION|capitalize }}</li>
				{% else %}{# WITHOUT ACTION #}
				<li class="active">{{ REQUEST_PAGE|capitalize }}</li>
				{% endif %}
			</ul>
		</div>
	</div>
</div>
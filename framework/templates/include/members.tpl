{% if REQUEST_ACTION == '' %}
<h1>Members</h1>
<table class="table table-striped">
	<thead>
		<tr>
			<th width="50">#</th>
			<th>Username</th>
			<th width="60">Avatar</th>
			<th>Email</th>
			<th width="150">Registration Date</th>
		</tr>
	</thead>
	<tbody>
		{% for member in members %}
		<tr>
			<td>{{ member.userID }}</td>
			<td>
				<a href="/members/profile/{{ member.username }}">{{ member.username }}</a>
				<span class="label label-success">Online</span>
			</td>
			<td><img src="/images/avatar/default.jpg" alt="Avatar" style="width:50px; height:50px;"></td>
			<td>{{ member.email }}</td>
			<td>{{ member.registrationDate|date("F m, Y") }}</td>
		</tr>
		{% endfor %}
	</tbody>
</table>
{% elseif REQUEST_ACTION == 'profile' %}
	<h1>Members > Profile</h1>
	{% if member == false %}
	<p>Looks like there is no user with the nickname '{{ REQUEST_VALUE }}'.</p>
	{% else %}
	<div class="container">
		<div class="row">
			<div class="col-sm-2"><img src="/images/avatar/default.jpg" alt="Avatar" class="img-thumbnail"></div>
			<div class="col-sm-4">
				<h3>{{ member.username }}&nbsp;&nbsp;<span class="label label-success">Online</span></h3>
				<table id="member-profile">
					<tr>
						<td>Email</td>
						<td>{{ member.email }}</td>
					</tr>
					<tr>
						<td>Account Status</td>
						<td>{{ member.banned ? 'Banned' : 'Active' }}</td>
					</tr>
					<tr>
						<td>Last Activity</td>
						<td>{{ member.lastActivityTime|date("F m, Y H:i a") }}</td>
					</tr>
					<tr>
						<td>Registration Date</td>
						<td>{{ member.registrationDate|date("F m, Y") }}</td>
					</tr>
				</table>
			</div>
		</div>
	</div>

	<style type="text/css">
	#member-profile > tbody > tr > td:nth-child(1) {
		width: 170px;
	}
	</style>
	{% endif %}
{% endif %}
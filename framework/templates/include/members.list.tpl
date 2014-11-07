<table class="table table-striped" id="memberList">
	<thead>
		<tr>
			<th width="50">#</th>
			<th width="60">Avatar</th>
			<th>Username</th>
			<th>Email</th>
			<th width="200">Last Activity</th>
			<th width="200">Registration Date</th>
		</tr>
	</thead>
	<tbody>
		{% for member in members %}
		<tr>
			<td>{{ member.userID }}</td>
			<td><img src="/images/avatar/default.png" alt="Avatar" class="online sm"></td>
			<td>
				<a href="/members/profile/{{ member.username }}">{{ member.username }}</a>
				<span class="label label-success">Online{{ member.wtf }}</span><br>
				<small>{{ member.group.userOnlineMarking|format(member.group.groupName)|raw }}</small>
			</td>
			<td>{{ member.email }}</td>
			<td>{{ member.lastActivityTime|date("F m, Y") }}</td>
			<td>{{ member.registrationDate|date("F m, Y") }}</td>
		</tr>
		{% endfor %}
	</tbody>
</table>
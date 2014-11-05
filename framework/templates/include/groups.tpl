<h1>Groups</h1>
<table class="table table-striped">
	<thead>
		<tr>
			<th width="50">#</th>
			<th>Name</th>
			<th>Priority</th>
		</tr>
	</thead>
	<tbody>
		{% for group in groups %}
		<tr>
			<td>{{ group.groupID }}</td>
			<td>{{ group.groupName }}</td>
			<td>{{ group.priority }}</td>
		</tr>
		{% endfor %}
	</tbody>
</table>
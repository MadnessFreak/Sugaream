{% if REQUEST_ACTION is empty %}
	{% include 'include/members.list.tpl' %}
{% elseif REQUEST_ACTION == 'profile' %}
	{% if member == false %}
		{% include 'illegalLink.tpl' %}
	{% else %}
		{% include 'include/members.profile.tpl' %}
	{% endif %}
{% else %}
	{% include 'illegalLink.tpl' %}
{% endif %}
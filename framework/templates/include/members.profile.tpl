<div class="row">
	<div class="col-sm-12">
		<div class="well">
			<div class="row">

				<div class="col-sm-12">
					<div id="head">
						<div class="action">
							<button type="button" class="btn btn-sm btn-primary" title="Follow {{ member.username }}"><i class="fa fa-check"></i> Follow</button>
							<button type="button" class="btn btn-sm btn-primary" title="Add {{ member.username }} as friend"><i class="fa fa-link"></i> Connect</button>
						</div>
						<div class="cover">
							<img src="/images/cover/flow.jpg" alt="">
							<!-- flow image by http://www.flickr.com/photos/salman2000/ -->
						</div>
					</div>
				</div>

				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-3 profile-pic">
							<img src="/images/avatar/sunny-big.png">
							<div class="padding-10">
								<h4 class="font-md"><strong>1,543</strong><br><small>Followers</small></h4>
								<h4 class="font-md"><strong>419</strong><br><small>Connections</small></h4>
							</div>
						</div>
						<div class="col-sm-6">
							<h1 style="margin-bottom:0;">{{ member.username }}</h1>
							<h4 style="margin-top:0; color: gray;">{{ member.group.groupName }}</h4>

							<ul class="list-unstyled">
								<li>
									<p class="text-muted">
										<i class="fa fa-envelope"></i>&nbsp;&nbsp;Email: <a href="mailto:{{ member.email }}">{{ member.email }}</a>
									</p>
								</li>
								<li>
									<p class="text-muted">
										<i class="fa fa-check-circle"></i>&nbsp;&nbsp;Account status: <span class="txt-color-darken">{{ member.banned ? 'Banned' : 'Active' }}</span>
									</p>
								</li>
								<li>
									<p class="text-muted">
										<i class="fa fa-calendar"></i>&nbsp;&nbsp;Last activity: <span class="txt-color-darken">{{ member.lastActivityTime|date("F m, Y H:i a") }}</span>
									</p>
								</li>
								<li>
									<p class="text-muted">
										<i class="fa fa-calendar-o"></i>&nbsp;&nbsp;Registration date: <span class="txt-color-darken">{{ member.registrationDate|date("F m, Y") }}</span>
									</p>
								</li>
							</ul>
							<br>
							<p class="font-md">About</p>
							<p>Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere.</p>
						</div>
						<div class="col-sm-3">
							<h1><small>Friends</small></h1>
							<ul class="list-inline friends-list">
								<li><img src="/images/avatar/1.png" alt="friend-1">
								</li>
								<li><img src="/images/avatar/2.png" alt="friend-2">
								</li>
								<li><img src="/images/avatar/3.png" alt="friend-3">
								</li>
								<li><img src="/images/avatar/4.png" alt="friend-4">
								</li>
								<li><img src="/images/avatar/5.png" alt="friend-5">
								</li>
								<li><img src="/images/avatar/male.png" alt="friend-6">
								</li>
								<li>
									<a href="javascript:void(0);">413 more</a>
								</li>
							</ul>

							<h1><small>Recent visitors</small></h1>
							<ul class="list-inline friends-list">
								<li><img src="/images/avatar/male.png" alt="friend-1">
								</li>
								<li><img src="/images/avatar/female.png" alt="friend-2">
								</li>
								<li><img src="/images/avatar/female.png" alt="friend-3">
								</li>
							</ul>
						</div> <!-- col-sm-3 -->
					</div> <!-- row -->
				</div> <!-- col-sm-12 -->
				
			</div>  <!-- row -->
		</div>  <!-- well -->
	</div>  <!-- col-sm-12 -->
</div> <!-- row -->
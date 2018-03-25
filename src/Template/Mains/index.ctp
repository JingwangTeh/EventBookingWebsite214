<?= $this->Html->css('cssMainPage') ?>
<?= $this->assign('title', 'Main Page'); ?>

<!-- Main Page Content -->
<div class="container-fluid content">

	<!-- Project Introduction -->
	<div class="row content_section" id="intro_section">
	
		<div>
			<div class="col-xs-12" id="intro_content">
			
				<!-- Title -->
				<div class="section_title" id="intro_title">
					<h1>What is WEBS?</h1>
					<hr/>
				</div>
				
				<!-- Description - What is it? -->
				<div class="section_description" id="intro_description">
					<p>
						The system is contracted by the CIO of UOW to develop an event booking system for UOW staff and students. <br/>
						The event provides the following features:
					</p>
				</div>
				
				<!-- Features - What does it provide? -->
				<div id="intro_features">
					<div class="row">
					
						<div class="col-xs-6 intro_feature">
							<div>
								<h2>Event Creation and Management</h2>
								<p>
									A system user can create and launch a new event, or adjust the price, 
									dates/sessions, promotional codes, capacities, etc. on an existing event.
								</p>
							</div>
						</div>
						
						<div class="col-xs-6 intro_feature">
							<div>
								<h2>Event Booking</h2>
								<p>
									A system user can view the list of events, make a booking, 
									and modify or cancel an existing booking.
								</p>
							</div>
						</div>
						
					</div>
				</div>
				
			</div>
		</div>
		
	</div>
	
	<!-- Intro Summary -->
	<div class="row">
		<div class="col-xs-12 vertical_center" id="intro_summary">
			<p>
				An event booking system for UOW staff and students.
			</p>
		</div>
	</div>
	
	<!-- Project Platform -->
	<div class="row content_section" id="platform_section">
	
		<div>
			<div class="col-xs-12" id="platform_content">
			
				<!-- Title -->
				<div class="section_title" id="platform_title">
					<h1>Tools and technologies used to implement WEBS</h1>
					<hr/>
				</div>
				
				<!-- Description - Which Platform? -->
				<div class="section_description" id="platform_description">
					<p>
						WEBS is built for the Web with CakePHP Framework. <br/>
						The XAMPP bundle, which provides the Apache Web Server, PHP, and MySQL is used.
					</p>
				</div>
				
				<!-- Media -->
				<div id="platform_media">
					<div class="row">
						<div class="col-md-4 col-xs-12 vertical_center platform_media_items">
							<?= $this->Html->image('mainPage/Image_Xampp.jpg', array('class' => 'img-responsive', 'alt' => 'XamppImage')); ?>
						</div>
						<div class="col-md-4 col-xs-12 vertical_center platform_media_items">
							<?= $this->Html->image('mainPage/Image_Cake.png', array('class' => 'img-responsive', 'alt' => 'CakePhpImage')); ?>
						</div>
					</div>
				</div>

			</div>
		</div>
		
	</div>

	<!-- Platform Summary -->
	<div class="row">
		<div class="col-xs-12 vertical_center" id="platform_summary">
			<p>
				Built for the Web with CakePHP Framework.
			</p>
		</div>
	</div>
	
	<!-- Project Team -->
	<div class="row content_section" id="team_section">
	
		<div>
			<div class="col-xs-12" id="team_content">
			
				<!-- Title -->
				<div class="section_title" id="team_title">
					<h1>Who We Are</h1>
					<hr/>
				</div>
				
				<!-- Description - Who is involved? -->
				<div class="section_description" id="team_media">
					<div class="row">
						<div class="col-md-3 col-xs-12 team_media_members">
							<?= $this->Html->image('mainPage/profile_placeholder_circle.jpg', array('class' => 'img-responsive', 'alt' => 'profile_placeholder')); ?>
							<p>
								Aiden Andrews<br/>
								<span class="team_media_members_role">Developer</span>
							</p>
						</div>
						<div class="col-md-3 col-xs-12 team_media_members">
							<?= $this->Html->image('mainPage/profile_placeholder_circle.jpg', array('class' => 'img-responsive', 'alt' => 'profile_placeholder')); ?>
							<p>
								James-Patrick Riley<br/>
								<span class="team_media_members_role">Developer</span>
							</p>
						</div>
						<div class="col-md-3 col-xs-12 team_media_members">
							<?= $this->Html->image('mainPage/profile_placeholder_circle.jpg', array('class' => 'img-responsive', 'alt' => 'profile_placeholder')); ?>
							<p>
								Jingwang Teh<br/>
								<span class="team_media_members_role">Developer</span>
							</p>
						</div>
						<div class="col-md-3 col-xs-12 team_media_members">
							<?= $this->Html->image('mainPage/profile_placeholder_circle.jpg', array('class' => 'img-responsive', 'alt' => 'profile_placeholder')); ?>
							<p>
								Zac Munro<br/>
								<span class="team_media_members_role">Developer</span>
							</p>
						</div>
					</div>
				</div>
				
			</div>
		</div>
		
	</div>
	
</div>
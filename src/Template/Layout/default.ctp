<?php
	$titleDescription = 'EBS';
?>

<!DOCTYPE html>
<html>
<head>
	<!-- UTF-8 Charset and viewport meta for bootstrap -->
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- Title -->
    <title>
        <?= $titleDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

	<!-- JQuery 3.2.0 Latest Compiled Javascript through CDN -->
	<?= $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js'); ?>

	<!-- JQuery UI (Theme, JQuery, JQuery UI) -->
	<?= $this->Html->css('https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css') ?>
	<?= $this->Html->script('https://code.jquery.com/jquery-3.2.1.js'); ?>
	<?= $this->Html->script('https://code.jquery.com/ui/1.12.1/jquery-ui.js'); ?>
	
	<!-- JQuery Plugin - Datetimepicker -->
	<?= $this->Html->css('jquery.datetimepicker.css') ?>
	<?= $this->Html->script('jquery.datetimepicker.full.min.js'); ?>

	<!-- Bootstrap 3.3.7 Latest Compiled and Minified CSS and JavaScript through CDN -->
	<?= $this->Html->css('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css') ?>
	<?= $this->Html->script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js') ?>

	<!-- Project CSS -->
	<?= $this->Html->css('defaultCommons') ?>
	
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
	
</head>
<body>

	<!-- Header -->
	<div class="header">
		<div class="container-fluid">
			<div class="header_content">
			
				<!-- Header Title -->
				<div class="header_title">
					<a href="/">
						Wollongong Event Booking System <br/>(WEBS)
					</a>
				</div>
			
				<!-- Header Navigation -->
				<div class="header_shortcuts">
					<p>
						<?php
							// Display Create Event
							echo $this->Html->link(
								'Browse Events',
								 array('controller' => 'Events', 'action' => 'browse')
							);
							
							echo " | ";
							
							// Display Create Event
							echo $this->Html->link(
								'Create Events',
								 array('controller' => 'Events', 'action' => 'add')
							);
							
							echo " | ";
							
							// Display Home & Logout if user is logged in
							if ($this->request->session()->read('Auth.User'))
							{
								
								echo $this->Html->link(
									 $this->request->session()->read('Auth.User.username'),
									 array('controller' => 'Users', 'action' => 'home')
								);
								
								echo " | ";
							
								echo $this->Html->link(
									 'Logout',
									 array('controller' => 'Users', 'action' => 'logout')
								);
							}
							// Display Login & Register if user is NOT logged in
							else
							{
								echo $this->Html->link(
									 'Login',
									 array('controller' => 'Users', 'action' => 'login')
								);

								echo " | ";
								
								echo $this->Html->link('Register',
									 array('controller' => 'Users', 'action' => 'register')
								);
							}
						?>
					</p>
				</div>
				
			</div>
		</div>
	</div>
	
	
	
	<!-- Content -->
	<?= $this->fetch('content') ?>
	
	
	
	<!-- Footer -->
	<div class="footer">
		<div class="container-fluid">
			<div class="footer_content">
			
				<!-- Footer Links -->
				<div class="footer_links">
					<p>
						
					</p>
				</div>
			
				<!-- Footer Description -->
				<div class="footer_description">
					<p>
						WEBS has been implemented as a group assignment for CSIT 214 IT Project Management
					</p>
				</div>
				
				<!-- Footer Copyright -->
				<div class="footer_copyright">
					<p>
						&copy; 2017 All Rights Reserved.
					</p>
				</div>
				
				
			</div>
		</div>
    </div>
	
	
	
</body>
</html>

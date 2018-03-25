<?= $this->Html->css('cssUserHome') ?>
<?= $this->assign('title', 'User Home Page'); ?>

<div class="container-fluid user_home">
	<div class="row user_home_section">
		<div>
			<div class="col-xs-12">
			
				<!-- Row Starts -->
				<div class="row user_home_content">
				
					<div class="col-md-3 col-xs-12 user_home_left">
						<!-- User Home Categories -->
						<div>

							<ul class="user_home_categories">
								<li><?= 
									$this->Html->Link('User Profile', 
													 ['controller' => 'Users', 'action' => 'home'],
													 ['class'=>'current_category']); 
								?></li>
								<li>
									<?= $this->Html->Link('Manage Events', 
													 ['controller' => 'Users', 'action' => 'event']); 
								?></li>
								<li>
									<?= $this->Html->Link('Manage Bookings', 
													 ['controller' => 'Users', 'action' => 'booking']); 
								?></li>
							</ul>
							
						</div>
					</div>
					
					<div class="col-md-9 col-xs-12 user_home_right">
						<div>
							
							<div class="user_home_profile">
								<!-- Title -->
								<div class="user_home_title">
									<h1>User Profile</h1>
									<?=$this->Html->Link('Edit', ['controller' => 'Users', 'action' => 'edit'], ['class' => 'CreateBtn']); ?>
								</div>
								
								<!-- Form Separator -->
								<div class="div_separator">
								</div>
								
								<!-- Content -->
								<div class="user_home_profile_content">
								<?php
									echo "<div>";
										echo "<h2>"	, "Account email address"	, "</h2>";
										echo "<p>"	, $userList->email			, "<br/><br/>";
										echo "<h2>"	, "Username"				, "</h2>";
										echo "<p>"	, $userList->username		, "<br/><br/>";
									echo "</div>";
								?>
								</div>
								<!-- End of Content -->
							</div>
							
						</div>
					</div>
					
				</div>
				<!-- End of Row -->
				
			</div>
		</div>
	</div>
</div>

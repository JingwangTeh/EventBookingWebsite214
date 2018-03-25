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
													 ['controller' => 'Users', 'action' => 'home']); 
								?></li>
								<li>
									<?= $this->Html->Link('Manage Events', 
													 ['controller' => 'Users', 'action' => 'event'],
													 ['class'=>'current_category']); 
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
							
							<div class="user_home_events">
								<!-- Title -->
								<div class="user_home_title">
									<h1>List of Events (Hosting)</h1>
									<?= $this->Flash->render('eventCreationSuccess') ?>
									<?= $this->Flash->render('eventUpdateSuccess') ?>
								</div>
								
								<!-- Form Separator -->
								<div class="div_separator">
									<hr/>
								</div>
								
								<!-- Content -->
								<div class="user_home_event_content">
								<?php
									foreach ($eventList as $event)
									{
										echo "<div>";
											echo "<h2>" ,
												$this->Html->Link($event->eventTitle, [
																	'controller' => 'Events', 'action' => 'view',
																	'?' => ['eventID' => $event->eventID]
																]), 
												"</h2>";
											echo "<p>"	, $this->Time->format($event->eventStartDate, "EEEE F MMMM YYYY 'at' h:00 a"), "</p>";
											echo "<p><b>capacity: </b>", $event->eventCurrentCapacity." / ", $event->eventTotalCapacity."</p>";
											echo $this->Html->Link('Edit', [
																   'controller' => 'Events', 'action' => 'edit',
																   '?' => ['eventID' => $event->eventID]
																  ]);
											echo $this->Html->Link('Manage', [
																   'controller' => 'Events', 'action' => 'manage',
																   '?' => ['eventID' => $event->eventID]
																  ]);
										echo "</div>";
									}
								?>
								</div>
								<!-- End of Content -->
								
								<!-- Pagination -->
								<?php echo "<div class='paginationDiv'>", $this->Paginator->numbers(), "</div>"; ?>
							</div>
							
						</div>
					</div>
					
				</div>
				<!-- End of Row -->
				
			</div>
		</div>
	</div>
</div>

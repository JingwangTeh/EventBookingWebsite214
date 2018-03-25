<?= $this->Html->css('cssUserHome') ?>
<?= $this->assign('title', 'User Home Page'); ?>


<script type = "text/javascript">
	$ = function(id) {
	  return document.getElementById(id);
	}
	
	var show = function(id) {
		$(id).style.display ='block';
	}
	var hide = function(id) {
		$(id).style.display ='none';
	}
</script>

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
													 ['controller' => 'Users', 'action' => 'event']); 
								?></li>
								<li>
									<?= $this->Html->Link('Manage Bookings', 
													 ['controller' => 'Users', 'action' => 'booking'],
													 ['class'=>'current_category']); 
								?></li>
							</ul>
							
						</div>
					</div>
					
					<div class="col-md-9 col-xs-12 user_home_right">
						<div>
							
							<div class="user_home_bookings">
								<!-- Title -->
								<div class="user_home_title">
									<h1>List of Bookings</h1>
									<?= $this->Flash->render('eventBookingSuccess') ?>
									<?= $this->Flash->render('eventBookingFailed') ?>
									<?= $this->Flash->render('eventWithdrawSuccess') ?>
									<?= $this->Flash->render('bookingUpdateSuccess') ?>
									<?= $this->Flash->render('bookingUpdateFailed') ?>
								</div>
								
								<!-- Form Separator -->
								<div class="div_separator">
									<hr/>
								</div>
								
								<!-- Content -->
								<div class="user_home_booking_content">
								<?php
									foreach ($bookingList as $booking):
										if ($booking->Events['eventStatus'] && !$booking->Events['eventMarkForDeletion']) { echo "<div class='eventActive'>"; }
										else { echo "<div class='eventInactive'>"; }
											echo "<p>"	, $this->Time->format($booking->Events['eventStartDate'], "EEEE F MMMM YYYY 'at' h:00 a")	, "</p>";
											echo "<h2>"; 
											echo $this->Html->Link($booking->Events['eventTitle'], [
															   'controller' => 'Events', 'action' => 'view',
															   '?' => ['eventID' => $booking->Events['eventID']]
															  ]);
											echo "</h2>";
											echo "<p>"	, "<b>Location: </b>", $booking->Events['eventLocation']	, "</p>";
											echo "<p>"	, "<b>Discount: </b>", (empty($booking->currentDiscountPercent)? '0':$booking->currentDiscountPercent), "%</p>";
											
											
											echo $this->Form->button('Edit Booking', ['onclick'=>'show(\'updateEvent'.$booking->Events['eventID'].'\')']);
											
											// Edit Bookings Popup
											echo "<div class='eventUpdatePopup' id='updateEvent".$booking->Events['eventID']."'>";
											echo $this->Form->create("Bookings", array('url'=>'/bookings/update'));
												echo $this->Form->control('promoCode', ['type'=>'text', 'label'=>'', 'placeholder' => 'Edit Promo Code.']);
												echo $this->Form->hidden('eventID', ['value' => $booking->Events['eventID']]);
												
												echo $this->Form->button('Submit', ['class'=>'CreateBtn']);
											echo $this->Form->end();
											echo $this->Form->button('Cancel', ['onclick'=>'hide(\'updateEvent'.$booking->Events['eventID'].'\')', 'class'=>'CreateBtn']);
											echo "</div>";
										echo "</div>";
									endforeach;
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

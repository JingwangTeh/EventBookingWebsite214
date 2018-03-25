<?= $this->Html->css('cssEventCreationForm') ?>
<?= $this->assign('title', 'Event Management'); ?>


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

<div class="container-fluid form_container">
	<div class="row form_section">
		<div>
			<div class="col-xs-12 vertical_center" id="form_details">
				
				<!-- Form Title -->
				<div id="form_details_title">
					<h1 id="">Event Details</h1>
					
					<?php
						if (empty($booking))
						{
							
							if (empty($event->eventPromoCode) || empty($event->eventDiscountPercent))
							{
								echo $this->Form->postLink('Book Event', 
													  ['controller' => 'Bookings', 'action' => 'add'], 
													  ['data' => array('eventID' => $event->eventID), 'class' => 'CreateBtn']);
							}
							else
							{
								echo $this->Form->button('Book Event', ['onclick'=>'show(\'bookEventPopup\')', 'class'=>'CreateBtn']);
								
								echo "<div id='bookEventPopup'>";
								echo $this->Form->create("Bookings", array('url'=>'/bookings/add'));
									echo $this->Form->control('promoCode', ['type'=>'text', 'label'=>'', 'placeholder' => 'Add a Promo Code.']);
									echo $this->Form->hidden('eventID', ['value' => $event->eventID]);
									
									echo $this->Form->button('Submit', ['class'=>'CreateBtn']);
								echo $this->Form->end();
								echo $this->Form->button('Cancel', ['onclick'=>'hide(\'bookEventPopup\')', 'class'=>'CreateBtn']);
								echo "</div>";
							}
							
						}
						else if (!empty($booking))
						{
							echo $this->Form->postLink('Withdraw from Event', 
													  ['controller' => 'Bookings', 'action' => 'remove'], 
													  ['data' => array('eventID' => $event->eventID), 'class' => 'CreateBtn']);	
						}
					?>
				</div>
					
				<div id="form_details_separator">
				</div>
				
				<!-- Form Content -->
				<div id="form_details_content">
					<?= $this->Flash->render('eventBookingSuccess') ?>
					<?= $this->Flash->render('eventBookingFailed') ?>
					<?= $this->Flash->render('eventWithdrawSuccess') ?>
					
					<!-- Event About -->
					<div class="form_details_content_section">
						<span>1</span>
						<h2>Event About</h2>
						<hr/>
						
						<p>
							Event Title<br/>
							<?= $event->eventTitle ?>
						</p>
						
						<p>
							Event Description<br/>
							<?= $event->eventTitle ?>
						</p>
						
						<p>
							Event Type<br/>
							<?= $event->eventType ?>
						</p>
					</div>
						
					<br/>
						
					<!-- Event Details -->
					<div class="form_details_content_section">
						<span>2</span>
						<h2>Event Details</h2>
						<hr/>
						
						<p>
							Event Start Date<br/>
							<?= $event->eventStartDate ?>
						</p>
						
						<p>
							Event End Date<br/>
							<?= $event->eventEndDate ?>
						</p>
						
						<p>
							Event Location<br/>
							<?= $event->eventLocation ?>
						</p>
					</div>
						
					<br/>
					
					<!-- Event Advanced Details -->
					<div class="form_details_content_section">
						<span>3</span>
						<h2>Event Advanced Details</h2>
						<hr/>
						
						<p>
							Event Total Capacity<br/>
							<?= $event->eventTotalCapacity ?>
						</p>
						
						<p>
							Event Price<br/>
							<?= $event->eventPrice ?>
						</p>
					</div>
				
				</div>
				
			</div>
		</div>
	</div>
</div>
<?= $this->Html->css('cssEventBrowse') ?>
<?= $this->assign('title', 'Event Creation'); ?>

<!-- JQuery UI -->
<script type = "text/javascript">
	var eventTitleArray = <?php echo json_encode($eventTitles); ?>;
	$(function () {
	  $('#eventTitles').autocomplete({
		  source: eventTitleArray
	  });
	});
</script>

<div class="container-fluid event_browse_container">
	<div class="row event_browse_section">
		<div>
			<div class="col-xs-12">
			
				<!-- Row Starts -->
				<div class="row event_browse_content">
					
					<div class="col-md-12 col-xs-12 event_browse_right">
						<div>
							
							<!-- List of Events -->
							<div class="event_browse_eventList">
								<!-- Title -->
								<div class="event_browse_title">
									<h1>Events</h1>
									<div class="event_browse_filter">
									<?=$this->Form->create("Events", array('url'=>'/events/browse')); ?>
										<?=$this->Form->control('eventTitle', ['type'=>'text', 'id'=>'eventTitles', 
											'label'=>'', 'placeholder' => 'Search for an event title.', 
											'templates' => [
												'inputContainer' => '<div class="input text">{{content}}
												<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
												</div>'
											]
										]) ?>
									<?=$this->Form->end(); ?>
									</div>
								</div>
								
								<!-- Form Separator -->
								<div class="div_separator">
									<hr/>
								</div>
								
								<!-- Content -->
								<div class="event_browse_eventList_content">
								<?php
									if (!$eventList->isEmpty())
									{	foreach ($eventList as $event){
											// Event Div
											echo "<div>";
												echo "<p>", $this->Time->format($event->eventStartDate, "EEEE F MMMM YYYY 'at' h:00 a"), "</p>";
												echo "<h2>", $event->eventTitle, "</h2>";
												echo "<p><b>location: </b>", $event->eventLocation, "</p>";
												echo "<p id='eventHostingCapacity'><b>capacity: </b>".$event->eventCurrentCapacity." / ", $event->eventTotalCapacity."</p>";
												echo $this->Html->Link('Detail', [
																	   'controller' => 'Events', 'action' => 'view',
																	   '?' => ['eventID' => $event->eventID]
																	  ]);
											echo "</div><br/>";
										}
									} // No Events Available
									else { echo "<div>There is no '$selectedTitle' event</div>"; }
								?>
								</div>
								<!-- End of List of Events -->
							
								<!-- Pagination -->
								<?php echo "<div class='paginationDiv'>", $this->Paginator->numbers(), "</div>"; ?>
							</div>
						</div>
					</div>
					
				
			</div>
		</div>
		
	</div>
</div>
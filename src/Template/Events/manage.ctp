<?= $this->Html->css('cssEventCreationForm'); ?>
<?= $this->assign('title', 'Event Management'); ?>

<div class="container-fluid form_container">
	<div class="row form_section">
		<div>
			<div class="col-xs-12 vertical_center" id="form_details">
				
				<!-- Form Title -->
				<div id="form_details_title">
					<h1 id="">Manage Event</h1>
				</div>
				
				<div id="form_details_separator">
				</div>
				
				<!-- Form Content -->
				<div id="form_details_content">
					
					<!-- Event About -->
					<div class="form_details_content_section">
						<h2><?= $event->eventTitle ?></h2>
						<hr/>
						
						<?php
							if ($event->eventStatus)
							{
								echo $this->Form->postLink('Cancel Event', 
														  ['controller' => 'Events', 'action' => 'manage'], 
														  ['data' => array('eventID' => $event->eventID,
																		   'eventStatus'=>'cancel')
														  ]);
							}
							else
							{
								echo $this->Form->postLink('Launch Event', 
														  ['controller' => 'Events', 'action' => 'manage'], 
														  ['data' => array('eventID' => $event->eventID,
																		   'eventStatus'=>'launch')
														  ]);
							}
							echo "<br/>";
							if ($event->eventMarkForDeletion)
							{
								echo $this->Form->postLink('Undo Delete', 
														  ['controller' => 'Events', 'action' => 'manage'], 
														  ['data' => array('eventID' => $event->eventID,
																		   'eventMarkForDeletion'=>'undoDelete')
														  ]);
							}
							else
							{
								echo $this->Form->postLink('Delete', 
														  ['controller' => 'Events', 'action' => 'manage'], 
														  ['data' => array('eventID' => $event->eventID,
																		   'eventMarkForDeletion'=>'toDelete')
														  ]);
							}
						?>
					</div>
					
				</div>
				
			</div>
		</div>
	</div>
</div>
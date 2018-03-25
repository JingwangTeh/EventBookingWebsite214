<?= $this->Html->css('cssEventCreationForm') ?>
<?= $this->assign('title', 'Event Management'); ?>

<?php use Cake\I18n\Time; ?>

<!-- JQuery UI -->
<script type = "text/javascript">
	$(function () {
	  $('#eventStartDate').datetimepicker();
	  $('#eventEndDate').datetimepicker();
	});
</script>

<div class="container-fluid form_container">
	<div class="row form_section">
		<div>
			<div class="col-xs-12 vertical_center" id="form_details">
				
				<?=$this->Form->create("Events",array('url'=>'/events/edit')); ?>
				
					<!-- Form Title -->
					<div id="form_details_title">
						<h1 id="">Edit Event</h1>
						<?=$this->Form->button('Save', ['class' => 'CreateBtn']); ?>
					</div>
					
					<!-- Form Separator -->
					<div id="form_details_separator">
					</div>
				
					<!-- Form Content -->
					<div id="form_details_content">
						
						<!-- Event About -->
						<fieldset class="form_details_content_section">
							<span>1</span>
							<h2>Event About</h2>
							<hr/>
							
							<?= $this->Form->control('eventTitle', ['label' => 'Event Title', 'default'=>$event->eventTitle]) ?>
							<?= $this->Flash->render('eventTitleErr_Edit') ?>
							<label>Event Description</label>
							<?= $this->Form->textarea('eventDesc', ['label' => 'Description', 'default'=>$event->eventDesc]) ?>
							<?= $this->Flash->render('eventDescErr_Edit') ?>
							
							<label>Event Type</label>
							<?= $this->Form->select('eventType', $eventTypeNames, ['default'=>$event->eventType]); ?>
							<?= $this->Flash->render('eventTypeErr_Edit') ?>
						</fieldset>
						
						<br/>
						
						<!-- Event Details -->
						<fieldset class="form_details_content_section">
							<span>2</span>
							<h2>Event Details</h2>
							<hr/>
							
							<?= $this->Form->control('eventStartDate', ['label' => 'Start Date', 'id'=>'eventStartDate', 'default' => $this->Time->format($event->eventStartDate, 'Y/MM/d HH:00')]) ?>
							<?= $this->Flash->render('eventStartDateErr_Edit') ?>
							<?= $this->Form->control('eventEndDate', ['label' => 'End Date', 'id'=>'eventEndDate', 'default' => $this->Time->format($event->eventEndDate, 'Y/MM/d HH:00')]) ?>
							<?= $this->Flash->render('eventEndDateErr_Edit') ?>
							<?= $this->Form->control('eventLocation', ['label' => 'Location', 'default' => $event->eventLocation]) ?>
							<?= $this->Flash->render('eventLocationErr_Edit') ?>
						</fieldset>
						
						<br/>
						
						<!-- Event Advanced Details -->
						<fieldset class="form_details_content_section">
							<span>3</span>
							<h2>Event Advanced Details</h2>
							<hr/>
							
							<?= $this->Form->control('eventTotalCapacity', ['type' => 'number', 'min' => '1', 'label' => 'Total Capacity', 'default' => $event->eventTotalCapacity]) ?>
							<?= $this->Flash->render('eventTotalCapacityErr_Edit') ?>
							<?= $this->Form->control('eventPrice', ['type'=>'number', 'step'=>'0.01', 'label' => 'Price', 'default' => $event->eventPrice]) ?>
							<?= $this->Flash->render('eventPriceErr_Edit') ?>
							<?= $this->Form->control('eventPromoCode', ['default'=>'', 'label' => 'Promo Code', 'default' => $event->eventPromoCode]) ?>
							<?= $this->Form->control('eventDiscountPercent', ['type'=>'number', 'step'=>'0.01', 'label' => 'Promo Code Discount', 'default' => $event->eventDiscountPercent]) ?>
							
						</fieldset>
					
					</div>
					
					<?= $this->Form->hidden('eventID', ['default' => $eventID]); ?>
				
				<?=$this->Form->end(); ?>
				
			</div>
		</div>
	</div>
</div>
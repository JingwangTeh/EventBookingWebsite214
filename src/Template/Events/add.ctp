<?= $this->Html->css('cssEventCreationForm') ?>
<?= $this->assign('title', 'Event Creation'); ?>

<!-- JQuery UI -->
<script type = "text/javascript">
	$(function () {
	  $('#eventStartDate').datetimepicker();
	  $('#eventEndDate').datetimepicker();
	});
</script>

<!-- Content -->
<div class="container-fluid form_container">
	<div class="row form_section">
		<div>
			<div class="col-xs-12 vertical_center" id="form_details">
			
				<?=$this->Form->create("Events",array('url'=>'/events/add')); ?>
				
					<!-- Form Title -->
					<div id="form_details_title">
						<h1 id="">Create Event</h1>
						<?=$this->Form->button('Create', ['class' => 'CreateBtn']); ?>
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
							
							<?= $this->Form->control('eventTitle', ['label' => 'Event Title', 'placeholder' => 'Give a short title for the event.']) ?>
							<?= $this->Flash->render('eventTitleErr') ?>
							<label>Event Description</label>
							<?= $this->Form->textarea('eventDesc', ['label' => 'Description', 'placeholder' => 'Describe what the event is about.']) ?>
							<?= $this->Flash->render('eventDescErr') ?>
							<label>Event Type</label>
							<?= $this->Form->select('eventType', $eventTypeNames); ?>
							<?= $this->Flash->render('eventTypeErr') ?>
							
						</fieldset>
						
						<br/>
						
						<!-- Event Details -->
						<fieldset class="form_details_content_section">
							<span>2</span>
							<h2>Event Details</h2>
							<hr/>
							
							<?= $this->Form->control('eventStartDate', ['label' => 'Start Date', 'id'=>'eventStartDate', 'default' => date('Y/m/d H:00')]) ?>
							<?= $this->Flash->render('eventStartDateErr') ?>
							<?= $this->Form->control('eventEndDate', ['label' => 'End Date', 'id'=>'eventEndDate', 'default' => date('Y/m/d H:00')]) ?>
							<?= $this->Flash->render('eventEndDateErr') ?>
							<?= $this->Form->control('eventLocation', ['label' => 'Location', 'placeholder' => 'Specify where the event is being held.']) ?>
							<?= $this->Flash->render('eventLocationErr') ?>
						</fieldset>
						
						<br/>
						
						<!-- Event Advanced Details -->
						<fieldset class="form_details_content_section">
							<span>3</span>
							<h2>Event Advanced Details</h2>
							<hr/>
							
							<?= $this->Form->control('eventTotalCapacity', ['type' => 'number', 'min' => '1', 'label' => 'Total Capacity', 'placeholder' => 'Specify the maximum number of people who can come.']) ?>
							<?= $this->Flash->render('eventTotalCapacityErr') ?>
							<?= $this->Form->control('eventPrice', ['type'=>'number', 'step'=>'0.01', 'label' => 'Price', 'placeholder' => 'Give an amount required for the entry fee.']) ?>
							<?= $this->Flash->render('eventPriceErr') ?>
							<?= $this->Form->control('eventPromoCode', ['default'=>'', 'label' => 'Promo Code', 'placeholder' => 'Promotional code for price discounts']) ?>
							<?= $this->Form->control('eventDiscountPercent', ['type'=>'number', 'step'=>'0.01', 'label' => 'Promo Code Discount', 'placeholder' => 'How much is the price discount?']) ?>
						</fieldset>
					</div>
				
				<?=$this->Form->end(); ?>
				
			</div>
		</div>
	</div>
</div>
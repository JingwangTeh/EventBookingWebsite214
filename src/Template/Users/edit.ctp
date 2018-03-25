<?= $this->Html->css('cssEventCreationForm') ?>
<?= $this->assign('title', 'Edit User'); ?>

<div class="container-fluid form_container">
	<div class="row form_section">
		<div>
			<div class="col-xs-12 vertical_center" id="form_details">
			
				<?= $this->Form->create(); ?>
				
					<!-- Form Title -->
					<div id="form_details_title">
						<h1 id="">Edit Account Information</h1>
						<!-- Submit Button -->
						<?=$this->Form->button('Update', ['class' => 'CreateBtn']); ?>
					</div>
					
					<!-- Form Separator -->
					<div id="form_details_separator">
					</div>
						
					<!-- Form Content -->
					<div id="form_details_content">
						
						<!-- Username and Password -->
						<fieldset class="form_details_content_section">
							<?= $this->Form->control('username', ['label' => 'Username', 'default'=>$user->username]) ?>
							<?= $this->Form->control('password', ['type' => 'password', 'label' => 'Password']) ?>
						</fieldset>
					</div>
					
				<?= $this->Form->end(); ?>
				
				<!-- Registration Error Message -->
				<?= $this->Flash->render() ?>
				
			</div>
		</div>
	</div>
</div>
<?= $this->Html->css('cssUserForm') ?>
<?= $this->assign('title', 'User Registration'); ?>

<div class="container-fluid user_form">
	<div class="row user_form_section">
		<div>
			<div class="col-xs-12 vertical_center user_form_details">
			
				<?= $this->Form->create(); ?>
				
					<fieldset>
						<!-- Form Title -->
						<span id="form_title">Account Registration</span>
						<hr/>
						
						<!-- Username and Password -->
						<div id="form_fields">
							<?= $this->Form->text('email', ['type' => 'email', 'placeholder'=>'Email']) ?><br/>
							<?= $this->Form->text('username', ['placeholder'=>'Username']) ?><br/>
							<?= $this->Form->text('password', ['type' => 'password', 'placeholder'=>'Password']) ?><br/>
							<?= $this->Form->text('password_confirm', ['type' => 'password', 'placeholder'=>'Confirm Password']) ?>
						</div>
					</fieldset>
					
					<!-- Submit Button -->
					<?= $this->Form->button('Register'); ?>
				<?= $this->Form->end(); ?>
				
				<!-- Registration Error Message -->
				<?= $this->Flash->render() ?>
				
			</div>
		</div>
	</div>
</div>
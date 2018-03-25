<?= $this->Html->css('cssUserForm') ?>
<?= $this->assign('title', 'User Login'); ?>

<div class="container-fluid user_form">
	<div class="row user_form_section">
		<div>
			<div class="col-xs-12 vertical_center user_form_details">
			
				<?= $this->Form->create(); ?>
				
					<fieldset>
						<!-- Form Title -->
						<span id="form_title">Account Login</span>
						<hr/>
						
						<!-- Username and Password -->
						<div id="form_fields">
							<?= $this->Form->text('username', ['placeholder'=>'Username']) ?><br/>
							<?= $this->Form->text('password', ['type' => 'password', 'placeholder'=>'Password']) ?>
						</div>
					</fieldset>
					
					<!-- Submit Button -->
					<?= $this->Form->button('Login'); ?>
				<?= $this->Form->end() ?>
				
				<!-- Login Error Message -->
				<?= $this->Flash->render() ?>
				
			</div>
		</div>
	</div>
</div>
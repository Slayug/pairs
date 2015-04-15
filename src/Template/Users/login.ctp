
<?= $this->Flash->render('error') ?>
<div id="login">
	<div id="login_title">
		<h3>Connexion</h3>
	</div>
	<?= $this->Form->create() ?>
	<?= $this->Form->input('email', [
												'label' => 'Email:',
												'placeholder' => 'Email']) ?>
	<?= $this->Form->input('password', ['type' => 'password',
												'label' => 'Mot de passe:',
												'placeholder' => 'Mot de passe']) ?>
	<?= $this->Form->button('Connexion') ?>
	<?= $this->Form->end() ?>
</div>

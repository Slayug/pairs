<?php
$session = $this->request->session();
$currentUser = $session->read('Auth.User');
?>
	<?= $this->Flash->render() ?>
	<?= $this->Flash->render('auth') ?>
<div class="panel panel-default questionnaires index large-12 medium-12 columns">
	<div class="panel-heading"><h2 class="panel-title">Copier le questionnaire: <?= $questionnaire->title ?></h2></div>
	<div class="panel-body">
	
	
    <?= $this->Form->create($questionnaire); ?>
	
	<select style="margin-left:15%;width:70%;"name="modules[ids][]" multiple="multiple" id="modules-ids">
		<?php
			foreach ($modulesUser as $module){
				?>
				<option value="<?= $module['id'] ?>"><?= $module['name'] ?></option>
				<?php
			}
		?>
	</select>
	<br>
    <button style="display:block;margin:0 auto;text-align:center;"type="submit">Copier</button>
    <?= $this->Form->end() ?>
</div>
</div>
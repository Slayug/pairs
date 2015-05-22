<div class="panel panel-default roles form large-12 medium-12 columns">
    <div class="panel-heading"><h2 class="panel-title">Ajouter un module</h2></div>
	<div class="panel-body">
		
	<?= $this->Flash->render() ?>
    <?= $this->Form->create($module); ?>
		<div class="alert alert-warning"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Pour le nom de votre module, vous pouvez par exemple mettre L2-VotreMatière</div>
        <?php
			$session = $this->request->session();
			$currentUser = $session->read('Auth.User');
			$id = $currentUser['id'];
		
            echo $this->Form->input('name', ['label' => 'Nom:']);
            echo $this->Form->input('description', ['label' => 'Description:']);
        ?>
    <?= $this->Form->button(__('Valider')) ?>
    <?= $this->Form->end() ?>
</div>
</div>

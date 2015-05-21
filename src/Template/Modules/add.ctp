<div class="panel panel-default roles form large-12 medium-12 columns">
    <div class="panel-heading"><h2 class="panel-title">Ajouter un module</h2></div>
	<div class="panel-body">
		
	<?= $this->Flash->render() ?>
    <?= $this->Form->create($module); ?>
		<p class="alert alert-warning">Pour le nom de votre Module, vous pouvez par exemple mettre L2-VotreMatière</p>
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

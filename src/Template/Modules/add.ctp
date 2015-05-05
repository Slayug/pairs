<div class="actions columns large-12 medium-12">
</div>
<div class="roles form large-10 medium-9 columns">
	<?= $this->Flash->render() ?>
    <?= $this->Form->create($module); ?>
    <fieldset>
        <legend><?= __('Ajouter un Module') ?></legend>
		<p class="alert alert-warning">Pour le nom de votre Module, vous pouvez par exemple mettre L2-Matière</p>
        <?php
			$session = $this->request->session();
			$currentUser = $session->read('Auth.User');
			$id = $currentUser['id'];
		
            echo $this->Form->input('name', ['label' => 'Nom:']);
            echo $this->Form->input('description', ['label' => 'Description:']);
            echo $this->Form->input('groups._ids', ['options' => $groups,
													'label' => 'Groupes:']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

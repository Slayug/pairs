<div class="actions columns large-2 medium-3">

</div>
<div class="groups form large-10 medium-9 columns">
    <?= $this->Form->create($group); ?>
    <fieldset>
        <legend><?= __('Ajouter un groupe') ?></legend>
        <?php
			$session = $this->request->session();
			$currentUser = $session->read('Auth.User');
			$id = $currentUser['id'];
		
            echo $this->Form->input('name', ['label' => 'Nom:']);
            echo $this->Form->input('description', ['label' => 'Description:']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

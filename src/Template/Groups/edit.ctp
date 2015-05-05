<div class="actions columns large-12 medium-12">

	<?= $this->Flash->render() ?>
	<?= $this->Flash->render('auth') ?>
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Supprimer'),
                ['action' => 'delete', $group->id],
                ['confirm' => __('Êtes vous sûr de supprimer # {0}?', $group->id)]
            )
        ?></li>
    </ul>
</div>
<div class="groups form large-10 medium-9 columns">
    <?= $this->Form->create($group); ?>
    <fieldset>
        <legend><?= __('Editer le groupe: ' . $group->name) ?></legend>
        <?php
            echo $this->Form->input('name', ['label' => 'Nom:']);
            echo $this->Form->input('description', ['label' => 'Description:']);
            echo $this->Form->input('users._ids', ['options' => $users]);
            echo $this->Form->input('questionnaires._ids', ['options' => $questionnaires]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

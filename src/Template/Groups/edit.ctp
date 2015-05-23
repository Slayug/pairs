<?= $this->Flash->render() ?>
	<?= $this->Flash->render('auth') ?>
<div class="actions columns large-12 medium-12">
 <div class="panel-heading"><h2 class="panel-title">Module: <?= h($module->name) ?></h2></div>
	<div class="panel-body">
    <?= $this->Form->create($group); ?>
    <fieldset>
        <legend><?= __('Editer le groupe: ' . $group->name) ?></legend>
        <?php
            echo $this->Form->input('name', ['label' => 'Nom:']);
            echo $this->Form->input('description', ['label' => 'Description:']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Valider')) ?>
    <?= $this->Form->end() ?>
</div>

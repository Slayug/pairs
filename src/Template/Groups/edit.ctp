<?= $this->Flash->render() ?>
	<?= $this->Flash->render('auth') ?>
	
	
<div class="panel panel-default roles form actions columns large-12 medium-12">
 <div class="panel-heading"><h2 class="panel-title">Editer le groupe: <?= $group->name ?></h2></div>
	<div class="panel-body">
    <?= $this->Form->create($group); ?>
        <?php
            echo $this->Form->input('name', ['label' => 'Nom:']);
            echo $this->Form->input('description', ['label' => 'Description:']);
        ?>
    <?= $this->Form->button(__('Valider')) ?>
    <?= $this->Form->end() ?>
</div>
</div>

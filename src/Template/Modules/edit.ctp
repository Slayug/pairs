<?= $this->Flash->render() ?>
<div class="panel panel-default roles form large-12 medium-12 columns">
    <div class="panel-heading"><h2 class="panel-title">Editer un module</h2></div>
	<div class="panel-body">
    <?= $this->Form->create($module); ?>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('description');
        ?>
    <?= $this->Form->button(__('Valider')) ?>
    <?= $this->Form->end() ?>
</div>
</div>

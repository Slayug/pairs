<div class="panel panel-default questionnaires index large-12 medium-12 columns">
	<div class="panel-heading"><h2 class="panel-title">Editer un questionnaire</h2></div>
	<div class="panel-body">
    <?= $this->Form->create($questionnaire); ?>
    <fieldset>
        <legend><?= __('Edit Questionnaire') ?></legend>
        <?php
            echo $this->Form->input('titre');
            echo $this->Form->input('description');
            echo $this->Form->input('date_creation');
            echo $this->Form->input('date_limit');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Valider')) ?>
    <?= $this->Form->end() ?>
</div>


<div class="questionnaires form large-10 medium-10 columns">
    <?= $this->Form->create($questionnaire); ?>
    <fieldset>
        <legend><?= __('Ajouter un Questionnaire') ?></legend>
        <?php
            echo $this->Form->input('title');
            echo $this->Form->input('description');
            echo $this->Form->input('date_creation', array('class' => 'date'));
            echo $this->Form->input('date_limit', array('class' => 'date'));
            echo $this->Form->input('questions._ids', ['options' => $questions]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

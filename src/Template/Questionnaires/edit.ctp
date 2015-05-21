<div class="questionnaires form large-12 medium-12 columns">
    <?= $this->Form->create($questionnaire); ?>
    <fieldset>
        <legend><?= __('Edit Questionnaire') ?></legend>
        <?php
            echo $this->Form->input('titre');
            echo $this->Form->input('description');
            echo $this->Form->input('date_creation');
            echo $this->Form->input('date_limite');
            echo $this->Form->input('groups._ids', ['options' => $groups]);
            echo $this->Form->input('questions._ids', ['options' => $questions]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Valider')) ?>
    <?= $this->Form->end() ?>
</div>

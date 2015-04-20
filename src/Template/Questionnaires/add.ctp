<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
    </ul>
</div>
<div class="questionnaires form large-10 medium-9 columns">
    <?= $this->Form->create($questionnaire); ?>
    <fieldset>
        <legend><?= __('Add Questionnaire') ?></legend>
        <?php
            echo $this->Form->input('titre');
            echo $this->Form->input('description');
            echo $this->Form->input('date_creation');
            echo $this->Form->input('date_limite');
           // echo $this->Form->input('modules._ids', ['options' => $modules]);
            echo $this->Form->input('questions._ids', ['options' => $questions]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

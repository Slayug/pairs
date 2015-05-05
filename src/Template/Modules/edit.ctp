<div class="groups form large-12 medium-12 columns">
    <?= $this->Form->create($module); ?>
    <fieldset>
        <legend><?= __('Editer un module') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('description');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

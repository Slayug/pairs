<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Supprimer'),
                ['action' => 'delete', $module->id],
                ['confirm' => __('Êtes vous sûr de supprimer # {0}?', $module->id)]
            )
        ?></li>
    </ul>
</div>
<div class="groups form large-10 medium-9 columns">
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

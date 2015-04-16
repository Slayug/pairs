<?php

	$session = $this->request->session();
	$currentUser = $session->read('Auth.User');
	$role = $currentUser['role_id'];
?>

<div class="users view large-10 medium-9 columns">
    <h2>Module: <?= h($module->name) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Description:') ?></h6>
            <p><?= h($module->description) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Membres du module') ?></h4>
    <?php if (!empty($module->users)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Prénom') ?></th>
            <th><?= __('Nom') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($module->users as $user): ?>
        <tr>
            <td><?= h($user->first_name) ?></td>
            <td><?= h($user->last_name) ?></td>

            <td class="actions">
                <?= $this->Form->postLink(__('Supprimer'), ['controller' => 'Modules', 'action' => 'delete_user', $user->id], ['confirm' => __('Êtes vous sûr de supprimer ce membre du module # {0}?', $user->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Groupe du Module') ?></h4>
	<?php if($role == 2){
		echo $this->Html->link(__('Ajouter un groupe'), ['controller' => 'Groups', 'action' => 'add', $module->id]);
	}
    if (!empty($module->group)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Nom') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($module->groups as $group): ?>
        <tr>
            <td><?= h($group->name) ?></td>

            <td class="actions">
                <?= $this->Form->postLink(__('Supprimer'), ['controller' => 'Modules', 'action' => 'delete_group', $group->id], ['confirm' => __('Êtes vous sûr de supprimer ce groupe du module # {0}?', $user->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>

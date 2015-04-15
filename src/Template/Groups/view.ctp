<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
    </ul>
</div>

<?php

	$session = $this->request->session();
	$currentUser = $session->read('Auth.User');
	$role = $currentUser['role_id'];

?>
<div class="groups view large-10 medium-9 columns">
    <h2><?= h($group->name) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Nom') ?></h6>
            <p><?= h($group->name) ?></p>
            <h6 class="subheader"><?= __('Description') ?></h6>
            <p><?= h($group->description) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Utilisateurs') ?></h4>
    <?php if (!empty($group->users)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Prénom') ?></th>
            <th><?= __('Nom') ?></th>
			<?php
			if($role == 2){?>
            <th class="actions"><?= __('Actions') ?></th>
			<?php
			}
			?>
        </tr>
        <?php foreach ($group->users as $users): ?>
        <tr>
            <td><?= h($users->first_name) ?></td>
            <td><?= h($users->last_name) ?></td>

			
				<?php
				if($role == 2){?>
            <td class="actions"><?php
						echo $this->Form->postLink(__('Supprimer'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Êtes vous sûr de supprimer ce membre de ce groupe # {0}?', $users->id)]);
           ?></td>
		   <?php
				}
		   ?>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Questionnaires') ?></h4>
    <?php if (!empty($group->questionnaires)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Titre') ?></th>
            <th><?= __('Description') ?></th>
            <th><?= __('Date Creation') ?></th>
            <th><?= __('Date Limite') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($group->questionnaires as $questionnaires): ?>
        <tr>
            <td><?= h($questionnaires->titre) ?></td>
            <td><?= h($questionnaires->description) ?></td>
            <td><?= h($questionnaires->date_creation) ?></td>
            <td><?= h($questionnaires->date_limite) ?></td>

            <td class="actions">
			
                <?= $this->Html->link(__('Voir'), ['controller' => 'Questionnaires', 'action' => 'view', $questionnaires->id]) ?>
				<?php
					if($role == 2){ // professeur
						echo $this->Html->link(__('Editer'), ['controller' => 'Questionnaires', 'action' => 'edit', $questionnaires->id]);
					}
				
				?>
		

                <?= $this->Form->postLink(__('Supprimer'), ['controller' => 'Questionnaires', 'action' => 'delete', $questionnaires->id], ['confirm' => __('Are you sure you want to delete # {0}?', $questionnaires->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>

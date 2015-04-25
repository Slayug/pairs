<?php

	$session = $this->request->session();
	$currentUser = $session->read('Auth.User');
	$role = $currentUser['role_id'];

?>
<?= $this->Flash->render() ?>
<div class="groups view large-10 medium-9 columns">
    <h2><?= h($group->name) ?></h2>
	<?php 
	if($isOwner){?>
		<div class="actions">
			<?= $this->Html->link($this->Html->image('edit.png'), array('controller'=>'Groups', 'action' => 'edit', $group->id), array('escape' => false));?>
			
			<?= $this->Form->postLink(
				$this->Html->image('delete.png',
							array('alt' => __('Supprimer'),
								  'title' => __('Supprimer'))),
							array('controller' => 'Groups',
								  'action' => 'delete', $group->id),
							array('escape' => false,
								  'confirm' => __('Êtes vous sûr de supprimer le groupe #{0}# ?', $group->name))) ?>
		</div>
	<?php
	}
	?>
	
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
	
	<a href="#" onClick="spawnDiv('add_user_group');">Ajouter un utilisateur</a>	
	
	<div id="add_user_group" class="initMove" class="column large-11">
    <?= $this->Form->create($group, ['action' => 'addUser']); ?>
		<fieldset>
			<legend><?= __('Ajouter un étudiant') ?></legend>
			<?php			
				echo $this->Form->input('first_name', ['label' => 'Prénom:']);
				echo $this->Form->input('last_name', ['label' => 'Nom:']);
			?>
		</fieldset>
		<?= $this->Form->button(__('Ajouter')) ?>
		<?= $this->Form->end() ?>
		<a style="float:right;"  href="" onClick="closeDiv('add_user_group');">Fermer</a>
	</div>
	
    <?php if (!empty($group->users)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Prénom') ?></th>
            <th><?= __('Nom') ?></th>
        </tr>
        <?php foreach ($group->users as $users): ?>
        <tr>
            <td><?php echo ucfirst(h($users->first_name)) ?></td>
            <td><?php echo ucfirst(h($users->last_name)) ?></td>
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
            <td><?= h($questionnaires->title) ?></td>
            <td><?= h($questionnaires->description) ?></td>
            <td><?= h($questionnaires->date_creation) ?></td>
            <td><?= h($questionnaires->date_limit) ?></td>

            <td class="actions">
			
                <?= $this->Html->link(__('Voir'), ['controller' => 'Questionnaires', 'action' => 'view', $questionnaires->id]) ?>
				<?php
					if($isOwner){ 
						echo $this->Html->link(__('Editer'), ['controller' => 'Questionnaires', 'action' => 'edit', $questionnaires->id]);
						?>
						 <?= $this->Form->postLink(__('Supprimer'), ['controller' => 'Questionnaires', 'action' => 'delete', $questionnaires->id], ['confirm' => __('Are you sure you want to delete # {0}?', $questionnaires->id)]) ?>
							<?php
					}
				?>
		
               
            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>

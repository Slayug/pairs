<?php

	$session = $this->request->session();
	$currentUser = $session->read('Auth.User');
	$role = $currentUser['role_id'];

?>
<?= $this->Flash->render() ?>
<div class="panel panel-default groups view large-12 medium-12 columns">
    <div class="panel-heading"><h2 class="panel-title"><?= h($group->name) ?></h2></div>
	<div class="panel-body">
	<?php 
	if($isOwner){?>
		<div class="actions">
			<?= $this->Html->link($this->Html->image('edit.png'),
									array('controller'=>'Groups',
											'action' => 'edit',
											$group->id),
									array('escape' => false));?>
			
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
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Utilisateurs') ?></h4>
	
	<?php if($isOwner){ ?>
	<a href="#" onClick="spawnDiv('add_user_group');">Ajouter un utilisateur</a>	
	
	<div id="add_user_group" class="initMove" class="column large-11">
    <?= $this->Form->create($group, ['action' => 'addUser']); ?>
		<fieldset>
			<legend><?= __('Ajouter un étudiant') ?></legend>
			<?php
				echo $this->Form->input('last_name', ['label' => 'Nom:']);
				echo $this->Form->input('first_name', ['label' => 'Prénom:']);
			?>
		</fieldset>
		<?= $this->Form->button(__('Ajouter')) ?>
		<?= $this->Form->end() ?>
		<a href="" onClick="closeDiv('add_user_group');">Fermer</a>
	</div>
	
	<?php } ?>
	
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
</div>
</div>
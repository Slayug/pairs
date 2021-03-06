<?php

	$session = $this->request->session();
	$currentUser = $session->read('Auth.User');
	$role = $currentUser['role_id'];
?>

	<?= $this->Flash->render() ?>
	<?= $this->Flash->render('auth') ?>
<div class="panel panel-default users view large-12 medium-12 columns">
	
    <div class="panel-heading"><h2 class="panel-title">Module: <?= h($module->name) ?></h2></div>
	<div class="panel-body">
	<?php 
	if($isOwner){?>
		<div class="actions">
			<?= $this->Html->link($this->Html->image('edit.png'), array('controller'=>'Modules', 'action' => 'edit', $module->id), array('escape' => false));?>
			
			<?= $this->Form->postLink(
				$this->Html->image('delete.png',
							array('alt' => __('Supprimer'),
								  'title' => __('Supprimer'))),
							array('controller' => 'Modules',
								  'action' => 'delete', $module->id),
							array('escape' => false,
								  'confirm' => __('Êtes vous sûr de supprimer le module #{0}# ?', $module->name))) ?>
			 <?= $this->Html->link('Ajouter un questionnaire', ['controller' => 'Questionnaires',
																'action' => 'add',
																$module->id]); ?>
		</div>
	<?php
	}
	?>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Description:') ?></h6>
            <p><?= h($module->description) ?></p>
        </div>
    </div>

<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Propriétaire du module') ?></h4>
    <?php if (!empty($module->owners)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Prénom') ?></th>
            <th><?= __('Nom') ?></th>
        </tr>
        <?php foreach ($module->owners as $user): ?>
        <tr>
            <td><?= h($user->first_name) ?></td>
            <td><?= h($user->last_name) ?></td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>

<?php if($isOwner){ ?>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Groupe du Module') ?></h4>
	<?php 
		echo $this->Html->link(__('Ajouter un groupe'), ['controller' => 'Groups', 'action' => 'add', $module->id]);
		echo '<br />';
		?>
		<a href="#" onClick="spawnDiv('import_group');">Importation de groupe</a>	
	
		<div id="import_group" class="initMove" class="column large-11">
			<?= $this->Form->create($module, ['action' => 'importGroup', 'enctype' => 'multipart/form-data']); ?>
			<?php echo $this->Form->input('submittedfile', [
				'type' => 'file',
				'label' => 'Document (.xlsx - .ods):'
			]); ?>
			<?= $this->Form->button(__('Importer')) ?>
			<?= $this->Form->end() ?>
			<div class="alert alert-warning"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Pour pouvoir utiliser cette fonctionnalité, votre fichier doit être organisé comme l'un des exemples suivants:
				<ul>
					<li>Exemple 1 <?php echo $this->Html->link('.xlsx', '/files/exemple_1.xlsx'); ?> | <?php echo $this->Html->link('.ods', '/files/exemple_1.ods'); ?></li>
					<li>Exemple 2 <?php echo $this->Html->link('.xlsx', '/files/exemple_2.xlsx'); ?> | <?php echo $this->Html->link('.ods', '/files/exemple_2.ods'); ?></li>
					<li>Exemple 3 <?php echo $this->Html->link('.xlsx', '/files/exemple_3.xlsx'); ?> | <?php echo $this->Html->link('.ods', '/files/exemple_3.ods'); ?></li>
				</ul>
			</div>
			<a style="float:right;"  href="" onClick="closeDiv('import_group');">Fermer</a>
		</div>
	<?php
    if (!empty($module->groups)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Nom') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($module->groups as $group): ?>		
			<tr>
				<td class="td_link"><?= $this->Html->link(__($group->name), ['controller' => 'Groups', 'action' => 'view', $group->id]);?></td>
					<td>
				
					<?= $this->Html->link($this->Html->image('edit.png'), array('controller'=>'Groups', 'action' => 'edit', $group->id), array('escape' => false));?>
				
					<?= $this->Form->postLink(
							$this->Html->image('delete.png',
							array('alt' => __('Supprimer'),
								  'title' => __('Supprimer'))),
							array('controller' => 'Groups',
								  'action' => 'delete', $group->id),
							array('escape' => false,
								  'confirm' => __('Êtes vous sûr de supprimer le groupe #{0}# ?', $group->name))) ?>
					</td>
			</tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<?php } ?>

	<div class="related row">
		<div class="column large-12">
		<h4 class="subheader"><?= __('Questionnaires') ?></h4>
	<table>
	<?php
	if(!empty($questionnaires)){
		foreach ($questionnaires as $questionnaire): ?>
			<tr>
				<td class="td_link"><?= $this->Html->link(__($questionnaire['title']), ['controller' => 'Questionnaires', 'action' => 'view', $questionnaire['id']]);?></td>
				<td>
				<?php if($isOwner){ ?>
					<?= $this->Html->link($this->Html->image('edit.png'), array('controller'=>'Questionnaires', 'action' => 'edit', $questionnaire['id']), array('escape' => false));?>
					<?= $this->Form->postLink(
						$this->Html->image('delete.png',
							array('alt' => __('Supprimer'),
								  'title' => __('Supprimer'))),
							array('controller' => 'Questionnaires',
								  'action' => 'deleteAssociation', $questionnaire['id']),
							array('escape' => false,
								  'confirm' => __('Êtes vous sûr de supprimer le questionnaire #{0}# ?', $questionnaire['title']))); ?>
				</td>
				<?php
				}?>
			</tr>
		<?php
		endforeach;
	}
	?>
	</table>
		</div>
	</div>

</div>
</div>
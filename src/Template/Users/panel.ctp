<div id="pairs_panel" class="panel panel-default users view large-12 medium-12 columns">

<div class="panel-heading"><h2 class="panel-title">Panel</h2></div>
<div class="panel-body">
<?php
	$session = $this->request->session();
	$currentUser = $session->read('Auth.User');
	$role = $currentUser['role_id'];
	?>
		
		<h4 style="color:#404040;">Bonjour <?php echo h(ucfirst($currentUser['first_name']) . ' ' . ucfirst($currentUser['last_name'])); ?>.</h4>
		<?= $this->Flash->render('auth') ?>
		<?= $this->Flash->render() ?>
		<br>
	<?php
	
	if($role == 1){ //admin
	
		?>
			<h4>Gestion des utilisateurs</h4>
			<ul>
		<?php
			echo '<li>';
			echo $this->Html->link(__('Liste des utilisateurs'), ['controller' => 'Users', 'action' => 'index']);
			echo '</li>';
			echo '<li>';
			echo $this->Html->link(__('Ajouter un utilisateur'), ['controller' => 'Users', 'action' => 'add']);
			echo '</li>';
			
		?>
			</ul>
		<?php
	}
	
	if($role == 2){ // professeur
		?>
			<div class="panel-option col-md-6">
				<a href="/pairs/modules/add"><span class="panel-option-glyphicon add-on"><i class=" glyphicon glyphicon-plus"></i></span> Créer un module</a>
			</div>
			<div class="panel-option col-md-6">
				<a href="/pairs/questionnaires"><span class="panel-option-glyphicon add-on"><i class="panel-option-glyphicon glyphicon glyphicon-list"></i></span> Liste des questionnaires</a>
			</div>
		<?php
	}
?>

<div class="related row">
    <div class="column large-12">
	
    <?php
	if (!empty($user->module_owner)): ?>
	
    <h4 class="subheader"><?= __('Mes Modules') ?></h4>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Nom') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($user->module_owner as $module): ?>
			<tr>
				<td class="td_link"><?= $this->Html->link(__($module->name), ['controller' => 'Modules', 'action' => 'view', $module->id]);?></td>
					<td>
				
					<?= $this->Html->link($this->Html->image('edit.png'), array('controller'=>'Modules', 'action' => 'edit', $module->id), array('escape' => false));?>
				
					<?= $this->Form->postLink(
							$this->Html->image('delete.png',
							array('alt' => __('Supprimer'),
								  'title' => __('Supprimer'))),
							array('controller' => 'Modules',
								  'action' => 'delete', $module->id),
							array('escape' => false,
								  'confirm' => __('Êtes vous sûr de supprimer le module #{0}# ?', $module->name))) ?>
					</td>
			</tr>
		
        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>

<div class="related row">
    <div class="column large-12">
	
    <?php
	if (!empty($modulesUser)): ?>
	
    <h4 class="subheader"><?= __('Mes Modules') ?></h4>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Nom') ?></th>
        </tr>
        <?php foreach ($modulesUser as $module): ?>
			<tr>
				<td class="td_link"><?= $this->Html->link(__($module['name']), ['controller' => 'Modules', 'action' => 'view', $module['id']]);?></td>
			</tr>
		
        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>

</div>

</div>
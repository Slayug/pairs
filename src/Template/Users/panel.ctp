<div id="pairs_panel" class="users view large-10 medium-9 columns">

<h2>Panel</h2>
<p>
	<?= $this->Flash->render() ?>
	<?= $this->Flash->render('auth') ?>
<?php
	$session = $this->request->session();
	$currentUser = $session->read('Auth.User');
	$role = $currentUser['role_id'];
	?>
		<p>Bonjour <?php echo h($currentUser['first_name'] . ' ' . $currentUser['last_name']); ?></p>
	<?php
	
	if($role == 1){ //admin
	
		?>
			<h4>Gestion des utilisateurs</h4>
			<ul>
		<?php
			echo '<li>';
			echo $this->Html->link(__('Lister les utilisateurs'), ['controller' => 'Users', 'action' => 'index']);
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
			<h4>Gestion</h4>
			<ul>
			<?php
				echo '<li>';
				echo $this->Html->link(__('Créer un module'), ['controller' => 'Modules', 'action' => 'add']);
				echo '</li>';
				echo '<li>';
				echo $this->Html->link(__('Créer un groupe'), ['controller' => 'Groups', 'action' => 'add']);
				echo '</li>';
			?>
			</ul>
			<h4>Gestion des questionnaires</h4>
			<ul>			
				<?php
					echo '<li>';
					echo $this->Html->link(__('Lister les questionnaires'), ['controller' => 'Questionnaires', 'action' => 'index']);
					echo '</li>';
					echo '<li>';
					echo $this->Html->link(__('Créer un questionnaire'), ['controller' => 'Questionnaires', 'action' => 'add']);
					echo '</li>';
				?>
			</ul>
		<?php
	}
	
	
	
?>
</p>

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
	if (!empty($user->modules)): ?>
	
    <h4 class="subheader"><?= __('Mes Modules') ?></h4>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Nom') ?></th>
        </tr>
        <?php foreach ($user->modules as $module): ?>
			<tr>
				<td class="td_link"><?= $this->Html->link(__($module->name), ['controller' => 'Modules', 'action' => 'view', $module->id]);?></td>
			</tr>
		
        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>

</div>

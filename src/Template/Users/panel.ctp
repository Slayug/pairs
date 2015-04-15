<div id="pairs_panel" class="users view large-10 medium-9 columns">

<h2>Panel</h2>
<p>
<?php
	$session = $this->request->session();
	$currentUser = $session->read('Auth.User');
	$role = $currentUser['role_id'];
	?>
		<p>Bonjour <?php echo $currentUser['first_name']; ?></p>
	<?php
	
	if($role == 1){
	
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
	
	if($role == 2){
		?>
			<h4>Gestion des groupes</h4>
			<ul>
		<?php
			echo '<li>';
			echo $this->Html->link(__('Créer un groupe'), ['controller' => 'Groups', 'action' => 'add']);
			echo '</li>';
		?>
			</ul>
			<h4>Gestion des questionnaires</h4>
			<ul>			
				<?php
					echo '<li>';
					echo $this->Html->link(__('Lister les questionnaire'), ['controller' => 'Questionnaires', 'action' => 'index']);
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
	if (!empty($user->groups)): ?>
	
    <h4 class="subheader"><?= __('Mes Groupes') ?></h4>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Name') ?></th>
            <th><?= __('Description') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($user->groups as $groups): ?>
        <tr>
            <td><?= h($groups->name) ?></td>
            <td><?= h($groups->description) ?></td>

            <td class="actions">
				<?php
					if($role == 2){
						echo $this->Html->link(__('Editer '), ['controller' => 'Groups', 'action' => 'edit', $groups->id]);
						echo $this->Form->postLink(__('Supprimer'), ['controller' => 'Groups', 'action' => 'delete', $groups->id], ['confirm' => __('Êtes vous sûr de vouloir supprimer # {0}?', $groups->id)]);
					}
				
				?>
                <?= $this->Html->link(__('Voir'), ['controller' => 'Groups', 'action' => 'view', $groups->id]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>

</div>
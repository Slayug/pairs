<div id="pairs_panel">

<h2>Panel</h2>
<p>
<?php
	$session = $this->request->session();
	$user = $session->read('Auth.User');
	$role = $user['role_id'];
	
	
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
	
	if($role < 3){
		?>
			<h4>Gestion des groupes</h4>
			<ul>
		<?php
			echo '<li>';
			echo $this->Html->link(__('Créer un groupe'), ['controller' => 'Groups', 'action' => 'add']);
			echo '</li>';
			echo '<li>';
			echo $this->Html->link(__('Modifier un groupe'), ['controller' => 'Groups', 'action' => 'edit']);
			echo '</li>';
		?>
			</ul>
		<?php
	}
	
	if($role > 1){
		?>
			<h4>Mes Groupes</h4>
			<ul>
			
			</ul>
		<?php
		
	}
	
	
	
?>
</p>
</div>
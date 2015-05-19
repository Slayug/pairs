<div class="questionnaires view large-12 medium-12 columns">
    <h2><?= h($questionnaire->title) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Titre') ?></h6>
            <p><?= h($questionnaire->title) ?></p>
            <h6 class="subheader"><?= __('Description') ?></h6>
            <p><?= h($questionnaire->description) ?></p>
        </div>
		<?php
			$dateLimit = new DateTime($questionnaire->date_limit);
			$dateCreation = new DateTime($questionnaire->date_creation);
		?>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Date Creation') ?></h6>
            <p><?= h($dateCreation->format('d-m-Y H:i:s')) ?></p>
            <h6 class="subheader"><?= __('Date Limite') ?></h6>
            <p><?= h($dateLimit->format('d-m-Y H:i:s')) ?></p>
        </div>
    </div>
	
	<?= $this->Flash->render() ?>
	<?php
	if(!$isOwner){
		?>
		<p><?php 
			
			$currentDate = new DateTime('now');
			echo $currentDate->format('d-m-Y H:i:s');
		if($isValidated){?>
			<div class="alert alert-success">
				<p>Vous avez valider le formulaire ! <strong>Merci !</strong></p>
			</div>
		<?php
		}else{
			if($currentDate < $dateLimit){
				?>
					<div class="alert alert-warning"
						role="alert">
					<p><?= $this->Html->link(__('Répondre au questionnaire'),
											['controller' => 'Questionnaires', 'action' => 'reply', $questionnaire->id]) ?>
					</p>
					<?php
						if($hasPartialAnswer){
							?>
								<p>Vous avez commencé ce formulaire, vous devez le valider avec toutes les réponses avant la <strong>date limite !</strong></p>
							<?php
						}
					?>
					</div>
				<?php
			}else{ // date dépassée pour répondre au questionnaire
				?>
					<div class="alert alert-danger" role="alert"><p><strong>La date limite du questionnaire est dépassée.</strong></p></div>
				<?php
			}
			?></p>
			<?php
		}
	}else{
		if (!empty($usersValidated)){
			?>
			<h3>Membres ayant validés le questionnaire.</h3>
			<table style="width:375px;">
			<?php
			for($i = 0; $i < count($usersValidated); $i++){?>
				<tr>
					<td class="td_link"><?= h(ucfirst($usersValidated[$i]['last_name'])) ?></td>
					<td class="td_link"><?= h(ucfirst($usersValidated[$i]['first_name'])) ?></td>
				</tr>
			<?php
			} ?>
			</table>
			<?php
		}
	}
	?>
</div>

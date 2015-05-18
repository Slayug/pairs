<div class="questionnaires view large-12 medium-12 columns">
    <h2><?= h($questionnaire->title) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Titre') ?></h6>
            <p><?= h($questionnaire->title) ?></p>
            <h6 class="subheader"><?= __('Description') ?></h6>
            <p><?= h($questionnaire->description) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Date Creation') ?></h6>
            <p><?= h($questionnaire->date_creation) ?></p>
            <h6 class="subheader"><?= __('Date Limite') ?></h6>
            <p><?= h($questionnaire->date_limit) ?></p>
        </div>
    </div>
	<?php
	if(!$isOwner){
		?>
		<p><?php 
			$currentDate = date('Y/m/d h:i:s', time());
			echo $currentDate;
		
		if($currentDate < $questionnaire->date_limit){
			?>
				<div class="alert alert-warning" role="alert"><p><?= $this->Html->link(__('Répondre au questionnaire'), ['controller' => 'Questionnaires', 'action' => 'reply', $questionnaire->id]) ?>
				</p></div>
			<?php
		}else{ // date dépassée pour répondre au questionnaire
			?>
				<div class="alert alert-danger" role="alert"><p>La date limite du questionnaire est dépassée.</p></div>
			<?php
		}
		?></p>
		<?php
	}
	?>
</div>

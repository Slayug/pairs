<?php
$session = $this->request->session();
$currentUser = $session->read('Auth.User');
?>
<div class="panel panel-default questionnaires index large-12 medium-12 columns">
	<div class="panel-heading"><h2 class="panel-title">Liste des questionnaires</h2></div>
	<div class="panel-body">
	<?= $this->Flash->render() ?>
	<?= $this->Flash->render('auth') ?>
	<div id="accordion">
    <?php foreach ($questionnaires as $questionnaire): ?>
		<h3><?= h($questionnaire->title) ?></h3>
		<div>
        <p>Description: <?= h($questionnaire->description) ?></p>
        <ul	class="actions">
				<li><?= $this->Html->link(__('Copier'), ['action' => 'copy', $questionnaire->id]) ?></li>
				<?php
				if($questionnaire->_matchingData['Owners']->id == $currentUser['id']){?>
					<li><?= $this->Html->link(__('Editer'), ['action' => 'edit', $questionnaire->id]) ?></li>
					<li><?= $this->Form->postLink(__('Supprimer'), ['action' => 'delete', $questionnaire->id], ['confirm' => __('Are you sure you want to delete # {0}?', $questionnaire->id)]) ?></li>
				<?php
				}
				?>
        </ul>
		</div>
    <?php endforeach; ?>
	</div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
</div>
<script>
$( "#accordion" ).accordion();
</script>
 
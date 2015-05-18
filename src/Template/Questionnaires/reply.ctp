<div class="questionnaires questionnaires_reply view large-12 medium-12 columns">
	
    <h2><?= h($questionnaire->title) ?></h2>
	<?= $this->Flash->render() ?>
    <?= $this->Form->create($questionnaire, ['id' => 'questionnaire_add']); ?>
    <form action="">
			<?php
			foreach ($users as $user): ?>
				<h3>Évaluation pour l'étudiant(e): <?php echo h($user['first_name'] . ' ' . $user['last_name']); ?></h3>
				<div class="questions_reply">
				<?php
				foreach($questions as $question):?>
					<h5><?php echo h($question['content']); ?></h5>
					<div class="answers_reply">
					<?php
					foreach($question['answers'] as $answer):?>
						<label for="<?php echo h($user['id'] . '-' . $question['id'] . '-' . $answer['id']); ?>"><?php echo h($answer['value']); ?></label>
						<input	type="radio"
								name="<?php echo h($user['id'] . '-' . $question['id']); ?>"
								id="<?php echo h($user['id'] . '-' . $question['id'] . '-' . $answer['id']); ?>"
								value="<?php echo h($user['id'] . '-' . $question['id'] . '-' . $answer['id']); ?>"></input><br/>
					<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
	</form>
</div>

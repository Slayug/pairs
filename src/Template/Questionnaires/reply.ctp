<div class="questionnaires view large-12 medium-12 columns">
	
    
	<?= $this->Flash->render() ?>
    <?= $this->Form->create($questionnaire, ['id' => 'questionnaire_reply']); ?>
		<fieldset>
		<legend><h2><?= h($questionnaire->title) ?></h2></legend>
		<?php
		foreach ($users as $user): ?>
			<h3>Évaluation pour l'étudiant(e): <?php echo h(ucfirst($user['first_name']) . ' ' . ucfirst($user['last_name'])); ?></h3>
			<fieldset>
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
							value="<?php echo h($answer['id']); ?>"></input><br/>
				<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
			</div>
			</fieldset>
		<?php endforeach; ?>
		</fieldset>
		<button type="submit">Valider</button>
		<button onclick="saveSubmit()" type="submit">Sauvegarder & Continuer</button>
    <?= $this->Form->end() ?>
</div>

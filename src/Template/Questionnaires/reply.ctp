<div class="questionnaires view large-12 medium-12 columns">
	
    <?= $this->Form->create($questionnaire, ['id' => 'questionnaire_reply']); ?>
		<fieldset><?= $this->Flash->render() ?>
		<legend><h2><?= h($questionnaire->title) ?></h2></legend>
		<?php
		$nbreQuestion = 0;
		foreach ($users as $user): ?>
			<h3>Évaluation pour l'étudiant(e): <?php echo h(ucfirst($user['first_name']) . ' ' . ucfirst($user['last_name'])); ?></h3>
			<fieldset>
			<div class="questions_reply">
			<?php
			foreach($questions as $question):
				$nbreQuestion++;?>
				<h5><?php echo h($question['content']); ?></h5>
				<div class="answers_reply">
				<?php
				foreach($question['answers'] as $answer):?>
					<label for="<?php echo h($user['id'] . '-' . $question['id'] . '-' . $answer['id']); ?>"><?php echo h($answer['value']); ?></label>
					<input	type="radio"
							name="<?php echo h($user['id'] . '-' . $question['id']); ?>"
							id="<?php echo h($user['id'] . '-' . $question['id'] . '-' . $answer['id']); ?>"
							value="<?php echo h($answer['id']); ?>"
							<?php
								if(array_key_exists($user['id'] . '-' . $question['id'], $answersPartials)){
									if($answersPartials[$user['id'] . '-' . $question['id']] == $answer['id']){
										echo 'checked="checked"';
									}
								}
							?>
							></input><br/>
				<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
			</div>
			</fieldset>
		<?php endforeach;
		$this->request->session()->write('nbreQuestion', $nbreQuestion);
		
		?>
		<div id="save-or-not"></div>
		</fieldset>
		<button type="submit">Valider</button>
		<button onclick="saveSubmit()" type="submit">Sauvegarder & Continuer</button>
    <?= $this->Form->end() ?>
</div>

<div class="questionnaires form large-12 medium-12 columns">
	<?= $this->Flash->render() ?>
    <?= $this->Form->create($questionnaire, ['id' => 'questionnaire_add']); ?>
    <fieldset>
        <legend><?= __('Ajouter un Questionnaire') ?></legend>
        <?php
            echo $this->Form->input('title', ['label' => 'Titre:']);
            echo $this->Form->input('description', ['label' => 'Description:']);
            //echo $this->Form->input('date_creation', array('class' => 'date'));
            //echo $this->Form->input('date_limit', array('class' => 'date'));
			?>
			
			
			<div class="input-append date form_datetime_creation">
				<label for="date_creation">Date de début:</label>
				<input size="16" type="text" value="" readonly id="date_creation" name="date_creation">
				<span class="add-on"><i class="icon-th"></i></span>
			</div>
			
			<div class="input-append date form_datetime_limit">
				<label for="date_limit">Date de fin:</label>
				<input size="16" type="text" value="" readonly id="date_limit" name="date_limit">
				<span class="add-on"><i class="icon-th"></i></span>
			</div>
 
			<div id="agent-question-answer"class="col-md-6">
				<div class="col-md-10">
					<?php
						echo $this->Form->input('questions._ids', ['options' => $questions,
																	'label' => 'Questions:',
																	'id' => 'questions',
																	'onclick' => 'changeSelectMode(0)']);
																	
						?>
							<div class="input-append form_add">
								<input id="add-question" size="16" type="text" placeholder="Nouvelle question ?">
								<span onclick="addElement('question')" class="add-on"><i class="icon-add"></i></span>
							</div>
						<?php
						
						echo $this->Form->input('answers._ids', ['options' => $answers,
																	'label' => 'Réponses:',
																	'id' => 'answers',
																	'onclick' => 'changeSelectMode(1)']);
																	
						?>
						<div class="input-append form_add">
							<input id="add-answer" size="16" type="text" placeholder="Nouvelle réponse ?">
							<span onclick="addElement('answer')" class="add-on"><i class="icon-add"></i></span>
						</div>
				</div>
				<div class="col-md-2 switch-question">
					<button onclick="arrowRight()" type="button" class="btn btn-default btn-lg arrow-right">
						<span class="glyphicon glyphicon-circle-arrow-right" ></span>
					</button>
					<!-- <button onclick="arrowLeft()" type="button" class="btn btn-default btn-lg arrow-left">
						<span class="glyphicon glyphicon-circle-arrow-left" ></span>
					</button> -->
				</div>
			</div>
			<div id="questions-questionnaires" class="col-md-6">
				<h3>Questions:<h3>
			</div>
			
			<div id="questions_submit" style="display:none;"></div>
			<script type="text/javascript">
				$(".form_datetime_creation").datetimepicker({
					format: "dd MM yyyy - hh:ii",
					autoclose: true,
					todayBtn: true,
					language: 'fr'
				});
				$(".form_datetime_limit").datetimepicker({
					format: "dd MM yyyy - hh:ii",
					autoclose: true,
					todayBtn: true,
					language: 'fr'
				});
			</script>
			
			
    </fieldset>
    <?= $this->Form->end() ?>
	
	<button type="submit" onclick="submitQuestionnaireAdd()" type="button">Valider</button>
</div>

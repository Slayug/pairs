<div class="questionnaires form large-12 medium-12 columns">
    <?= $this->Form->create($questionnaire); ?>
    <fieldset>
        <legend><?= __('Ajouter un Questionnaire') ?></legend>
        <?php
            echo $this->Form->input('title', ['label' => 'Titre:']);
            echo $this->Form->input('description', ['label' => 'Description:']);
            //echo $this->Form->input('date_creation', array('class' => 'date'));
            //echo $this->Form->input('date_limit', array('class' => 'date'));
			?>
			
			
			<div class="input-append date form_datetime_begin">
				<label for="date_begin">Date de début:</label>
				<input size="16" type="text" value="" readonly id="date_begin" name="date_begin">
				<span class="add-on"><i class="icon-th"></i></span>
			</div>
			
			<div class="input-append date form_datetime_end">
				<label for="date_end">Date de fin:</label>
				<input size="16" type="text" value="" readonly id="date_end" name="date_end">
				<span class="add-on"><i class="icon-th"></i></span>
			</div>
 
			<div id="agent-question-answer">
				<div class="col-md-5">
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
				<div class="col-md-1 switch-question">
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
			
			<?php
			echo $this->Form->input('questions_._ids', ['options' => $questions,
																'label' => 'Questions:',
																'type' => 'hidden']);
			?>
			<script type="text/javascript">
				$(".form_datetime_begin").datetimepicker({
					format: "dd MM yyyy - hh:ii",
					autoclose: true,
					todayBtn: true,
					language: 'fr'
				});
				$(".form_datetime_end").datetimepicker({
					format: "dd MM yyyy - hh:ii",
					autoclose: true,
					todayBtn: true,
					language: 'fr'
				});
			</script>
			
			
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

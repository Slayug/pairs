
<div class="questionnaires form large-10 medium-10 columns">
    <?= $this->Form->create($questionnaire); ?>
    <fieldset>
        <legend><?= __('Ajouter un Questionnaire') ?></legend>
        <?php
            echo $this->Form->input('title');
            echo $this->Form->input('description');
            //echo $this->Form->input('date_creation', array('class' => 'date'));
            //echo $this->Form->input('date_limit', array('class' => 'date'));
			?>
			
			<script>
				 $(function() {
					$( "#date_begin" ).datepicker();
					$( "#date_end" ).datepicker();
				 });
			</script>
			
			<label for="date_begin">Date de début:</label>
			<input type="text" id="date_begin" name="date_begin">
			
			<label for="date_end">Date de fin:</label>
			<input type="text" id="date_end" name="date_end">
			
			<?php
			
            echo $this->Form->input('questions._ids', ['options' => $questions]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>


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
 
			<script type="text/javascript">
				$(".form_datetime_begin").datetimepicker({
					format: "dd MM yyyy - hh:ii",
					autoclose: true,
					todayBtn: true
				});
				$(".form_datetime_end").datetimepicker({
					format: "dd MM yyyy - hh:ii",
					autoclose: true,
					todayBtn: true
				});
			</script>
			
			<?php
			
            echo $this->Form->input('questions._ids', ['options' => $questions]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

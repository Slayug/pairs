<div class="panel panel-default questionnaires view large-12 medium-12 columns">
<div class="panel-heading"><h2 class="panel-title"><?= h($questionnaire->title) ?></h2></div>
	<div class="panel-body">
		<p>Description: <?= $questionnaire->description ?></p>
		<?php
			foreach($questions as $question){
				echo '<h4>' . $question['content'] . '</h4>';
				echo '<ul>';
					foreach($question['answers'] as $answer){
						echo '<li>' . $answer['value'] . '</li>';
					}
				echo '</ul>';			
			}
		?>
	</div>
</div>
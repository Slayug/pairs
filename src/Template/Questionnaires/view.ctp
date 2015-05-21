<div class="panel panel-default questionnaires view large-12 medium-12 columns">
    <div class="panel-heading"><h2 class="panel-title"><?= h($questionnaire->title) ?></h2></div>
<div class="panel-body">
    <div class="row">
		<fieldset>
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Titre') ?></h6>
            <p><?= h($questionnaire->title) ?></p>
            <h6 class="subheader"><?= __('Description') ?></h6>
            <p><?= h($questionnaire->description) ?></p>
        </div>
		<?php
			$dateLimit = new DateTime($questionnaire->date_limit);
			$dateCreation = new DateTime($questionnaire->date_creation);
		?>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Date Création') ?></h6>
            <p><?= h($dateCreation->format('d-m-Y H:i:s')) ?></p>
            <h6 class="subheader"><?= __('Date Limite') ?></h6>
            <p><?= h($dateLimit->format('d-m-Y H:i:s')) ?></p>
        </div>
		</fieldset>
    </div>
	
	<?= $this->Flash->render() ?>
	<?php
	if(!$isOwner){
		?>
		<p><?php
			$currentDate = new DateTime('now');
			echo $currentDate->format('d-m-Y H:i:s');
		if($isValidated){?>
			<div class="alert alert-success">
				<p>Vous avez validé le formulaire ! <strong>Merci !</strong></p>
			</div>
		<?php
		}else{
			if($currentDate < $dateLimit){
				?>
					<div class="alert alert-warning"
						role="alert">
					<p><?= $this->Html->link(__('Répondre au questionnaire'),
											['controller' => 'Questionnaires', 'action' => 'reply', $questionnaire->id]) ?>
					</p>
					<?php
						if($hasPartialAnswer){
							?>
								<p>Vous avez commencé ce formulaire, vous devez le valider avec toutes les réponses avant la <strong>date limite !</strong></p>
							<?php
						}
					?>
					</div>
				<?php
			}else{ // date dépassée pour répondre au questionnaire
				?>
					<div class="alert alert-danger" role="alert"><p><strong>La date limite du questionnaire est dépassée.</strong></p></div>
				<?php
			}
			?></p>
			<?php
		}
	}else{ // !isOwner
		if (!empty($usersValidated)){
			?>
			<h3>Membres ayant validés le questionnaire:</h3>
			<table style="width:320px;">
			<?php
			for($i = 0; $i < count($usersValidated); $i++){?>
				<tr>
					<td class="td_link"><?= h(ucfirst($usersValidated[$i]['last_name'])) ?></td>
					<td class="td_link"><?= h(ucfirst($usersValidated[$i]['first_name'])) ?></td>
				</tr>
			<?php
			} ?>
			</table>
			
			<h3>Stats du Module:</h3>
			<?php
				if(!empty($groupsStats)){?>
					<script type="text/javascript">
						var options = {
							//Boolean - Whether we should show a stroke on each segment
							segmentShowStroke : true,
							//String - The colour of each segment stroke
							segmentStrokeColor : "#fff",
							//Number - The width of each segment stroke
							segmentStrokeWidth : 2,
							//Number - The percentage of the chart that we cut out of the middle
							percentageInnerCutout : 50, // This is 0 for Pie charts
							//Number - Amount of animation steps
							animationSteps : 1,
							//String - Animation easing effect
							animationEasing : "easeOutBounce",
							//Boolean - Whether we animate the rotation of the Doughnut
							animateRotate : true,
							//Boolean - Whether we animate scaling the Doughnut from the centre
							animateScale : false,
							//String - A legend template
							legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"

						};
					</script>
					<?php
					// permettant d'associer des couleurs aux questions
					$colors =	[
								0 => [
									'color'=>'#e16244',
									'highlight'=>'#dd735a'
									],
								1 => [
									'color'=>'#46BFBD',
									'highlight'=>'#5AD3D1'
									],
								2 => [
									'color'=>'#FDB45C',
									'highlight'=>'#FFC870'
									],
								3 => [
									'color'=>'#F7464A',
									'highlight'=>'#FF5A5E'
									],
								4 => [
									'color'=>'#4af146',
									'highlight'=>'#6feb6c'
									],
								5 => [
									'color'=>'#ec43c2',
									'highlight'=>'#e55cc3'
									]
								];
					$idDonut = 0;
					foreach($groupsStats as $group){?>
						<a href="#<?= $group['name']; ?>">> <?= $group['name']; ?></a><br>
					<?php
					}
					foreach($groupsStats as $group){
					$usersStats = $group['usersStats'];
					echo '<a name="' . $group['name'] . '"><h4>' . $group['name'] . '</h4></a><fieldset>';
					for($i = 0; $i < count($usersStats); $i++){
						?>
						<h5><?= ucfirst($usersStats[$i]['user']['first_name']) . ' ' . ucfirst($usersStats[$i]['user']['last_name']) ?></h5>
						<fieldset>
						<?php
						foreach($usersStats[$i]['questions'] as $question){
							$legend = array();
						?>
							<div class="chart-questionnaire col-md-3">
								<h6 style="height:45px;"><?= $question['content'] ?></h6>
								<canvas id="<?php echo 'ctx_' . $idDonut; ?>" width="200" height="200"></canvas>
								<script type="text/javascript">
									var dataDoughnut_<?php echo $idDonut; ?> = [
										<?php
										for($a = 0; $a < count($question['answers']); $a++){
											?>
											{
											<?php
												echo 'value:' . count($question['answers'][$a]['users']);
												echo ',color:"' . $colors[$a]['color'];
												echo '",highlight:"' . $colors[$a]['highlight'] . '",';
											?>
												label: "<?= $question['answers'][$a]['value'] ?>"
											}
											<?php
											if($a < count($question['answers']) - 1){
												echo ',';
											}
										}
										?>
										];
									var ctx_<?php echo $idDonut; ?> = document.getElementById("ctx_<?php echo $idDonut; ?>").getContext("2d");
									var doughnut_<?php echo $idDonut; ?> = new Chart(ctx_<?php echo $idDonut; ?>).Doughnut(dataDoughnut_<?php echo $idDonut; ?>,options);
								</script>
								<ul>
									<?php
									for($a = 0; $a < count($question['answers']); $a++){
									?>
										<li><div class="cube" style="background-color:<?= $colors[$a]['color'] ?>"></div>
										<span class="chart-li"><?= $question['answers'][$a]['value'] . ' (' . count($question['answers'][$a]['users']) . ')' ?></span>
										</li>
									<?php
									}
									$idDonut++; ?>
								</ul>
							</div>
							
						<?php
						}
						?>
						</fieldset>
						<?php
					}//usersStats end
					?>
					</fieldset>
					<?php
					}//groupsStats end
				}
			?>
			<?php
		}else{ // !usersValidated
			?>
				<div class="col-md-12">
					<p>
						Aucun membre a terminé le questionnaire.
					</p>
				</div>
			<?php
		}
	}
	?>
</div>

</div>
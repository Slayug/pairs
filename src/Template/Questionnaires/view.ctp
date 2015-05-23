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
						role="alert"><p><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> <?= $this->Html->link(__('Répondre au questionnaire'),
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
									],
								6 => [
									'color'=>'#e1f220',
									'highlight'=>'#e7f54c'
									],
								7 => [
									'color'=>'#ea6504',
									'highlight'=>'#e3701b'
									],
								8 => [
									'color'=>'#1f1be8',
									'highlight'=>'#322eef'
									],
								9 => [
									'color'=>'#2bc308',
									'highlight'=>'#38c617'
									],
								10 => [
									'color'=>'#871080',
									'highlight'=>'#901f89'
									],
								11 => [
									'color'=>'#7a7a7a',
									'highlight'=>'#888888'
									], //colors random
								12 => [ 'color'=>'F353FA', 'highlight'=>'F353B6'],
								13 => [ 'color'=>'59F27D', 'highlight'=>'59F279'],
								14 => [ 'color'=>'29C744', 'highlight'=>'29C744'],
								15 => [ 'color'=>'A9821D', 'highlight'=>'A98219'],
								16 => [ 'color'=>'A684D0', 'highlight'=>'A68490'],
								17 => [ 'color'=>'07D4F9', 'highlight'=>'07D4B5'],
								18 => [ 'color'=>'DF4288', 'highlight'=>'DF4288'],
								19 => [ 'color'=>'943CB9', 'highlight'=>'943C75'],
								20 => [ 'color'=>'9032D2', 'highlight'=>'903292'],
								21 => [ 'color'=>'08A89E', 'highlight'=>'08A85A'],
								22 => [ 'color'=>'5EEC8B', 'highlight'=>'5EEC87'],
								23 => [ 'color'=>'758B21', 'highlight'=>'758B21'],
								24 => [ 'color'=>'F58226', 'highlight'=>'F58226'],
								25 => [ 'color'=>'91B2A1', 'highlight'=>'91B261'],
								26 => [ 'color'=>'F9DA8F', 'highlight'=>'F9DA8B'],
								27 => [ 'color'=>'8FB2A8', 'highlight'=>'8FB268'],
								28 => [ 'color'=>'28D72D', 'highlight'=>'28D729'],
								29 => [ 'color'=>'E55765', 'highlight'=>'E55765'],
								30 => [ 'color'=>'F54FCB', 'highlight'=>'F54F87'],
								31 => [ 'color'=>'F6F672', 'highlight'=>'F6F672'],
								32 => [ 'color'=>'5D45FD', 'highlight'=>'5D45B9'],
								33 => [ 'color'=>'59AB1F', 'highlight'=>'59AB1B'],
								34 => [ 'color'=>'958080', 'highlight'=>'958080'],
								35 => [ 'color'=>'2EAAD4', 'highlight'=>'2EAA94'],
								36 => [ 'color'=>'B921E9', 'highlight'=>'B921A5'],
								37 => [ 'color'=>'00F1F1', 'highlight'=>'00F1B1'],
								38 => [ 'color'=>'1DD004', 'highlight'=>'1DD004'],
								39 => [ 'color'=>'3CE301', 'highlight'=>'3CE301'],
								40 => [ 'color'=>'9FBE35', 'highlight'=>'9FBE35'],
								41 => [ 'color'=>'5E8D32', 'highlight'=>'5E8D32'],
								42 => [ 'color'=>'A2737A', 'highlight'=>'A27376'],
								43 => [ 'color'=>'74134D', 'highlight'=>'741349'],
								44 => [ 'color'=>'333026', 'highlight'=>'333026'],
								45 => [ 'color'=>'678333', 'highlight'=>'678333'],
								46 => [ 'color'=>'A7AE27', 'highlight'=>'A7AE27'],
								47 => [ 'color'=>'2950CD', 'highlight'=>'295089'],
								48 => [ 'color'=>'DAECF0', 'highlight'=>'DAECB0'],
								49 => [ 'color'=>'80581A', 'highlight'=>'805816']
								];
					$colorsAnswers = array();
					$idColors = 0;
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
							<div class="chart-questionnaire col-sm-6 col-md-3">
								<h6 style="height:45px;"><?= $question['content'] ?></h6>
								<canvas id="<?php echo 'ctx_' . $idDonut; ?>" width="200" height="200"></canvas>
								<script type="text/javascript">
									var dataDoughnut_<?php echo $idDonut; ?> = [
										<?php
										for($a = 0; $a < count($question['answers']); $a++){
											?>
											{
											<?php
											
												//gestion couleurs
												if(!array_key_exists($question['answers'][$a]['id'], $colorsAnswers)){
													$colorsAnswers[$question['answers'][$a]['id']] = $idColors++;
												}
											
												echo 'value:' . count($question['answers'][$a]['users']);
												$idColor = $colorsAnswers[$question['answers'][$a]['id']];
												echo ',color:"' . $colors[$idColor]['color'];
												echo '",highlight:"' . $colors[$idColor]['highlight'] . '",';
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
										$idColor = $colorsAnswers[$question['answers'][$a]['id']];
										?>
										<li><div class="cube" style="background-color:<?= $colors[$idColor]['color'] ?>"></div>
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
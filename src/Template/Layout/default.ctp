<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('bootstrap.css') ?>
    <?= $this->Html->css('dashboard.css') ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('style.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
		<div id="pairs_header">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<h2>Évaluation par les pairs.</h2>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right" class="text_shadow_white">
				
					<?php
						$session = $this->request->session();
						$user = $session->read('Auth.User');
						$current_page = $this->request->here();
						$current_page_class = '<li class ="li_current_page">';
					
						if($current_page == '/pairs/'){
							echo $current_page_class;
						}else{
							echo '<li>';
						}
						echo $this->Html->link(__('Accueil'), ['controller' => 'Pages', 'action' => 'index']);
						echo '</li>';
					
						
						if($user != null){
							if(strstr($current_page, 'panel')){
								echo $current_page_class;
							}else{
								echo '<li>';
							}
							echo $this->Html->link(__('Panel'), ['controller' => 'Users', 'action' => 'panel']);
							echo '</li>';
							echo '<li>';
							echo $this->Html->link(__('Deconnexion'), ['controller' => 'Users', 'action' => 'logout']);
							echo '</li>';					
						}else{
							if(strstr($current_page, 'login')){
								echo $current_page_class;
							}else{
								echo '<li>';
							}
							echo $this->Html->link(__('Connexion'), ['controller' => 'Users', 'action' => 'login']);
							echo '</li>';
						}
						
						
						if(strstr($current_page, 'faq')){
							echo $current_page_class;
						}else{
							echo '<li>';
						}
						echo $this->Html->link(__('FAQ'), ['controller' => 'Faq', 'action' => 'index']);
					?>
					</li>

				</ul>
			</div>
		</div>
      </div>
    </nav>

    <div class="container theme-showcase" role="main">
         <?= $this->fetch('content') ?>
	</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<?php echo $this->Html->script('bootstrap.min'); ?>
	<?php echo $this->Html->script('holder.js'); ?>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<?php echo $this->Html->script('ie10-viewport-bug-workaround.js'); ?>
	<?php echo $this->fetch("script"); ?>
</body>
</html>

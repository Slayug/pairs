<?php

	$session = $this->request->session();
	$currentUser = $session->read('Auth.User');
	$role = $currentUser['role_id'];

?>
<div class="groups view large-12 medium-12 columns">

</div>
<div class="related row">
    <div class="column large-12">
    </div>
</div>

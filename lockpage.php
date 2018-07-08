<?php
	$id = mysqli_real_escape_string($_MS_ID, $_GET['uid']);
	$hash = mysqli_real_escape_string($_MS_ID, $_GET['hash']);

	if($hash == md5("6362551" . $id . "vnPn801msHma6MzcJ4a3")){
		if(mysqli_get_query("SELECT * FROM `users` WHERE `vkId` = '{$id}' AND `group` = 'admin';")){
			$_SESSION['unlock'] = 'unlock';
			redirect('/');
			return;
		}
	}

?>


<div class="container">
	<div class="row main" style="margin-top: 170px;">
		<div class="panel-heading">
           <div class="panel-title text-center">
		        <img src="./design/img/maintenance.png">
           		<h1>Приносим свои извинения!</h1>
           		<br />
           		<h4><?=$siteSettings['offlineMessage']?></h4>
           		<br />
           		<!-- <h8><a onclick="$('#authModal').modal('show');">Войти</a></h8> -->
           	</div>
        </div> 
	</div>
</div>
<script type="text/javascript">
  VK.init({apiId: 6362551});
</script>

<div class="modal fade" id='authModal'>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      	<h3 class="modal-title text-center">Вход</h3>
      </div>
      <div class="modal-body">
        <center>
        	<div id="vk_auth"></div>
        </center>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	VK.Widgets.Auth("vk_auth", {"authUrl":"/"});
</script>
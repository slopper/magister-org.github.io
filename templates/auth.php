<?php 
  include_once($_SERVER['DOCUMENT_ROOT']."/main/config.php");
  include_once($_SERVER['DOCUMENT_ROOT']."/main/functions.php");
?>

<div class="container">
	<center>
		<script type="text/javascript">
		  VK.init({apiId: 6362551});
		</script>
		<div class="row">
			<div id="vk_auth"></div>
			<div class="row">
				<span id="vk_auth_respounce" class="label" style="font-size: 16px;"></span>
			</div> 
			<div class="row" style="margin-top:20px;">
				<span id="vk_info" class="label" style="font-size: 11px;">Перенаправление в личный кабинет...</span>
			</div>
		</div>

		<script type="text/javascript">
		$('#vk_info').hide();
		VK.Widgets.Auth("vk_auth", {onAuth: function(data) {
		 	$.ajax({
			  method: "POST",
			  url: "/main/ajax/auth.php",
			  dataType: 'json',
			  data: { id: data['uid'], name: data['first_name'] + ' ' + data['last_name'], s: data['hash'] }
			}).done(function( respounce ) {
			    if(respounce.error == 1){
			    	$('#vk_auth_respounce').addClass('label-warning');
			    	$('#vk_auth_respounce').text("" + respounce.error_message);
			    }else{
			    	$('#vk_auth_respounce').addClass('label-success');
			    	$('#vk_auth_respounce').text("" + respounce.message);
			    	$('#vk_info').show();
			    	setTimeout( 'location="/account";', 2500 );
			    }
			    $('#vk_auth').hide();
			});
		} });
		</script>

	</center>
</div>
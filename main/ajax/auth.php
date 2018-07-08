<?php
	if($_SERVER['REQUEST_METHOD'] != "POST") exit("Only for AJAX request.");

	include($_SERVER['DOCUMENT_ROOT']."/main/config.php");
	include($_SERVER['DOCUMENT_ROOT']."/main/functions.php");

	$id = mysqli_real_escape_string($_MS_ID, $_POST['id']);

	$name = mysqli_real_escape_string($_MS_ID, $_POST['name']);
	$name = str_replace("<", "", $name);
	$name = str_replace(">", "", $name);

	$hash = mysqli_real_escape_string($_MS_ID, $_POST['s']);

	$res = [];
	if($hash == md5("6362551" . $id . "vnPn801msHma6MzcJ4a3")){
		$user = mysqli_get_query("SELECT * FROM `users` WHERE `vkId` = '{$id}';");
		if($user){
			$_SESSION['uId'] = $user['id'];
			$_SESSION['userIP'] = getUserIP();
			$res['error'] = 0;
			$res['message'] = 'Авторизация прошла успешно.';

		}else{
			if(mysqli_query($_MS_ID, "INSERT INTO `users`(`vkId`, `vkName`) VALUES ('{$id}', '{$name}');")){
				$user = mysqli_get_query("SELECT * FROM `users` WHERE `vkId` = '{$id}';");
				$_SESSION['uId'] = $user['id'];
				$_SESSION['userIP'] = getUserIP();
				$res['error'] = 0;
				$res['message'] = 'Регистрация прошла успешно.';
			}else{
				$res['error'] = 1;
				$res['error_message'] = 'Ошибка при регистрации.';
			}
		}
		if($res['error'] == 0){
			$isMember = json_decode(vk_send('groups.isMember', array('group_id' => 'samp_products', 'user_id' => $id)))->response; //['response']
			mysqli_query($_MS_ID, "UPDATE `users` SET `isInGroup` = '{$isMember}' WHERE `id` = '{$_SESSION['uId']}' AND `vkId` = '{$id}';");

		}

	}
	else{
		$res['error'] = 1;
	}


	die(json_encode($res));
?>
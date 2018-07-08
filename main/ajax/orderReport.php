<?php 
	if($_SERVER['REQUEST_METHOD'] != "POST") exit("Only for AJAX request.");

	include($_SERVER['DOCUMENT_ROOT']."/main/config.php");
	include($_SERVER['DOCUMENT_ROOT']."/main/functions.php");

	$user = getUserInfo();

	if(!$user) exit('Вы не авторизованны.');

	if($user['isInGroup'] != '1'){
		die(json_encode(array('type' => 'warning', 'message' => 'Чтобы отправить жалобу вы должны быть подписаны на нашу группу в ВК (https://vk.com/samp_products).<br> Подпишитесь и перезайдите на сайт.')));
	}

	$id = mysqli_real_escape_string($_MS_ID, $_POST['id']);
	$order = mysqli_get_query("SELECT * FROM `orders` WHERE `userId` = {$user['id']} AND `id` = {$id}");
	if($order){
		if($order['status'] == 0){
			die(json_encode(array('type' => 'info', 'message' => 'Сначало получите свой заказ.')));
		}
		if(mysqli_get_query("SELECT * FROM `order_report` WHERE `userId` = {$user['id']} AND `orderId` = {$id}")){
			die(json_encode(array('type' => 'info', 'message' => 'Вы уже жаловались на этот заказ.')));
		}

		$message = 'Флуд в логах.';

		if($_POST['type'] == '1')
			$message = 'Логам больше 2-ух дней';
		if($_POST['type'] == '2')
			$message = 'Некачественные логи.';

		mysqli_query($_MS_ID,"INSERT INTO `order_report`(`orderId`, `userId`, `message`) VALUES ('{$id}', '{$user['id']}', '{$message}');");
		die(json_encode(array('type' => 'success', 'message' => 'Жалоба отправлена на рассмотрение, о результате мы оповестим вас в ВК.')));

	}

	die(json_encode(array('type' => 'danger', 'message' => 'Ошибка.')));
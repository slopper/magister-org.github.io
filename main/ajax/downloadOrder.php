<?php 

	include($_SERVER['DOCUMENT_ROOT']."/main/config.php");
	include($_SERVER['DOCUMENT_ROOT']."/main/functions.php");

	$user = getUserInfo();

	if(!$user) exit('Вы не авторизованны в личном кабинете.');


	$order_id = mysqli_real_escape_string($_MS_ID, $_GET['order']);

    $order = mysqli_get_query("SELECT * FROM `orders` WHERE `id` = '{$order_id}' AND `userId` = '{$user['id']}'");

    if(!$order) return;

    if($order['status'] == 1){
        $lines = getOrderList($order_id);
        header('Content-type: application/octet-stream');    
        header('Content-Disposition: attachment; filename="logs_'.$order_id.'.txt"');
        print $lines;
        exit;
    }else{
        echo "Чтобы скачать заказ его нужно сначала получить.";
    }
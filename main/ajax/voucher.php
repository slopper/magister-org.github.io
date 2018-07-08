<?php
	if($_SERVER['REQUEST_METHOD'] != "POST") exit("Only for AJAX request.");

	include($_SERVER['DOCUMENT_ROOT']."/main/config.php");
	include($_SERVER['DOCUMENT_ROOT']."/main/functions.php");

	if(!checkReCaptcha($_POST['c']))
		die('Ошибка');

	$user = getUserInfo();
	if(!$user) exit('Вы не авторизованны.');

	$key = mysqli_real_escape_string($_MS_ID, $_POST['key']);

	$voucher = mysqli_get_query("SELECT * FROM `vouchers` WHERE `voucher` = '{$key}' AND `activeCount` > 0;");
    
	if(!$voucher)
		die('Купон не найден или закончился.');

	if(mysqli_get_query("SELECT * FROM `vouchers_log` WHERE `voucherId` = '{$voucher['id']}' AND `userId` = '{$user['id']}';"))
		die('Вы уже активировали этот купон ранее!');

	mysqli_query($_MS_ID, "UPDATE `users` SET `balance` = `balance` + '{$voucher['balance']}' WHERE `id` = {$user['id']};");
	mysqli_query($_MS_ID, "UPDATE `vouchers` SET `activeCount` = `activeCount` - 1 WHERE `id` = {$voucher['id']};");
	mysqli_query($_MS_ID, "INSERT INTO `vouchers_log`(`voucherId`, `userId`) VALUES ('{$voucher['id']}', '{$user['id']}');");

	die("Вы получили на баланс " . $voucher['balance'] . "руб.");
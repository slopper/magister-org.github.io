<?php
	if($_SERVER['REQUEST_METHOD'] != "POST") exit("Only for AJAX request.");

	include($_SERVER['DOCUMENT_ROOT']."/main/config.php");
	include($_SERVER['DOCUMENT_ROOT']."/main/functions.php");

	if(!checkReCaptcha($_POST['g-recaptcha-response'])){
		$data = json_encode(array('errorMsg' => 'Докажите, что вы не робот.', 'idOrder' => $idOrder), JSON_UNESCAPED_UNICODE);
		die($data);
	}

	$userInfo = getUserInfo();
	if(!$userInfo){
		$data = json_encode(array('errorMsg' => 'Авторизуйтесь, чтобы совершить покупку.', 'idOrder' => $idOrder), JSON_UNESCAPED_UNICODE);
		die($data);
	}

	$idCategory = mysqli_real_escape_string($_MS_ID, $_POST['id']);
	$countUser = mysqli_real_escape_string($_MS_ID, $_POST['count']);
	$userId = mysqli_real_escape_string($_MS_ID, $userInfo['id']);

	$categoryInfo = "SELECT * FROM `category` WHERE `id` = '{$idCategory}';";
	$categoryInfo = mysqli_get_query($categoryInfo);
	
	if(is_null($categoryInfo)) $error = "Неизвестная ошибка, попробуйте позже.";
	else if($countUser < min($categoryInfo['minCount'],$categoryInfo['count']) || $countUser == 0) $error = "Минимальное количество для заказа не может быть меньше ". min($categoryInfo['minCount'],$categoryInfo['count']) ." шт.";
	else if($countUser > $categoryInfo['count']) $error = "Неверное количество товара, максимально доступно — ".$categoryInfo['count']." шт.";
	else {
		$price = $categoryInfo['priceRub'];
		$price = $countUser * $price;

		if(isset($_POST['promo']) && strlen($_POST['promo']) > 2)
		{
			$promo = mysqli_real_escape_string($_MS_ID, $_POST['promo']);
			$promo = mysqli_get_query("SELECT * FROM `promoCodes` WHERE `text` = '{$promo}' AND `activeCount` > 0;");
		    
			if(!$promo)
			{
				$data = json_encode(array('errorMsg' => 'Этот купон не найден или закончился.', 'idOrder' => $idOrder), JSON_UNESCAPED_UNICODE);
				die($data);
			}

			if(mysqli_get_query("SELECT * FROM `promoCodes_log` WHERE `promoId` = '{$promo['id']}' AND `userId` = '{$userInfo['id']}';"))
			{
				$data = json_encode(array('errorMsg' => 'Вы уже использовали этот купон.', 'idOrder' => $idOrder), JSON_UNESCAPED_UNICODE);
				die($data);
			}

			$price = floor($price * ((100 - $promo['discount']) / 100));

			if($userInfo['balance'] < floor($price)){
				$data = json_encode(array('errorMsg' => "На покупку вам не хватает " . floor(($price - $userInfo['balance'])) . " руб. С учётом " . $promo['discount'] . "% скидки.", 'idOrder' => $idOrder), JSON_UNESCAPED_UNICODE);
				die($data);
			}

			mysqli_query($_MS_ID, "UPDATE `promoCodes` SET `activeCount` = `activeCount` - 1 WHERE `id` = {$promo['id']};");
			mysqli_query($_MS_ID, "INSERT INTO `promoCodes_log`(`promoId`, `userId`) VALUES ('{$promo['id']}', '{$userInfo['id']}');");
		}

		$list = mysqli_query($_MS_ID, "SELECT * FROM `users` ORDER BY `purchasesAmount` DESC LIMIT 10;");
		$topRank = 10;
		while ($row = mysqli_fetch_array($list)) 
		{
			if($row['id'] == $userInfo['id'])
			{
				$price = floor($price * ((100 - $topRank) / 100));
				break;
			}
			$topRank = $topRank - 1;
		}

		if($userInfo['balance'] < floor($price)){
			$error = "На покупку вам не хватает " . floor(($price - $userInfo['balance'])) . " руб.";
		}else{
			mysqli_query($_MS_ID, "UPDATE `users` SET `balance` = `balance` - '{$price}', `purchasesAmount` = `purchasesAmount` + '{$price}',`purchasesCount` = `purchasesCount` + '1' WHERE `id` = '{$userId}';");
			$addOrder = "INSERT INTO `orders`(`userId`, `ip`, `category`, `count`, `price`) 
						 VALUES ('{$userId}', '{$_SERVER['REMOTE_ADDR']}', '{$idCategory}', '{$countUser}', '{$price}');";
			mysqli_query($_MS_ID, $addOrder) or $error = "Неизвестная ошибка, попробуйте позже.";
			$idOrder = mysqli_insert_id($_MS_ID);
		}
	}

	$_SESSION['rand_code'] = null;

	$data = json_encode(array('errorMsg' => $error, 'idOrder' => $idOrder), JSON_UNESCAPED_UNICODE);
	echo $data;
?>
